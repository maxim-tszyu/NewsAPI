<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\StoreAuthorRequest;
use App\Http\Resources\api\v1\AuthorResource;
use App\Http\Resources\api\v1\NewsResource;
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
