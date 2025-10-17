<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreRubricRequest;
use App\Http\Resources\Api\V1\NewsResource;
use App\Http\Resources\Api\V1\RubricResource;
use App\Models\News;
use App\Models\Rubric;
use App\Services\RubricHelperService;

class RubricController extends Controller
{
    public function __construct(private RubricHelperService $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/rubrics/{id}",
     *     summary="Get news belonging to a specific rubric",
     *     description="Returns paginated news items that directly belong to a given rubric.",
     *     tags={"Rubrics"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Rubric ID",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of news for the given rubric",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/NewsResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Rubric not found")
     * )
     */
    public function show(Rubric $rubric)
    {
        $news = $rubric->news()
            ->with('rubrics', 'author')
            ->orderBy('publish_date', 'desc')
            ->paginate(20)
            ->withQueryString();

        return NewsResource::collection($news);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/rubrics/{id}/all-news",
     *     summary="Get all descendant news for a rubric",
     *     description="Returns paginated news for a rubric including all its descendant rubrics recursively.",
     *     tags={"Rubrics"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Rubric ID",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of news from rubric and its descendants",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/NewsResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Rubric not found")
     * )
     */
    public function allNews(Rubric $rubric)
    {
        $allRubricIds = $this->service->getDescendantIds($rubric);
        $allRubricIds[] = $rubric->id;

        $news = News::whereHas('rubrics', fn($q) => $q->whereIn('rubric_id', $allRubricIds))
            ->with('rubrics', 'author')
            ->orderBy('publish_date', 'desc')
            ->paginate(20)
            ->withQueryString();

        return NewsResource::collection($news);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/rubrics",
     *     summary="Create a new rubric",
     *     description="Creates a new rubric category. You can optionally pass a parent_id to create a subrubric.",
     *     tags={"Rubrics"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreRubricRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rubric successfully created",
     *         @OA\JsonContent(ref="#/components/schemas/RubricResource")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(StoreRubricRequest $request)
    {
        $validated = $request->validated();
        $rubric = Rubric::create($validated);

        return new RubricResource($rubric);
    }
}
