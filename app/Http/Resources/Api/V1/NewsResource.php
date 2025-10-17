<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="NewsResource",
 *     type="object",
 *     title="News Resource",
 *     description="Represents a news item",
 *     @OA\Property(property="id", type="integer", example=10, description="News ID"),
 *     @OA\Property(property="title", type="string", example="City Day Celebrations", description="Title of the news"),
 *     @OA\Property(property="announcement", type="string", example="City Day will be celebrated with various events...", description="Short announcement or preview"),
 *     @OA\Property(property="text", type="string", example="The City Day celebration will include concerts, exhibitions, and fireworks...", description="Full news content"),
 *     @OA\Property(property="publish_date", type="string", format="date-time", example="2025-10-15T12:00:00Z", description="Publication date and time"),
 *
 *     @OA\Property(
 *         property="author",
 *         ref="#/components/schemas/AuthorResource",
 *         description="Author of the news"
 *     ),
 *
 *     @OA\Property(
 *         property="rubrics",
 *         type="array",
 *         description="List of associated rubrics",
 *         @OA\Items(ref="#/components/schemas/RubricResource")
 *     )
 * )
 */
class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'announcement' => $this->announcement,
            'text' => $this->text,
            'publish_date' => $this->publish_date,
            'author' => new AuthorResource($this->author),
            'rubrics' => RubricResource::collection($this->rubrics),
        ];
    }
}
