<?php

namespace App\Http\Controllers\Auth;

class AdminRegisterController extends RegisterController
{
    /**
     * Show the admin registration form.
     */
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }
}
