<?php

namespace App\Http\Controllers;

use App\Http\Requests\StripeRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    public function settings()
    {
        return view('frontend.settings', [
            'stripePublicKey' => setting('stripe_public_key', ''),
            'stripeSecretKey' => setting('stripe_secret_key', ''),
        ]);
    }

    public function update(StripeRequest $request)
    {
        foreach ([
            'stripe_public_key',
            'stripe_secret_key'
        ] as $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $request->input($key)]
            );
        }
        return redirect()->route('settings')->with('success', 'Settings updated successfully.');
    }
}
