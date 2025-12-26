<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Hapus constructor middleware, akan menggunakan route middleware sebagai gantinya
    
    public function show()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        
        $user = Auth::user();
        
        // Validasi dengan email yang unik kecuali untuk user saat ini
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'password' => 'nullable|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'password_confirmation' => 'same:password',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->role = $request->role;
            $user->branch = $request->branch;
            $user->jabatan = $request->jabatan;
            
            // Update password jika diisi
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Hapus foto lama jika ada
                if ($user->photo && Storage::exists('public/' . $user->photo)) {
                    Storage::delete('public/' . $user->photo);
                }
                
                $path = $request->file('photo')->store('profile', 'public');
                $user->photo = $path;
            }
            
            $user->save();
            return redirect()->route('welcome')->with('success', 'Profile updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update profile: ' . $e->getMessage())->withInput();
        }
    }
}