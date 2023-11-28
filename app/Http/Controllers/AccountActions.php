<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\organization;
use App\Models\Opportunities;
use App\Models\Applicant;
use App\Models\Community;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Validator;
use Twilio\Exceptions\TwilioException;

class AccountActions extends Controller
{
    // inside accounts
    // cadidate
    public function candHome()
    {
        if (session()->has('user')) {
            // $users = User::all();
            $organizations = Organization::all();
            $loggedInUser = session('user');
            $applications = Applicant::where('user_id', $loggedInUser->id)->get();
            $opportunities = Opportunities::where('status', 'ongoing')->get();

            // $opportunities = $opportunities->shuffle();

            $userAppliedToThisOpportunity = function ($userId, $opportunityId) {
                $existingApplication = Applicant::where('user_id', $userId)
                    ->where('opportunity_id', $opportunityId)
                    ->first();
                return $existingApplication !== null;
            };

            return view('cand.home', compact('loggedInUser', 'organizations', 'opportunities', 'userAppliedToThisOpportunity'));
        } else {
            return redirect()->route('user.vol-login')->with('error', 'You must log in.');
        }
    }

    public function candDashboard()
    {
        if (session()->has('user')) {
            // $users = User::all();
            $organizations = Organization::all();
            $opportunities = Opportunities::all();
            $loggedInUser = session('user');
            $applications = Applicant::where('user_id', $loggedInUser->id)->orderBy('status')->get();

            return view('cand.dashboard', compact('loggedInUser', 'organizations', 'opportunities', 'applications'));
        } else {
            return redirect()->route('user.vol-login')->with('error', 'You must log in.');
        }
    }

    public function candPastEvent()
    {
        if (session()->has('user')) {
            // $users = User::all();
            $organizations = Organization::all();
            $loggedInUser = session('user');
            $applications = Applicant::where('user_id', $loggedInUser->id)->get();
            $opportunities = Opportunities::where('status', 'completed')->get();

            return view('cand.pastevent', compact('loggedInUser', 'organizations', 'opportunities'));
        } else {
            return redirect()->route('user.vol-login')->with('error', 'You must log in.');
        }
    }

    public function community()
    {
        if (session()->has('user')) {
            $users = User::all();
            $organizations = Organization::all();
            $loggedInUser = session('user');

            $userPosts = Community::whereNotNull('user_id')->get();
            $orgPosts = Community::whereNotNull('organization_id')->get();

            $allPosts = $userPosts->merge($orgPosts)->sortBy('created_at');

            return view('cand.community', compact('loggedInUser', 'organizations', 'users', 'allPosts'));
        } else {
            return redirect()->route('user.vol-login')->with('error', 'You must log in.');
        }
    }

    public function settings()
    {
        if (session()->has('user')) {
            $organizations = Organization::all();
            $opportunities = Opportunities::all();
            $loggedInUser = session('user');

            return view('cand.settings', compact('loggedInUser', 'organizations', 'opportunities'));
        } else {
            return redirect()->route('user.vol-login')->with('error', 'You must log in.');
        }
    }

    public function support()
    {
        if (session()->has('user')) {
            $users = User::all();
            $organizations = Organization::all();
            $opportunities = Opportunities::all();
            $loggedInUser = session('user');
            $applications = Applicant::where('user_id', $loggedInUser->id)->get();

            return view('cand.support', compact('loggedInUser', 'organizations', 'opportunities'));
        } else {
            return redirect()->route('user.vol-login')->with('error', 'You must log in.');
        }
    }


    // company
    public function orgDashboard()
    {
        if (session()->has('organization')) {
            $users = User::all();
            $organizations = Organization::all();
            $loggedInOrganization = session('organization');
            $opportunities = Opportunities::where('organization_id', $loggedInOrganization->id)->get();

            return view('org.dashboard', compact('users', 'loggedInOrganization', 'opportunities'));
        } else {
            return redirect()->route('user.org-login')->with('error', 'You must log in.');
        }
    }

    public function orgApplicants()
    {
        if (session()->has('organization')) {
            $users = User::all();
            $organizations = Organization::all();
            $loggedInOrganization = session('organization');
            $opportunities = Opportunities::where('organization_id', $loggedInOrganization->id)->get();
            $applications = Applicant::where('organization_id', $loggedInOrganization->id)->get();

            return view('org.applicants', compact('users', 'loggedInOrganization', 'opportunities', 'applications'));
        } else {
            return redirect()->route('user.org-login')->with('error', 'You must log in.');
        }
    }

