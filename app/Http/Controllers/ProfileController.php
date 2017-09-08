<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;
use Illuminate\Support\Facades\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['getMyPosition', 'myPosition']);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activitiesByDate' => Activity::feed($user, 50),
            'title' => $user->name,
        ]);
    }

    public function getMyPosition()
    {
        return view('profiles.get_position');
    }

    public function myPosition()
    {
        $user = User::find(auth()->id());
        $user->latitude = \request('latitude');
        $user->longitude = \request('longitude');
        $user->save();

        return $user;
    }
}
