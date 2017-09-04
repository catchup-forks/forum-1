<?php

namespace App\Http\Controllers;

use App\User;
use App\Thread;
use App\Channel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filter)
    {
        $threads = Thread::latest()->filter($filter);

        if ($channel->exists) {
            $title = $channel->name;
            $threads->where('channel_id', $channel->id);
        } else {
            if (request()->has('by')) {
                $title = __('Threads by :name', ['name' => request()->input('by')]);
            } elseif (request()->has('popular')) {
                $title = __('Popular All Time');
            } elseif (request()->has('unanswered')) {
                $title = __('Unanswered Threads');
            } else {
                $title = __('All Threads');
            }

        }

        $threads = $threads->paginate();

        if (request()->wantsJson()) return $threads;

        return view('threads.index', ['threads' => $threads, 'title' => $title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => \request('channel_id'),
            'title' => \request('title'),
            'body' => \request('body'),
        ]);

        $thread->subscribe();

        return redirect($thread->path())->with('flash', __('Your thread has been published!'));
    }

    /**
     * Display the specified resource.
     *
     * @param $channelId
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
        if (auth()->check()) auth()->user()->read($thread);

        return view('threads.show', ['thread' => $thread, 'title' => $thread->title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        $this->authorize('update', $thread);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channelId, Thread $thread)
    {

        $this->authorize('delete', $thread);

        $thread->delete();

        if (\request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('threads')->with('flash', __('Your thread has been deleted!'));
    }

}
