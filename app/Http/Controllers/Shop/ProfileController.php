<?php

namespace App\Http\Controllers\Shop;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class ProfileController extends Controller
{
    /**
     * Displays the user's profile information.
     *
     * @param  Illuminate\Http\Request  $request
     * @return  Illuminate\View\View
     */
    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }
    
    /**
     * Displays the edit user form for a given user.
     *
     * @param  Illuminate\Http\Request  $request
     * @return  Illuminate\Contracts\View\View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Updates the user's profile information.
     *
     * @param  App\Http\Requests\ProfileUpdateRequest  $request
     * @return  Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        if ($request->has('address_line')) {
            $user->address()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address_line' => $request->input('address_line'),
                    'city'         => $request->input('city'),
                    'postal_code'  => $request->input('postal_code'),
                    'country'      => $request->input('country', 'España'),
                    'is_default'   => true,
                ]
            );
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Updates the user's address information.
     * This function validates the input data for address line, city, and postal code.    
     * 
     * @param  Illuminate\Http\Request  $request
     * @return  Illuminate\Http\RedirectResponse
     */
    public function updateAddress(Request $request)
    {
        $validated = $request->validate([
            'address_line' => ['required', 'string', 'max:255'],
            'city'         => ['required', 'string', 'max:100'],
            'postal_code'  => ['required', 'numeric', 'digits:5'],
        ]);

        $user = $request->user();

        // 1. Search or create the address
        $address = \App\Models\Address::updateOrCreate(
            [
                'address_line' => $validated['address_line'],
                'postal_code'  => $validated['postal_code'],
                'city'         => $validated['city'],
                'user_id'      => $user->id
            ],
            $validated
        );
        return redirect()->back()->with('success', __('Address updated and linked to your profile!'));
    }
    
    /**
     * Deletes the user's account.
     *
     * @param  Illuminate\Http\Request  $request
     * @return  Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Set the given address as the default one for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function setDefaultAddress(Request $request, $id)
    {
        $user = $request->user();

        // 1. Find the address
        $address = \App\Models\Address::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // 2. Mark all the others as false
        \App\Models\Address::where('user_id', $user->id)->update(['is_default' => false]);

        // 3. Mark the selected one as true
        $address->update(['is_default' => true]);

        return redirect()->back();
    }
}
