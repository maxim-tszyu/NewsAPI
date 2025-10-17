<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function search(Request $request)
    {
        $query = News::query();

        if ($request->has('query')) {
            $query->where('title', 'like', '%' . $request->query('query') . '%');
        }

        return NewsResource::collection(
            $query->with('rubrics', 'author')->orderBy('publish_date', 'desc')->paginate(20)->withQueryString()
        );
    }

    public function store(StoreNewsRequest $request)
    {
        $validated = $request->validated();

        $rubrics = $validated['rubrics'];
        unset($validated['rubrics']);

        $news = News::create($validated);

        if (!empty($rubrics)) {
            $news->rubrics()->attach($rubrics);
        }

        $news->load(['author', 'rubrics']);

        return new NewsResource($news);
    }

    public function show(News $news)
    {
        return new NewsResource($news);
    }
}
