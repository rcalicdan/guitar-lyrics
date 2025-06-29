<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Authentication Configuration
 */
class LarabridgeAuthentication extends BaseConfig
{
    /**
     * User model class to use for authentication
     */
    public string $userModel = \App\Models\User::class;

    /**
     * Email Verification View Path
     */
    public string $emailVerificationViewPath = AUTH_EMAIL_PATH.'email-verification.php';

    /**
     * Password Reset View Path
     */
    public string $passwordResetViewPath = AUTH_EMAIL_PATH.'password-reset.php';

    /**
     * Default redirect after login
     */
    public string $loginRedirect = '/dashboard';

    /**
     * Default redirect after logout
     */
    public string $logoutRedirect = '/';

    /**
     * Login page URL
     */
    public string $loginUrl = '/login';

    /**
     * Password reset settings
     */
    public array $passwordReset = [
        'tokenExpiry' => 3600, // 1 hour in seconds
    ];

    /**
     * Email verification settings
     */
    public array $emailVerification = [
        'required' => false,
        'tokenExpiry' => 86400, // 24 hours in seconds
    ];

    /**
     * Remember me settings
     */
    public array $rememberMe = [
        'enabled' => true,
        'tokenExpiry' => 2592000,
        'cookieName' => 'remember_token',
        'cookieSecure' => false,
        'cookieHttpOnly' => true,
        'customHandler' => null,
    ];

    /**
     * Session settings
     */
    public array $session = [
        'regenerateOnLogin' => false,
        'regenerateOnLogout' => true,
    ];

    /**
     * Security settings
     */
    public array $security = [
        'hashAlgorithm' => PASSWORD_ARGON2ID,
        'requireEmailVerification' => true,
    ];

    /**
     * Email settings
     */
    public array $email = [
        'fromEmail' => null, // Will default to noreply@{domain}
        'fromName' => null,  // Will default to 'Your Application'
    ];
}
