<?php

namespace App\Console\Commands;

use App\Models\Borrow;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class RecomputeFines extends Command
{
    protected $signature = 'app:recompute-fines';

    protected $description = 'Recompute all borrow item fines and transaction totals using whole-day calculation';

    public function handle(): int
    {
        $transactions = Borrow::with('items.book')->get();
        $this->info("Found {$transactions->count()} borrow transactions to recompute.");

        foreach ($transactions as $transaction) {
            $dueDate = Carbon::parse($transaction->due_date);

            foreach ($transaction->items as $item) {
                // Only recompute fines for items that have been returned (partially or fully)
                if ($item->returned_quantity <= 0) {
                    $item->fine = 0;
                    $item->save();

                    continue;
                }

                // Use last_returned_at if available, otherwise use returned_at from transaction
                $returnDate = $item->last_returned_at
                    ? Carbon::parse($item->last_returned_at)
                    : ($transaction->returned_at ? Carbon::parse($transaction->returned_at) : Carbon::now());

                $overdueDays = $returnDate->greaterThan($dueDate)
                    ? (int) abs($returnDate->diffInDays($dueDate))
                    : 0;

                $newFine = Borrow::FINE_PER_DAY * $overdueDays * $item->returned_quantity;

                $this->line("  Item #{$item->id} (book #{$item->book_id}): old fine=₱{$item->fine} → new fine=₱{$newFine} ({$overdueDays} overdue days × {$item->returned_quantity} returned)");

                $item->fine = $newFine;
                $item->save();
            }

            $transaction->recomputeTotalFine();
            $this->info("Transaction #{$transaction->id}: total_fine = ₱{$transaction->total_fine}");
        }

        $this->info('All fines recomputed successfully.');

        return self::SUCCESS;
    }
}
