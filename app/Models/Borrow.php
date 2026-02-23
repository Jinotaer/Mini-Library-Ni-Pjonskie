<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','user_id','borrow_date','due_date','total_fine','returned_at'];

    protected $dates = ['borrow_date','due_date','returned_at'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function items()
    {
        return $this->hasMany(BorrowItem::class);
    }

    public function recomputeTotalFine()
    {
        $this->total_fine = $this->items()->sum('fine');
        $this->save();
    }
}