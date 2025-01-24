<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'users.name as user_name')
            ->get(); // Fetch all news with user data
        return view('news', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required | string | max:255',
            'content' => 'required | string',
        ]);

        $validatedData['user_id'] = auth()->id();

        News::create($validatedData);

        return redirect()->route('news.index')->with('success', 'News created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('news-edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validatedData = $request->validate([
            'title' => 'required | string | max:255',
            'content' => 'required | string',
        ]);

        $news->update($validatedData);

        return redirect()->route('news.index')->with('success', 'News updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news.index')->with('success', 'News deleted successfully.');
    }
}
