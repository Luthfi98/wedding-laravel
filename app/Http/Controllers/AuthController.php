<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Check if login input is email or username
        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Set the login type
        $credentials[$login_type] = $request->input('login');
        unset($credentials['login']);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            LogActivity::insertData($credentials, 'users');

            return redirect()->route('dashboard')->with('success', 'Login success');
        }

        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function profile()
    {
        $data = [
            'title' => __('Profile')
        ];
        return view('auth.profile')->with($data);
    }
} 