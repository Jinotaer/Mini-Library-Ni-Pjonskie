<?php

namespace App\Http\Controllers;

use App\Models\BorrowTransaction;
use App\Models\BorrowItem;
use App\Models\Book;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // staff only
    }

    public function index()
    {
        $transactions = BorrowTransaction::with('student')->latest()->paginate(15);
        return view('borrows.index', compact('transactions'));
    }

    public function create()
    {
        $books = Book::where('available_copies', '>', 0)->orderBy('title')->get();
        $students = Student::orderBy('last_name')->get();
        return view('borrows.create', compact('books','students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($data) {
            $transaction = BorrowTransaction::create([
                'student_id' => $data['student_id'],
                'user_id' => auth()->id(),
                'borrow_date' => $data['borrow_date'],
                'due_date' => $data['due_date'],
                'total_fine' => 0,
            ]);

            foreach ($data['books'] as $line) {
                $book = Book::findOrFail($line['book_id']);
                $qty = (int)$line['quantity'];

                if ($book->available_copies < $qty) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'books' => "Not enough copies available for book: {$book->title}"
                    ]);
                }

                // decrement available
                $book->available_copies -= $qty;
                $book->save();

                BorrowItem::create([
                    'borrow_id' => $transaction->id,
                    'book_id' => $book->id,
                    'quantity' => $qty,
                    'returned_quantity' => 0,
                    'fine' => 0,
                ]);
            }
        });

        return redirect()->route('borrows.index')->with('success', 'Borrow transaction recorded.');
    }

    public function show(BorrowTransaction $borrow)
    {
        $borrow->load('student','items.book');
        return view('borrows.show', ['borrowTransaction' => $borrow]);
    }

    public function edit(BorrowTransaction $borrow)
    {
        // editing borrow transaction (limited) - optional
        $borrow->load('items.book','student');
        return view('borrows.edit', compact('borrow'));
    }

    public function update(Request $request, BorrowTransaction $borrow)
    {
        // Typically you don't allow changing core borrow items easily; implement if needed
        $data = $request->validate([
            'due_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $borrow->update([
            'due_date' => $data['due_date'],
        ]);

        return redirect()->route('borrows.show', $borrow)->with('success', 'Borrow updated.');
    }

    public function destroy(BorrowTransaction $borrow)
    {
        // Cancel transaction only if nothing returned and you want to roll back copies
        $hasReturns = $borrow->items()->where('returned_quantity', '>', 0)->exists();
        if ($hasReturns) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete a transaction with returns']);
        }

        DB::transaction(function () use ($borrow) {
            // restore available copies
            foreach ($borrow->items as $item) {
                $book = $item->book;
                $book->available_copies += $item->quantity;
                $book->save();
            }

            $borrow->items()->delete();
            $borrow->delete();
        });

        return redirect()->route('borrows.index')->with('success', 'Borrow transaction deleted.');
    }

    /**
     * Custom action: partial return for a borrow item.
     * Register route manually (see below).
     *
     * Request: return_quantity (int), borrow_item_id (optional if passed in URL)
     */
    public function returnItem(Request $request, $borrowItemId)
    {
        $data = $request->validate([
            'return_quantity' => 'required|integer|min:1',
        ]);

        $returnQty = (int)$data['return_quantity'];

        $item = BorrowItem::findOrFail($borrowItemId);
        $transaction = $item->transaction;
        $book = $item->book;

        $remaining = $item->quantity - $item->returned_quantity;
        if ($returnQty > $remaining) {
            return redirect()->back()->withErrors(['return_quantity' => 'Return quantity exceeds remaining borrowed quantity.']);
        }

        DB::transaction(function () use ($item, $transaction, $book, $returnQty) {
            $returnDate = Carbon::now();
            $dueDate = Carbon::parse($transaction->due_date);
            $overdueDays = $returnDate->greaterThan($dueDate) ? $returnDate->diffInDays($dueDate) : 0;
            $partialFine = 10 * $overdueDays * $returnQty;

            $item->returned_quantity += $returnQty;
            $item->last_returned_at = $returnDate;
            $item->fine += $partialFine;
            $item->save();

            // update book availability
            $book->available_copies += $returnQty;
            $book->save();

            // recompute transaction total fine
            $transaction->recomputeTotalFine();

            // if all items fully returned -> mark returned_at
            $allReturned = $transaction->items()->get()->every(function ($it) {
                return $it->returned_quantity >= $it->quantity;
            });

            if ($allReturned) {
                $transaction->returned_at = $returnDate;
                $transaction->save();
            }
        });

        return redirect()->back()->with('success', 'Return processed.');
    }
}