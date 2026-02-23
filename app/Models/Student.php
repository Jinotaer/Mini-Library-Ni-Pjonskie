<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['student_number','first_name','last_name','course','email','contact'];

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function borrowTransactions()
    {
        return $this->hasMany(Borrow::class);
    }
}