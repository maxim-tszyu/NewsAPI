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
        return AuthorResource::collection(Author::all());
    }

    public function show(Author $author)
    {
        $news = $author->news()->with('rubrics')->get();
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
