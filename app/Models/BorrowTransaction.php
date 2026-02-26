<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class BorrowTransaction extends Borrow
{
    use HasFactory;

    protected $table = 'borrows';

    // This class acts as an alias for existing `Borrow` model so controllers
    // referring to `BorrowTransaction` work without renaming files everywhere.
}
