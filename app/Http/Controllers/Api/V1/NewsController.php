<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreNewsRequest;
use App\Http\Resources\Api\V1\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/news/search",
     *     summary="Search news by query",
     *     description="Returns a paginated list of news filtered by search query.",
     *     tags={"News"},
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=false,
     *         description="Search term for filtering news by title",
     *         @OA\Schema(type="string", example="elections")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of news",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/NewsResource")
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/v1/news",
     *     summary="Create a new news entry",
     *     description="Stores a newly created news item in the database.",
     *     tags={"News"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreNewsRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successfully created news item",
     *         @OA\JsonContent(ref="#/components/schemas/NewsResource")
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/v1/news/{id}",
     *     summary="Get a specific news item",
     *     description="Returns a single news item by ID.",
     *     tags={"News"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="News ID",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News item",
     *         @OA\JsonContent(ref="#/components/schemas/NewsResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News not found"
     *     )
     * )
     */
    public function show(News $news)
    {
        return new NewsResource($news);
    }
}
