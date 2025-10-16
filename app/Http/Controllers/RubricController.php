<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRubricRequest;
use App\Http\Resources\RubricResource;
use App\Models\Rubric;

class RubricController extends Controller
{
    public function store(StoreRubricRequest $request)
    {
        $validated = $request->validated();
        $rubric = Rubric::create($validated);
        return new  RubricResource($rubric);
    }
}
