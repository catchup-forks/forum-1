<?php

namespace App\Http\Controllers;

use App\Page;
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

        $page = Page::create([
            'title' => \request('title'),
            'seo_title' => \request('seo_title'),
            'seo_description' => \request('seo_description'),
            'body' => \request('body'),
            'slug' => str_slug(\request('title')),
            'lang' => 'sv',
        ]);

        return redirect($page->slug)->with('flash', __('Your page has been published!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //$page->recordVisit();

        return view('pages.show', ['page' => $page, 'title' => $page->title]);
    }
}
