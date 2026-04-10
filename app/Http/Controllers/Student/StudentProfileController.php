<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('student.profile.edit', compact('user'));
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_number' => 'required|string|max:20',
            'address'        => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->contact_number = $request->contact_number;
        $user->save();

        // Update address on the students table
        if ($user->student) {
            $user->student->address = $request->address;
            $user->student->save();
        }

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