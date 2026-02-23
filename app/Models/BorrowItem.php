<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowItem extends Model
{
    use HasFactory;

    protected $table = 'borrow_items';

    protected $fillable = [
        'borrow_id',
        'book_id',
        'quantity',
        'returned_quantity',
        'last_returned_at',
        'fine',
    ];

    protected $dates = ['last_returned_at'];

    public function transaction()
    {
        return $this->belongsTo(Borrow::class, 'borrow_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
