<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\Department;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Social;
use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;

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
    
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        Blade::anonymousComponentNamespace('inno.components','inno');
        Blade::anonymousComponentNamespace('inno.layouts','innolayout');
        View::share('languages', Language::get()->keyBy('code'));
        View::share('socials', Social::get());
        View::share('settings', Setting::get()->keyBy('label'));

        View::share('booked_dates', self::getFullyBookedDates());
    }

    private static function getFullyBookedDates()
    {
        // Query the orders to find dates with 7 or more orders
        $fullyBookedDates = Order::selectRaw('DATE(order_date) as order_date, COUNT(*) as order_count')
            ->groupBy('order_date')
            ->having('order_count', '>=', 7)
            ->whereIn('status', ['pending', 'completed'])
            ->pluck('order_date') // Get the dates only
            ->toArray(); // Convert to an array

        return $fullyBookedDates ?: []; // Return as JSON
    }
}
