<?php

namespace App\Providers;

use App\Models\BorrowTransaction;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.header-sections.headers', function (ViewContract $view): void {
            $today = now()->toDateString();

            $overdueBorrows = BorrowTransaction::with(['student', 'items.book'])
                ->whereNull('returned_at')
                ->whereDate('due_date', '<', $today)
                ->orderBy('due_date')
                ->limit(5)
                ->get();

            $overdueCount = BorrowTransaction::query()
                ->whereNull('returned_at')
                ->whereDate('due_date', '<', $today)
                ->count();

            $view->with([
                'overdueBorrows' => $overdueBorrows,
                'overdueCount' => $overdueCount,
            ]);
        });
    }
}
