<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;

use App\Http\Resources\AuthorResource;
use App\Http\Resources\NewsResource;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        return AuthorResource::collection(Author::orderBy('full_name','desc')->paginate(20)->withQueryString());
    }

    public function show(Author $author)
    {
        $news = $author->news()->with('rubrics','author')->orderBy('publish_date', 'desc')->paginate(20)->withQueryString();
        return NewsResource::collection($news);
    }

    public function store(StoreAuthorRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $author = Author::create($validated);
        return new AuthorResource($author);
    }
}
