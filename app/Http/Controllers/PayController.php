<?php

namespace App\Http\Controllers;

use App\Models\organization;
use Illuminate\Http\Request;

class PayController extends Controller
{

    public function payment(Request $request)
    {
        if (session()->has('organization')) {

            $request->validate([
                'phone' => [
                    'required',
                    'string',
                    'regex:/^\+250(?:78|79|72|73)\d{7}$/',
                ],
            ], [
                'phone.regex' => 'The phone number format: +250xxxxxxxxx.',
            ]);

            try {
                $organization = Organization::find(session('organization')->id); // Assuming you're storing organization data in the session
                $phone = $request->input('phone');
                $amount = 5000;

                if ($organization) {
                    $ch = curl_init('https://payment.hdev.rw/api_pay/api/HDEV-7ba5020f-046d-49f8-a1f0-20272acf3c17-ID/HDEV-67397414-8ad0-44f0-a5a2-16c7e5d5299b-KEY');

                    $data = [
                        'ref' => 'payment',
                        'tel' => $phone,
                        'amount' => $amount,
                        'link' => '',
                    ];

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                    $response = curl_exec($ch);

                    if (curl_errno($ch)) {
                        echo 'cURL Error: ' . curl_error($ch);
                    }

                    curl_close($ch);

                    $organization->update(['last_payment' => now()]);
                    return view('payment.confirmation', compact('organization'));
                } else {
                    return redirect()->route('user.org-login')->with('error', 'Organization not found.');
                }
            } catch (\Exception $e) {
                return redirect()->route('payment.payment')->with('error', 'Something went wrong. Please try again.');
            }
        } else {
            return redirect()->route('user.org-login')->with('error', 'You must log in.');
        }
    }

    public function confirm(Request $request)
    {
        try {
            $request->session()->forget('organization');
            return redirect()->route('user.org-login')->with('success', 'Payment confirmed.');
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }
}
