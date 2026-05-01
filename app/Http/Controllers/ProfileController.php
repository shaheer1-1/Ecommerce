<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load('addresses', 'paymentMethods');
        $addr = $user->addresses->first();
        return view('frontend.profile', [
            'user' => $user,
            'addr' => $addr,
            'stripePublicKey' => setting('stripe_public_key', ''),
            'paymentMethods' => $user->paymentMethods()->orderByDesc('is_primary')->orderByDesc('id')->get(),
        ]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
            $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => !empty($validated['password'])
                ? Hash::make($validated['password'])
                : $user->password,
        ]);
            $addressData = collect($validated)->only([
            'billing_address',
            'billing_city',
            'billing_state',
            'billing_country',
            'billing_zip',
            'shipping_address',
            'shipping_city',
            'shipping_state',
            'shipping_country',
            'shipping_zip',
        ])->toArray();
        $address = $user->addresses()->first();

        if ($address) {
            $address->update($addressData);
        } else {
            $user->addresses()->create($addressData);
        }
    
        return redirect()
            ->route('profile')
            ->with('success', 'Profile updated successfully.');
    }
    public function adminprofile()
    {
        return view('admin.profile');
    }
    
}
