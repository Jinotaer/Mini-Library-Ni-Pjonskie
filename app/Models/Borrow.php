<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Borrow extends Model
{
    use HasFactory;

    public const FINE_PER_DAY = 10;

    protected $fillable = ['student_id', 'user_id', 'borrow_date', 'due_date', 'total_fine', 'returned_at'];

    protected function casts(): array
    {
        return [
            'borrow_date' => 'date',
            'due_date' => 'date',
            'returned_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BorrowItem::class, 'borrow_id');
    }

    public function recomputeTotalFine(): void
    {
        $this->total_fine = $this->items()->sum('fine');
        $this->save();
    }

    public function getCurrentFineAttribute(): float
    {
        $items = $this->relationLoaded('items') ? $this->items : $this->items()->get();
        $paidFine = (float) $items->sum('fine');
        $initialFine = (float) $this->total_fine;

        if ($this->returned_at !== null) {
            return $paidFine + $initialFine;
        }

        $today = Carbon::now();
        $dueDate = Carbon::parse($this->due_date);

        if ($today->lessThanOrEqualTo($dueDate)) {
            return $paidFine + $initialFine;
        }

        $overdueDays = (int) abs($today->diffInDays($dueDate));
        $remainingCount = $items->sum(function (BorrowItem $item): int {
            $remaining = $item->quantity - $item->returned_quantity;

            return $remaining > 0 ? $remaining : 0;
        });

        return $paidFine + $initialFine + ($overdueDays * self::FINE_PER_DAY * $remainingCount);
    }
}
