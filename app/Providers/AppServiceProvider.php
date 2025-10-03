<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\Content;
use Illuminate\Support\Facades\URL;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Social;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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
        // $locale = session('locale');
        // URL::defaults(['locale' => $locale]);
    
        Paginator::defaultView('vendor.pagination.tailwind');
        Blade::anonymousComponentNamespace('inno.components','inno');
        Blade::anonymousComponentNamespace('inno.layouts','innolayout');
        View::share('languages', Language::get()->keyBy('code'));
        View::share('socials', Social::get());
        View::share('settings', Setting::get()->keyBy('label'));
        
        $types = ['mobile','phone','ambulance','address','email', 'whatsapp'];
        $s_details = \App\Models\Content::whereIn('type', $types)
            ->get()
            ->groupBy('type')   // returns a Collection keyed by type
            ->map(function($group) {
                return $group->values(); // keep as Collection of models (re-indexed)
            })
            ->toArray();
        View::share('s_details', $s_details);
    }

}
