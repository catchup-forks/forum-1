<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create');
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
        ]);

        $thread = Page::create([
            'user_id' => auth()->id(),
            'title' => \request('title'),
            'seo_title' => \request('seo_title'),
            'seo_description' => \request('seo_description'),
            'body' => \request('body'),
            'slug' => str_slug(\request('title')),
            'lang' => 'sv',
        ]);

        $thread->subscribe();

        return redirect($thread->path())->with('flash', __('Your page has been published!'));
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

        $thread->recordVisit();

        return view('threads.show', ['thread' => $thread, 'title' => $thread->title]);
    }
}
