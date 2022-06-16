<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        return view('admin.component.login');
    }
}
