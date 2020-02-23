<?php

namespace App\Providers;

use App\Buyer;
use App\Policies\BuyerPolicy;
use App\Policies\SellerPolicy;
use App\Policies\UserPolicy;
use App\Seller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class,
        Seller::class => SellerPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinute(60));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(10));
        Passport::enableImplicitGrant();
        Passport::tokensCan([
            'purchase-product' => 'Create a new transaction for a specific product',
            'manage-products' => 'create, read, update, and delete, product (CRUD)',
            'manage-account' => 'Read your account data, id, name, email, if verified, and if admin (cannot read password), modify your account data (email, and password), cannot delete your account',
            'read-general' => 'Read general information like purchasing categories, purchased products, selling products, selling categories, your transactions (purchases and sales)'
        ]);
    }
}
