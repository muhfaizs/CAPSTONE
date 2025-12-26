<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required', // bisa email atau username
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->orWhere('name', $request->email)
            ->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); // memastikan Auth::user() tidak null
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            return redirect('/welcome');
        } else {
            return back()->with('error', 'Email atau Password salah');
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255',
            'role' => 'required|in:HRD,Employee',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',      // at least one lowercase
                'regex:/[A-Z]/',      // at least one uppercase
                'regex:/[0-9]/',      // at least one digit
                'regex:/[@$!%*#?&]/', // at least one special char
            ],
        ]);
        $user = new User();
        $user->name = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('login')->with('success', 'Account created! Please log in.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'user' => 'required', // username atau email
            'new_password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ]);

        $user = \App\Models\User::where('name', $request->user)
            ->orWhere('email', $request->user)
            ->first();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }
        $user->password = bcrypt($request->new_password);
        $user->save();

        // Send email notification
        \Mail::raw('password telah dibuat', function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Baru');
        });

        return redirect()->route('login')->with('success', 'Password updated! Please log in with your new password.');
    }
} 