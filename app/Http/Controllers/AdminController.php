<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Opportunities;
use App\Models\Applicant;
use App\Models\Community;

class AdminController extends Controller
{

    public function adminRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:admins', 'max:255'],
            'password' => [
                'required',
                'string',
                'min:2',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*]).{2,}$/',
            ],
        ], [
            'password.regex' => 'The password must contain at least one uppercase letter and one symbol (!@#$%^&*).',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        try {
            Admin::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            return redirect()->route('admin.ad-login')->with('success', 'Registered, Make Loggin');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred during registration, Try again');
        }
    }


    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $user = Admin::where('email', $email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'Email not found'])->withInput();
            }

            if (password_verify($password, $user->password)) {
                session(['admin' => $user]);
                return redirect()->route('admin.users')->with('success', 'Logged in successfully.');
            } else {
                return back()->withErrors(['password' => 'Password doesn\'t match'])->withInput();
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong, Try again.');
        }
    }

    public function adminLogout(Request $request)
    {
        try {
            $request->session()->forget('admin');
            return redirect()->route('admin.ad-login')->with('success', 'You have been logged out.');
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }



    // USERS
    public function adminUsers()
    {
        if (session()->has('admin')) {
            // $users = User::where('status', 'active')->get();
            // $userpassive = User::where('status', 'passive')->get();
            $users = User::orderBy('status')->get();
            $organizations = Organization::all();
            $opportunities = Opportunities::all();
            $applications = Applicant::all();

            return view('admin.users', compact('users', 'organizations', 'opportunities', 'applications'));
        } else {
            return redirect()->route('admin.ad-login')->with('error', 'You must log in.');
        }
    }

    public function updateUser(Request $request, $userId)
    {

        $validatedData = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'rwandan_id' => [
                'required',
                'numeric',
                'unique:users,rwandan_id,' . $userId,
                'regex:/^[12](19\d{2}|20(0[0-7]|1[0-9]))[0-9]{11}$/',
            ],
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'phone_number' => [
                'required',
                'string',
                'unique:users,phone_number,' . $userId,
                'regex:/^\+250(?:78|79|72|73)\d{7}$/',
            ],
            'skills' => ['required', 'max:255'],
            // 'province' => 'required|string|max:255',
            // 'district' => 'required|string|max:255',
        ], [
            'rwandan_id.regex' => 'The ID is invalid.',
            'phone_number.regex' => 'The phone number must be in the format: +250xxxxxxxxx.',
        ]);

        try {
            $user = User::findOrFail($userId);

            if (!$user) {
                return redirect()->route('admin.users')->with('error', 'User not found.');
            }

            $user->update($validatedData);
            return redirect()->back()->with('success', 'User information updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    // passive users
    public function recoverUser(Request $request)
    {
        $userId = $request->input('userId');

        try {
            $user = User::find($userId);

            if ($user) {
                $user->update(['status' => 'active']);

                return redirect()->route('admin.users')->with('success', 'Account recovered successfully.');
            } else {
                return redirect()->route('admin.users')->with('error', 'User not found.');
            }
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }


    public function deleteUserAccount(Request $request)
    {
        $userId = $request->input('userId');

        try {
            $user = User::findOrFail($userId);

            if (!$user) {
                return redirect()->route('admin.users')->with('error', 'User not found.');
            }

            Applicant::where('user_id', $userId)->delete();
            $user->delete();

            return redirect()->back()->with('success', 'User account deleted successfully.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }


    // ORGANIZATIONS
    public function adminOrganizations()
    {
        if (session()->has('admin')) {
            $organizations = organization::orderBy('status')->get();
            // $orgpassive = organization::where('status', 'passive')->get();

            return view('admin.organizations', compact('organizations'));
        } else {
            return redirect()->route('admin.ad-login')->with('error', 'You must log in.');
        }
    }

    public function updateOrganization(Request $request, $organizationId)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => 'required|email|max:255|unique:organizations,email,' . $organizationId,
            'phone_number' => [
                'required',
                'unique:organizations,phone_number,' . $organizationId,
                'string',
                'regex:/^\+250(?:78|79|72|73)\d{7}$/',
            ],
            // 'province' => 'required|string|max:255',
            // 'district' => 'required|string|max:255',
            'website' => 'required|url|max:255',
            'mission' => 'required|max:255',
        ], [
            'phone_number.regex' => 'The phone number must be in the format: +250xxxxxxxxx.',
        ]);

        try {
            $organization = organization::findOrFail($organizationId);

            if (!$organization) {
                return redirect()->route('admin.organizations')->with('error', 'User not found.');
            }

            $organization->update($validatedData);
            return redirect()->back()->with('success', 'User information updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    // passive users
    public function recoverOrganization(Request $request)
    {
        $organizationId = $request->input('organizationId');

        try {
            $organization = organization::find($organizationId);

            if ($organization) {
                $organization->update(['status' => 'active']);

                return redirect()->route('admin.organizations')->with('success', 'Account recovered successfully.');
            } else {
                return redirect()->route('admin.organizations')->with('error', 'User not found.');
            }
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }


    public function deleteOrganizationAccount(Request $request)
    {
        $organizationId = $request->input('organizationId');

        try {
            $organization = Organization::findOrFail($organizationId);

            if (!$organization) {
                return redirect()->route('admin.organizations')->with('error', 'User not found.');
            }

            Applicant::where('organization_id', $organizationId)->delete();
            $organization->delete();
            return redirect()->back()->with('success', 'User account deleted successfully.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }


    // OPPORTUNITIES
    public function adminOpportunities()
    {
        if (session()->has('admin')) {
            $organizations = Organization::all();
            $opportunities = Opportunities::orderBy('status')->get();
            // $completedopp = Opportunities::whereIn('status', ['completed', 'canceled'])->get();
            
            return view('admin.opportunities', compact('organizations', 'opportunities'));
        } else {
            return redirect()->route('admin.ad-login')->with('error', 'You must log in.');
        }
    }

    public function deleteOpportunity(Request $request)
    {
        $opportunityId = $request->input('opportunityId');

        try {
            $opportunity = Opportunities::findOrFail($opportunityId);

            if (!$opportunity) {
                return redirect()->route('admin.opportunities')->with('error', 'Event not found.');
            }

            Applicant::where('opportunity_id', $opportunityId)->delete();
            $opportunity->delete();
            return redirect()->back()->with('success', 'Event deleted successfully.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
