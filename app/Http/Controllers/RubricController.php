<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRubricRequest;
use App\Http\Resources\NewsResource;
use App\Http\Resources\RubricResource;
use App\Models\Rubric;

class RubricController extends Controller
{
    public function index()
    {
        return RubricResource::collection(Rubric::all());
    }

    public function show(Rubric $rubric)
    {
        $news = $rubric->news()->with('rubrics')->get();
        return NewsResource::collection($news);
    }

    public function store(StoreRubricRequest $request)
    {
        $validated = $request->validated();
        $rubric = Rubric::create($validated);
        return new  RubricResource($rubric);
    }
}
