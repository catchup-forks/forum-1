<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class UserAvatarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        $this->validate(\request(), [
            'avatar' => 'required|image'
        ]);

        $file = \request()->file('avatar')->store('avatars', 'public');

        auth()->user()->update([
            'avatar_path' => $file
        ]);

        return response('', 204);
    }
}
