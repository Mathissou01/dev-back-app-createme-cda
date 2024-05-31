<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
     
        return view('profile.edit', [
            'admin' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $admin = $request->user()->fill($request->validated());

        $rules = [
            'name' => 'required|max:50',
            'photo' => 'image|file|max:1024',
            'email' => 'required|email|max:50|unique:users,email,'.$admin->id,
            'username' => 'required|min:4|max:25|alpha_dash:ascii|unique:users,username,'.$admin->id
        ];

        $validatedData = $request->validate($rules);

        if ($validatedData['email'] != $admin->email) {
            $validatedData['email_verified_at'] = null;
        }

        /**
         * Handle upload image
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/profile/';

            /**
             * Delete an image if exists.
             */
            if($admin->photo){
                Storage::delete($path . $admin->photo);
            }

            /**
             * Store an image to Storage.
             */
            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Admin::where('id', $admin->id)->update($validatedData);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile has been updated!');
    }

    public function settings(Request $request): View
    {
        return view('profile.settings', [
            'admin' => $request->user(),
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $admin = $request->user();

        Auth::logout();

        $admin->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect()
            ->to('/');
    }
}
