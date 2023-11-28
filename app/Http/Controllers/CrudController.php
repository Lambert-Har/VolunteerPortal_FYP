<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\Opportunities;
use App\Models\organization;
use App\Models\User;

class CrudController extends Controller
{
    //company
    // Update Opportunity
    public function updateOpportunity(Request $request, Opportunities $opportunity)
    {
        // Validate the request data
        $validatedData = $request->validate([
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
            'logoImage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logoImage')) {
            $file = $request->file('logoImage');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/opportunity_images', $fileName);
            $validatedData['logoImage'] = 'opportunity_images/' . $fileName;
        }

        try {
            // dd($opportunity);
            $opportunity->update($validatedData);
            return redirect()->route('org.dashboard')->with('success', 'Opportunity updated successfully.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('error', 'An error occurred while updating the opportunity.');
        }
    }

    public function cancelOpportunity(Request $request)
    {
        $opportunityId = $request->input('opportunityId');

        try {
            $opportunity = Opportunities::find($opportunityId);

            if ($opportunity) {
                $opportunity->update(['status' => 'canceled']);
                Applicant::where('opportunity_id', $opportunityId)
                    ->where('status', 'pending')
                    ->update(['status' => 'canceled']);

                return redirect()->route('org.dashboard')->with('success', 'Opportunity canceled successfully.');
            }

            return redirect()->route('org.dashboard')->with('error', 'Opportunity not found.');
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    public function completeOpportunity(Request $request)
    {
        $opportunityId = $request->input('opportunityId');

        try {
            $opportunity = Opportunities::find($opportunityId);

            if ($opportunity) {
                $opportunity->update(['status' => 'completed']);
                Applicant::where('opportunity_id', $opportunityId)
                    ->where('status', ['ongoing', 'suspended'])
                    ->update(['status' => 'completed']);

                return redirect()->route('org.dashboard')->with('success', 'Opportunity completed successfully.');
            } else {
                return redirect()->route('org.dashboard')->with('error', 'Opportunity not found.');
            }
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    // public function deleteOpportunity(Request $request)
    // {
    //     $opportunityId = $request->input('opportunityId');
    //     $opportunity = Opportunities::find($opportunityId);

    //     if ($opportunity) {
    //         $opportunity->update(['status' => $opportunity->status . ' deleted']);

    //         return redirect()->route('org.dashboard')->with('success', 'Event deleted successfully.');
    //     } else {
    //         return redirect()->route('org.dashboard')->with('error', 'Event not found.');
    //     }
    // }

    public function accceptApplication(Request $request)
    {
        $applicationId = $request->input('applicationId');

        try {
            $application = Applicant::find($applicationId);

            if ($application) {
                $application->update(['status' => 'ongoing']);

                return redirect()->route('org.applicants')->with('success', 'Applicant accepted successfully.');
            } else {
                return redirect()->route('org.applicants')->with('error', 'Applicant not found.');
            }
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    public function rejectApplication(Request $request)
    {
        $applicationId = $request->input('applicationId');

        try {
            $application = Applicant::find($applicationId);

            if ($application) {
                $application->update(['status' => 'rejected']);

                return redirect()->route('org.applicants')->with('success', 'Applicant rejected successfully.');
            } else {
                return redirect()->route('org.applicants')->with('error', 'Applicant not found.');
            }
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    // public function deleteApplication(Request $request)
    // {
    //     $applicationId = $request->input('applicationId');
    //     $application = Applicant::find($applicationId);

    //     if ($application) {
    //         $application->update(['status' => $application->status . ' deleted']);

    //         return redirect()->route('org.applicants')->with('success', 'Applicant deleted successfully.');
    //     } else {
    //         return redirect()->route('org.applicants')->with('error', 'Applicant not found.');
    //     }
    // }

    public function suspendApplication(Request $request)
    {
        $applicationId = $request->input('applicationId');

        try {
            $application = Applicant::find($applicationId);

            if ($application) {
                $application->update(['status' => 'terminated']);

                return redirect()->route('org.applicants')->with('success', 'Applicant rejected successfully.');
            } else {
                return redirect()->route('org.applicants')->with('error', 'Applicant not found.');
            }
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    // Vollunteer
    public function updateUser(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'fname' => 'required|string|alpha|max:50',
            'lname' => 'required|string|alpha|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . $userId,
            'phone_number' => 'required',
            'province' => 'required',
            'district' => 'required',
            'skills' => 'required',
            'profileimage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profileimage')) {
            $file = $request->file('profileimage');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/volunteer_images', $fileName);
            $validatedData['profileimage'] = 'volunteer_images/' . $fileName;
        }

        try {
            $user = User::find($userId);
            $user->update($validatedData);
            return redirect()->route('user.vol-login')->with('success', 'Profile updated, Login again.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred, Try again.');
        }
    }

    public function updatePassUser(Request $request, $userId)
    {
        try {
            $user = User::find($userId);

            if (!$user) {
                return redirect()->route('cand.settings')->with('error', 'User not found.');
            }

            $request->validate([
                'oldpass' => 'required',
                'newpass' => [
                    'required',
                    'string',
                    'min:2',
                    'confirmed',
                    'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*]).{2,}$/',
                ],
            ], [
                'newpass.regex' => 'The password must contain at least one uppercase letter and one symbol (!@#$%^&*).',
            ]);

            if (password_verify($request->oldpass, $user->password)) {
                $user->password = password_hash($request->newpass, PASSWORD_DEFAULT);
                $user->save();

                return redirect()->route('cand.settings')->with('success', 'Password updated successfully.');
            }

            return redirect()->route('cand.settings')->with('error', 'Incorrect old password.');
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    public function deleteUser(Request $request)
    {
        $loggedInUser = $request->input('userId');

        try {
            $user = User::find($loggedInUser);

            if ($user) {
                $user->update(['status' => 'passive']);

                return redirect()->route('user.vol-login')->with('success', 'Account deleted successfully.');
            } else {
                return redirect()->route('cand.settings')->with('error', 'Something went wrong, Try again');
            }
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }



    // Organization
    public function updateOrg(Request $request, $organisationId)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'phone_number' => [
                'required',
                'string',
                'regex:/^\+250(?:78|79|72|73)\d{7}$/',
            ],
            'email' => 'required|email|max:50|unique:organizations,email,' . $organisationId,
            'category' => 'required',
            'province' => 'required',
            'district' => 'required',
            'website' => 'required', 'url', 'unique:organizations', 'max:255' . $organisationId,
            'orglogoimage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('orglogoimage')) {
            $file = $request->file('orglogoimage');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/organization_images', $fileName);
            $validatedData['orglogoimage'] = 'organization_images/' . $fileName;
        }

        try {
            $user = organization::find($organisationId);
            $user->update($validatedData);
            return redirect()->route('user.org-login')->with('success', 'Profile updated, Login again.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred, Try again.');
        }
    }

    public function updatePassOrg(Request $request, $organisationId)
    {
        try {
            $user = Organization::find($organisationId);

            if (!$user) {
                return redirect()->route('org.settings')->with('error', 'User not found.');
            }

            $request->validate([
                'oldpass' => 'required',
                'newpass' => [
                    'required',
                    'string',
                    'min:2',
                    'confirmed',
                    'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*]).{2,}$/',
                ],
            ], [
                'newpass.regex' => 'The password must contain at least one uppercase letter and one symbol (!@#$%^&*).',
            ]);

            if (password_verify($request->oldpass, $user->password)) {
                $user->password = password_hash($request->newpass, PASSWORD_DEFAULT);
                $user->save();

                return redirect()->route('org.settings')->with('success', 'Password updated successfully.');
            }

            return redirect()->route('org.settings')->with('error', 'Incorrect old password.');
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    public function deleteOrg(Request $request)
    {
        $loggedInOrg = $request->input('organisationId');

        try {
            $organozation = organization::find($loggedInOrg);

            if ($organozation) {
                $organozation->update(['status' => 'passive']);

                return redirect()->route('user.org-login')->with('success', 'Account deleted successfully.');
            } else {
                return redirect()->route('org.settings')->with('error', 'Something went wrong, Try again');
            }
        } catch (\Exception $e) {
            return back()->with('error',  'Something went wrong, Try again.');
        }
    }

    public function cancelApplication(Request $request)
    {
        try {
            $application = Applicant::findOrFail($request->applicationId);

            // Delete the application
            $application->delete();

            return redirect()->back()->with('success', 'Application deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the application');
        }
    }
}
