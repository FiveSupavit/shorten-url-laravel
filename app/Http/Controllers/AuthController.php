<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route('shorten.index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginInput = $request->input('email_username');
        $password = $request->input('password');

        $rules = [
            'email_username' => 'required|string',
            'password' => 'required|string',
        ];

        if (strpos($loginInput, '@') !== false) {
            $rules['email_username'] .= '|email';
        }

        $messages = [
            'email_username.required' => 'กรุณากรอกอีเมลหรือชื่อผู้ใช้งาน',
            'email_username.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ];

        $request->validate($rules, $messages);

        $login_type = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($login_type, $loginInput)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email_username' => ['ไม่พบบัญชีผู้ใช้นี้ในระบบ'],
            ]);
        }

        if (!Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['รหัสผ่านไม่ถูกต้อง'],
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/shorten');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false
        ]);

        auth()->login($user);

        return redirect()->route('shorten.index');
    }
}
