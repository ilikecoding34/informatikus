<?php

namespace App\Http\Controllers\Auth;

class AdminLoginController extends LoginController
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Redirect after login (same as main app).
     */
    protected function redirectTo()
    {
        return config('app.home', '/');
    }
}
