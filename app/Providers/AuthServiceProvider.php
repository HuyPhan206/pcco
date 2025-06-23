<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Address;
use App\Policies\AddressPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Address::class => AddressPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}