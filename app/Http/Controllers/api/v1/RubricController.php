<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\StoreRubricRequest;
use App\Http\Resources\api\v1\NewsResource;
use App\Http\Resources\api\v1\RubricResource;
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
        $news = $rubric->news()->with('rubrics','author')->orderBy('publish_date', 'desc')->paginate(20)->withQueryString();
        return NewsResource::collection($news);
    }

    public function allNews(Rubric $rubric)
    {
        $allRubricIds = $this->service->getDescendantIds($rubric);
        $allRubricIds[] = $rubric->id;

        $news = News::whereHas('rubrics', fn($q) => $q->whereIn('rubric_id', $allRubricIds))->with('rubrics','author')->orderBy('publish_date','desc')->paginate(20)->withQueryString();

        return NewsResource::collection($news);
    }

    public function store(StoreRubricRequest $request)
    {
        $validated = $request->validated();
        $rubric = Rubric::create($validated);
        return new  RubricResource($rubric);
    }
}
