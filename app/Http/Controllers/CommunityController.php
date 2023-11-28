<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;

class CommunityController extends Controller
{

    public function store(Request $request)
    {
        if (session()->has('user')) {
            $request->validate([
                'content' => 'required',
            ]);

            $loggedInUser = session('user');

            Community::create([
                'content' => $request->content,
                'user_id' => $loggedInUser->id,
            ]);

            return redirect()->route('cand.community');
        } else {
            return redirect()->route('user.vol-login')->with('error', 'You must log in.');
        }
    }

    public function storeOrgCommunity(Request $request)
    {
        if (session()->has('organization')) {
            $request->validate([
                'content' => 'required',
            ]);

            $loggedInOrganization = session('organization');

            Community::create([
                'content' => $request->content,
                'organization_id' => $loggedInOrganization->id,
            ]);

            return redirect()->route('org.community');
        } else {
            return redirect()->route('user.org-login')->with('error', 'You must log in.');
        }
    }
}
