<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;
use App\Models\Book;
use App\Models\BorrowItem;
use App\Models\BorrowTransaction;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // staff only
    }

    public function index(): View
    {
        return view('borrows.index', [
            'borrows' => BorrowTransaction::with(['student', 'items.book'])->latest()->paginate(15),
            'books' => Book::orderBy('title')->get(),
            'availableBooks' => Book::where('available_copies', '>', 0)->orderBy('title')->get(),
            'students' => Student::orderBy('last_name')->get(),
        ]);
    }

    public function create(): View
    {
        $books = Book::where('available_copies', '>', 0)->orderBy('title')->get();
        $students = Student::orderBy('last_name')->get();

        return view('borrows.create', compact('books', 'students'));
    }

    public function store(StoreBorrowRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $transaction = BorrowTransaction::create([
                'student_id' => $data['student_id'],
                'user_id' => auth()->id(),
                'borrow_date' => $data['borrow_date'],
                'due_date' => $data['due_date'],
                'total_fine' => (float) ($data['total_fine'] ?? 0),
            ]);

            foreach ($data['books'] as $line) {
                $book = Book::findOrFail($line['book_id']);
                $qty = (int) $line['quantity'];

                if ($book->available_copies < $qty) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'books' => "Not enough copies available for book: {$book->title}",
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

    public function show(BorrowTransaction $borrow): View
    {
        $borrow->load('student', 'items.book');

        return view('borrows.index', ['borrowTransaction' => $borrow]);
    }

    public function edit(BorrowTransaction $borrow): View
    {
        // editing borrow transaction (limited) - optional
        $borrow->load('items.book', 'student');

        return view('borrows.index', compact('borrow'));
    }

    public function update(UpdateBorrowRequest $request, BorrowTransaction $borrow): RedirectResponse
    {
        $data = $request->validated();

        $hasReturns = $borrow->items()->where('returned_quantity', '>', 0)->exists();
        if ($hasReturns) {
            return redirect()->back()->withErrors(['error' => 'Cannot edit a borrow with returned items.']);
        }

        DB::transaction(function () use ($borrow, $data) {
            $borrow->load('items.book');

            foreach ($borrow->items as $item) {
                $book = $item->book;
                if ($book) {
                    $book->available_copies += $item->quantity;
                    $book->save();
                }
            }

            $borrow->items()->delete();

            $borrow->update([
                'borrow_date' => $data['borrow_date'],
                'due_date' => $data['due_date'],
                'total_fine' => 0,
            ]);

            foreach ($data['books'] as $line) {
                $book = Book::findOrFail($line['book_id']);
                $qty = (int) $line['quantity'];

                if ($book->available_copies < $qty) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'books' => "Not enough copies available for book: {$book->title}",
                    ]);
                }

                $book->available_copies -= $qty;
                $book->save();

                BorrowItem::create([
                    'borrow_id' => $borrow->id,
                    'book_id' => $book->id,
                    'quantity' => $qty,
                    'returned_quantity' => 0,
                    'fine' => 0,
                ]);
            }
        });

        return redirect()->route('borrows.index')->with('success', 'Borrow updated.');
    }

    public function destroy(BorrowTransaction $borrow): RedirectResponse
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
    public function returnItem(Request $request, $borrowItemId): RedirectResponse
    {
        $data = $request->validate([
            'return_quantity' => 'required|integer|min:1',
        ]);

        $returnQty = (int) $data['return_quantity'];

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
            $partialFine = BorrowTransaction::FINE_PER_DAY * $overdueDays * $returnQty;

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

    public function returnAll(BorrowTransaction $borrow): RedirectResponse
    {
        $borrow->load('items.book');

        $returnDate = Carbon::now();
        $dueDate = Carbon::parse($borrow->due_date);
        $overdueDays = $returnDate->greaterThan($dueDate) ? $returnDate->diffInDays($dueDate) : 0;

        DB::transaction(function () use ($borrow, $returnDate, $overdueDays) {
            foreach ($borrow->items as $item) {
                $remaining = $item->quantity - $item->returned_quantity;
                if ($remaining <= 0) {
                    continue;
                }

                $partialFine = BorrowTransaction::FINE_PER_DAY * $overdueDays * $remaining;

                $item->returned_quantity += $remaining;
                $item->last_returned_at = $returnDate;
                $item->fine += $partialFine;
                $item->save();

                $book = $item->book;
                if ($book) {
                    $book->available_copies += $remaining;
                    $book->save();
                }
            }

            $borrow->recomputeTotalFine();

            $borrow->returned_at = $returnDate;
            $borrow->save();
        });

        return redirect()->back()->with('success', 'All items returned.');
    }
}
