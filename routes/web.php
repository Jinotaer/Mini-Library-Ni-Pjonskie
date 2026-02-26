<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalStudents = \App\Models\Student::count();
    $totalAuthors = \App\Models\Author::count();
    $totalBooks = \App\Models\Book::count();
    $totalBorrows = \App\Models\BorrowTransaction::count();

    $totalCopies = \App\Models\Book::sum('total_copies');
    $availableCopies = \App\Models\Book::sum('available_copies');
    $borrowedCopies = max($totalCopies - $availableCopies, 0);
    $availabilityPercent = $totalCopies > 0
        ? round(($availableCopies / $totalCopies) * 100)
        : 0;

    $borrowsThisMonth = \App\Models\BorrowTransaction::query()
        ->whereBetween('borrow_date', [now()->startOfMonth(), now()->endOfMonth()])
        ->count();
    $activeBorrows = \App\Models\BorrowTransaction::query()
        ->whereNull('returned_at')
        ->count();

    $recentBorrows = \App\Models\BorrowTransaction::with(['student', 'items.book'])
        ->latest()
        ->limit(5)
        ->get();

    return view('dashboard', compact(
        'totalStudents',
        'totalAuthors',
        'totalBooks',
        'totalBorrows',
        'totalCopies',
        'availableCopies',
        'borrowedCopies',
        'availabilityPercent',
        'borrowsThisMonth',
        'activeBorrows',
        'recentBorrows'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);
    Route::resource('borrows', BorrowController::class);
    Route::post('borrows/return-item/{borrowItem}', [BorrowController::class, 'returnItem'])->name('borrows.return-item');
    Route::post('borrows/return-all/{borrow}', [BorrowController::class, 'returnAll'])->name('borrows.return-all');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
