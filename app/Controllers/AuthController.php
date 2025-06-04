<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\AuditHelper;
use App\Models\User;
use App\Requests\Auth\LoginRequest;
use App\Requests\Auth\RegisterRequest;
use Rcalicdan\Ci4Larabridge\Facades\Auth;

class AuthController extends BaseController
{
    public function showLoginPage()
    {
        return blade_view('contents.auth.login');
    }

    public function showLoginCommentPage(string $slug)
    {
        return blade_view('contents.auth.login-comment', ['slug' => $slug]);
    }

    public function showRegisterPage()
    {
        return blade_view('contents.auth.register');
    }

    public function register()
    {
        $user = User::create(RegisterRequest::validateRequest());
        AuditHelper::log($user, 'user-registered', newValues: $user->toArray());
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function login()
    {
        $credentials = LoginRequest::validateRequest();

        if (Auth::attempt($credentials)) {
            return redirect()->to('/');
        }

        return redirect()->back()->withInput()->with('error', 'Invalid Email or Password');
    }

    public function loginComment(string $slug)
    {
        $credentials = LoginRequest::validateRequest();

        if (Auth::attempt($credentials)) {
            return redirect()->route('home.songs.show', [$slug]);
        }

        return redirect()->back()->withInput()->with('error', 'Invalid Email or Password');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->to('/login')->with('success', 'Logged out successfully');
    }
}
