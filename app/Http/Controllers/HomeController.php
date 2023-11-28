<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\organization;
use App\Models\Opportunities;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Twilio\Exceptions\TwilioException;

class HomeController extends Controller
{

    public function volunteerSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => ['required', 'string', 'max:50', 'alpha'],
            'lname' => ['required', 'string', 'max:50', 'alpha'],
            'profileimage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string',
            'phone_number' => [
                'required',
                'string',
                'unique:users',
                'regex:/^\+250(?:78|79|72|73)\d{7}$/',
            ],
            'password' => [
                'required',
                'string',
                'min:2',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*]).{2,}$/',
            ],
            'rwandan_id' => [
                'required',
                'string',
                'unique:users',
                'regex:/^[12](19\d{2}|20(0[0-7]|1[0-9]))[0-9]{11}$/',
            ],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'skills' => ['required', 'max:255'],
        ], [
            'phone_number.regex' => 'The phone number must be in the format: +250xxxxxxxxx.',
            'password.regex' => 'The password must contain at least one uppercase letter and one symbol (!@#$%^&*).',
            'rwandan_id.regex' => 'The invalid ID detected.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('profileimage')) {
            $file = $request->file('profileimage');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/volunteer_images', $fileName);
            $validatedData['profileimage'] = 'volunteer_images/' . $fileName;
        }

        try {
            /* Get credentials from .env */
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create($data['phone_number'], "sms");
            User::create([
                'fname' => $data['fname'],
                'lname' => $data['lname'],
                'rwandan_id' => $data['rwandan_id'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'province' => $data['province'],
                'district' => $data['district'],
                'skills' => $data['skills'],
                'password' => Hash::make($data['password']),
                'profileimage' => $validatedData['profileimage'],
                'status' => $data['status'],
            ]);
            return redirect()->route('user.vol-verification')->with(['phone_number' => $data['phone_number']])->with('success', 'Check your phone');
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Make sure you have internrt & Try again.');
        }
    }


    public function volunteerVerification(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);

        try {
            /* Get credentials from .env */
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);

            // Check if the phone number exists in the database
            $user = User::where('phone_number', $data['phone_number'])->first();

            if (!$user) {
                return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid phone number, Try to register again please.']);
            }

            // Proceed with verification
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
                ->create(['code' => $data['verification_code'], 'to' => $data['phone_number']]);

            if ($verification->valid) {
                $user = tap($user)->update(['isVerified' => true]);
                /* Authenticate user */
                Auth::login($user);
                session(['user' => $user]);
                return redirect()->route('cand.home')->with(['success' => 'Phone number verified, Logged in']);
            }

            return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid verification code entered!']);
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    public function volunteerLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $user = User::where('email', $email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'Email not found'])->withInput();
            }

            if (password_verify($password, $user->password)) {
                if ($user->status === 'passive') {
                    return back()->with('error', 'Your account is scheduled for deletion.');
                }

                session(['user' => $user]);
                return redirect()->route('cand.home')->with('success', 'Logged in successfully.');
            } else {
                return back()->withErrors(['password' => 'Password doesn\'t match'])->withInput();
            }
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    public function volunteerLogout(Request $request)
    {
        try {
            $request->session()->forget('user');
            return redirect()->route('user.vol-login')->with('success', 'You have been logged out.');
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }



    // organization
    public function organizationSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'orglogoimage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string',
            'phone_number' => [
                'required',
                'string',
                'unique:organizations',
                'regex:/^\+250(?:78|79|72|73)\d{7}$/',
            ],
            'email' => ['required', 'email', 'unique:organizations', 'max:255'],
            'website' => ['required', 'url', 'max:255'],
            'password' => [
                'required',
                'string',
                'min:2',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*]).{2,}$/',
            ],
        ], [
            'phone_number.regex' => 'The phone number must be in the format: +250xxxxxxxxx.',
            'password.regex' => 'The password must contain at least one uppercase letter and one symbol (!@#$%^&*).',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('orglogoimage')) {
            $file = $request->file('orglogoimage');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/organization_images', $fileName);
            $validatedData['orglogoimage'] = 'organization_images/' . $fileName;
        }

        try {
            /* Get credentials from .env */
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create($data['phone_number'], "sms");

            organization::create([
                'name' => $data['name'],
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
                'category' => $data['category'],
                'province' => $data['province'],
                'district' => $data['district'],
                'website' => $data['website'],
                'mission' => $data['mission'],
                'password' => Hash::make($data['password']),
                'orglogoimage' => $validatedData['orglogoimage'],
                'status' => $data['status'],
            ]);
            session(['data' => $data]);
            return redirect()->route('user.org-verification')->with(['phone_number' => $data['phone_number']])->with('success', 'Check your phone');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong, Make sure you have internrt & Try again.');
        }
    }

    public function organizationVerification(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);

        try {
            /* Get credentials from .env */
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);

            // Check if the phone number exists in the database
            $user = organization::where('phone_number', $data['phone_number'])->first();

            if (!$user) {
                return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid phone number, Try to register again please.']);
            }

            // Proceed with verification
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
                ->create(['code' => $data['verification_code'], 'to' => $data['phone_number']]);

            if ($verification->valid) {
                $user = tap($user)->update(['isVerified' => true]);
                /* Authenticate user */
                Auth::login($user);
                session(['organization' => $user]);
                return redirect()->route('org.dashboard')->with(['success' => 'Phone number verified, Logged in']);
            }

            return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid verification code entered!']);
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    public function organizationLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $organization = organization::where('email', $email)->first();
            $lognedOrgId = $organization->id;
            $activities_posted = Opportunities::where('organization_id', $lognedOrgId);

            if (!$organization) {
                return back()->withErrors(['email' => 'Email not found'])->withInput();
            }

            if (password_verify($password, $organization->password)) {
                if ($organization->status === 'passive') {
                    return back()->with('error', 'Your account is scheduled for deletion.');
                }

                if ($organization->status === 'active' && $activities_posted->count() > 10) {

                    $lastPayment = $organization->last_payment;
        
                    if (!$lastPayment || Carbon::parse($lastPayment)->addMonths(3)->isPast()) {

                        session(['organization' => $organization]);
                        return redirect()->route('payment.payment');
                    }
                }

                session(['organization' => $organization]);
                return redirect()->route('org.dashboard')->with('success', 'Logged in successfully.');
            } else {
                return back()->withErrors(['password' => 'Password doesn\'t match'])->withInput();
            }
        } catch (\Exception $e) {
            // dd($e);
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    public function organizationLogout(Request $request)
    {
        try {
            $request->session()->forget('organization');
            return redirect()->route('user.org-login')->with('success', 'You have been logged out.');
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }
}
