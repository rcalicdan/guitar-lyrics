<?php

namespace App\Libraries\Authorization;

use App\Models\Artist;
use App\Models\Song;
use App\Models\SongCategory;
use App\Models\User;
use App\Policies\ArtistPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\SongPolicy;
use App\Policies\UserPolicy;

/**
 * AuthServiceProvider
 * 
 * This class is responsible for registering authorization policies
 * throughout the application. It maps model classes to their respective
 * policy classes and registers them with the Gate.
 */
class AuthServiceProvider
{
    /**
     * The policy mappings for the application
     * 
     * This array maps model classes to their corresponding policy classes.
     * Example: 'App\Models\User::class => App\Policies\UserPolicy::class'
     * 
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        SongCategory::class => CategoryPolicy::class,
        Artist::class => ArtistPolicy::class,
        Song::class => SongPolicy::class,
    ];

    /**
     * Register all authentication and authorization services
     * 
     * This method initializes all authorization-related services,
     * including registering policies with the Gate.
     * 
     * Example usage of defining a gate:
     * ```php
     * gate()->define('view-dashboard', function($user) {
     *     return $user->isAdmin() || $user->hasRole('editor');
     * });
     * ```
     * @return void
     */
    public function register(): void
    {
        // Define your gate here
        $this->registerPolicies(); //Do not delete this line, this is required for policies to work
    }

    /**
     * Register defined policies with the Gate
     * 
     * This method reads the policy mappings from the $policies property
     * and registers each model-policy pair with the Gate instance.
     * 
     * @return void
     */
    public function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            gate()->policy($model, $policy);
        }
    }
}
