<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone_number' => ['nullable', 'string', 'max:20', 'regex:/^[\d\s\+\-\(\)]+$/'],
        ]);

        $request->user()->update($data);

        return redirect(route('dashboard') . '#profile')->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $request->user()->getAuthPassword())) {
            return back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withFragment('password');
        }

        $request->user()->update(['password' => $request->password]);

        return redirect(route('dashboard') . '#password')->with('status', 'password-updated');
    }
}