    public function newPost(Request $request)
    {
        if (session()->has('organization')) {
            $users = User::all();
            $organizations = Organization::all();
            $opportunities = Opportunities::all();

            // return view('org.newpost', compact('users', 'organizations'));
            $validatedData = $request->validate([
                'organization_id' => 'required|exists:organizations,id',
                'title' => 'required|string',
                'description' => 'required|string',
                'category' => 'required|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date',
                'province' => 'required|string',
                'district' => 'required|string',
                'skills' => 'required|string',
                'vol_number' => 'required|string',
                'age' => 'required|string',
                'benefit' => 'required|string',
                'logoImage' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
                'status' => 'required|string',
            ]);

            $organizationId = session('organization')->id;
            $validatedData['organization_id'] = $organizationId;

            if (empty($organizationId)) {
                return redirect()->route('user.org-login')->with('error', 'You must log in as an organization.');
            }

            // Handle file upload
            if ($request->hasFile('logoImage')) {
                $file = $request->file('logoImage');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/opportunity_images', $fileName);
                $validatedData['logoImage'] = 'opportunity_images/' . $fileName;
            }

            try {
                Opportunities::create($validatedData);


                $district = $validatedData['district'];
                $usersInDistrict = User::where('district', $district)->get();

                foreach ($usersInDistrict as $user) {
                    // Use the SMS gateway to send notifications
                    $newphone = $user->phoneNumber = str_replace('+25', '', $user->phone_number);

                    $ch = curl_init('https://sms.hdev.rw/api_pay/api/HDEV-7ba5020f-046d-49f8-a1f0-20272acf3c17-ID/HDEV-67397414-8ad0-44f0-a5a2-16c7e5d5299b-KEY');

                    $data = [
                        'ref' => 'sms',
                        'sender_id' => 'N-SMS',
                        'tel' => $newphone,
                        'message' => "Greetings from VolunteerPortal,\nNew Opportunity is posted in your district '$district', login to check volunteerportal.rw",
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
                    // return $response;
                    // sleep(20);// Sleep for 1 second
                    // dd($data);
                }
                return redirect()->route('org.newpost', compact('users', 'organizations', 'opportunities'))->with('success', 'Opportunity posted successfully.');
            } catch (\Exception $e) {
                // dd($e);
                return redirect()->route('org.newpost', compact('users', 'organizations', 'opportunities'))->with('error', 'An error occurred while posting the opportunity.');
            }
        } else {
            return redirect()->route('user.org-login')->with('error', 'You must log in.');
        }
    }

    public function orgCommunity()
    {
        if (session()->has('organization')) {
            $users = User::all();
            $organizations = Organization::all();
            $loggedInUser = session('organization');

            $userPosts = Community::whereNotNull('user_id')->get();
            $orgPosts = Community::whereNotNull('organization_id')->get();

            $allPosts = $userPosts->merge($orgPosts)->sortBy('created_at');

            return view('org.community', compact('loggedInUser', 'organizations', 'users', 'allPosts'));
        } else {
            return redirect()->route('user.org-login')->with('error', 'You must log in.');
        }
    }

    public function orgSupport()
    {
        if (session()->has('organization')) {
            $users = User::all();
            $organizations = Organization::all();
            $opportunities = Opportunities::all();

            return view('org.support', compact('users', 'organizations'));
        } else {
            return redirect()->route('user.org-login')->with('error', 'You must log in.');
        }
    }

    public function orgSettings()
    {
        if (session()->has('organization')) {
            $loggedInOrg = session('organization');

            return view('org.settings', compact('loggedInOrg'));
        } else {
            return redirect()->route('user.org-login')->with('error', 'You must log in.');
        }
    }





    // APPLICATION
    public function apply(Request $request, $opportunityId)
    {
        if (session()->has('user')) {
            $user = session('user');

            // Retrieve other data you need
            $users = User::all();
            $organizations = Organization::all();
            $opportunities = Opportunities::all();

            $userId = $user->id;
            $opportunity = Opportunities::findOrFail($opportunityId);
            $organizationId = $opportunity->organization->id;

            $existingApplication = Applicant::where('user_id', $userId)
                ->where('opportunity_id', $opportunityId)
                ->first();
            // dd($existingApplication);
            if ($existingApplication) {
                return redirect()->route('cand.home')->with('error', 'You have already applied to this opportunity.');
            }

            Applicant::create([
                'user_id' => $userId,
                'opportunity_id' => $opportunityId,
                'organization_id' => $organizationId,
                'status' => 'pending',
            ]);

            return redirect()->route('cand.home', compact('users', 'organizations', 'opportunities'))->with('success', 'Application sent successfully.');
        } else {
            return redirect()->route('user.vol-login')->with('error', 'You must log in.');
        }
    }
}
