<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        // ✅ Fixed: was 'layouts.profile.edit' which doesn't exist
        return view('teacher.profile.edit', compact('user'));
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_number' => 'required|string|max:20',
            'address'        => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->contact_number = $request->contact_number;
        $user->address        = $request->address;
        $user->save();

        return back()->with('contact_success', 'Contact information updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'          => 'required',
            'new_password'              => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password_hash)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'])
                         ->withInput();
        }

        $user->password_hash = Hash::make($request->new_password);
        $user->save();

        Auth::login($user);

        return back()->with('password_success', 'Password updated successfully.');
    }
}