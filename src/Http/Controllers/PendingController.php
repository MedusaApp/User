<?php

namespace Personality\Http\Controllers;

use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use Personality\Models\User;
use App\Http\Controllers\Controller;

class PendingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function getPendingUsers()
    {
        return Laratables::recordsOf(User::class, function($query) {
            return $query->where('membership_status', 'pending');
        });
    }

    public function index()
    {
        return view('personality::admin.pending');
    }

    public function getUserInfo($id)
    {
        if ($user = User::find($id)) {
            if (is_null($user->suffix)) {
                $user->suffix = '';
            }
            // Pretty up the date for display
            $user->dob = date('F j, Y', strtotime($user->dob));
            $user->application_date = date('F j, Y', strtotime($user->application_date));
            return response()->json(['status' => 'ok', 'user' => $user]);
        }
        return response()->json(['status' => 'User not found']);
    }

    public function approveMembership($id)
    {
        if ($user = User::find($id)) {
            $user->membership_status = 'active';
            $user->assign('member');
            $user->save();
            return response()->json(['status' => 'ok']);
        }
        return response()->json(['status' => 'User not found'], 400);
    }

    public function denyMembership($id)
    {
        if ($user = User::find($id)) {
            $user->membership_status = 'denied';
            $user->save();
            return response()->json(['status' => 'ok']);
        }
        return response()->json(['status' => 'User not found'], 400);
    }
}
