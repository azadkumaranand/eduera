<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Cashier\Subscription;
use App\Models\Cashier\SubscriptionItem;

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
        // Cashier::useSubscriptionModel(Subscription::class);
        // Cashier::useSubscriptionItemModel(SubscriptionItem::class);
    }
}
