<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RubricResource",
 *     type="object",
 *     title="Rubric Resource",
 *     description="Represents a rubric (category) entity",
 *     @OA\Property(property="id", type="integer", example=3, description="Rubric ID"),
 *     @OA\Property(property="name", type="string", example="City Life", description="Name of the rubric"),
 *     @OA\Property(property="parent_id", type="integer", nullable=true, example=1, description="Parent rubric ID (null if top-level)"),
 *     @OA\Property(
 *         property="children",
 *         type="array",
 *         description="Nested child rubrics (if loaded)",
 *         @OA\Items(ref="#/components/schemas/RubricResource")
 *     )
 * )
 */
class RubricResource extends JsonResource
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
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'children' => RubricResource::collection($this->whenLoaded('children')),
        ];
    }
}
