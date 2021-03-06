<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    public function store($channelId, Thread $thread)
    {
        $reply = $thread->addReply([
            'body' => \request('body'),
            'user_id' => auth()->id(),
        ]);

        if (\request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back()->with('flash', __('Your reply has been published!'));
    }
    
    public function update(Reply $reply){
        $this->authorize('update', $reply);

        $reply->update(\request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        if (\request()->expectsJson()) {
            return response(['status' => 'Reply deleted.']);
        }

        return back()->with('flash', __('Your reply has been deleted!'));
    }
}
