<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'isbn', 'authors', 'total_copies', 'available_copies', 'year_published'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function borrowItems()
    {
        return $this->hasMany(BorrowItem::class);
    }
}
