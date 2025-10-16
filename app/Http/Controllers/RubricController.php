<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRubricRequest;
use App\Http\Resources\NewsResource;
use App\Http\Resources\RubricResource;
use App\Models\News;
use App\Models\Rubric;
use App\Services\RubricHelperService;

class RubricController extends Controller
{
    public function __construct(private RubricHelperService $service)
    {
    }

    public function show(Rubric $rubric)
    {
        $news = $rubric->news()->with('rubrics')->get();
        return NewsResource::collection($news);
    }

    public function allNews(Rubric $rubric)
    {
        $allRubricIds = $this->service->getDescendantIds($rubric);
        $allRubricIds[] = $rubric->id;

        $news = News::whereHas('rubrics', fn($q) => $q->whereIn('rubric_id', $allRubricIds))->get();

        return NewsResource::collection($news);
    }

    public function store(StoreRubricRequest $request)
    {
        $validated = $request->validated();
        $rubric = Rubric::create($validated);
        return new  RubricResource($rubric);
    }
}
