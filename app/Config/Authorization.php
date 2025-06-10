<?php

namespace Config;

use App\Models\Artist;
use App\Models\AuditLog;
use App\Models\Comments;
use App\Models\Feedback;
use App\Models\Song;
use App\Models\SongCategory;
use App\Models\User;
use App\Policies\ArtistPolicy;
use App\Policies\AuditLogPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CommentPolicy;
use App\Policies\FeedbackPolicy;
use App\Policies\SongPolicy;
use App\Policies\UserPolicy;
use CodeIgniter\Config\BaseConfig;

/**
 * Authorization Configuration
 *
 * This configuration class defines all authorization policies and gates
 * for the application in a centralized location.
 */
class Authorization extends BaseConfig
{
    /**
     * The policy mappings for the application
     *
     * Maps model classes to their corresponding policy classes.
     * Example: 'App\Models\User::class => App\Policies\UserPolicy::class'
     *
     * @var array<string, string>
     */
    public array $policies = [
        User::class => UserPolicy::class,
        SongCategory::class => CategoryPolicy::class,
        Artist::class => ArtistPolicy::class,
        Song::class => SongPolicy::class,
        Comments::class => CommentPolicy::class,
        Feedback::class => FeedbackPolicy::class,
        AuditLog::class => AuditLogPolicy::class,
    ];

    /**
     * Gate definitions
     *
     * Define custom gates/abilities here. Each gate should return a callable
     * that receives the user as the first parameter.
     *
     * Example usage of defining a gate:
     * ```php
     * gate()->define('view-dashboard', function($user) {
     *     return $user->isAdmin() || $user->hasRole('editor');
     * });
     *
     * @var array<string, callable>
     */
    public function gates()
    {
        gate()->define('view-dashboard', function ($user) {
            return $user->isAdmin() || $user->isModerator();
        });
    }
}
