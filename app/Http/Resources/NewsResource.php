<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'announcement' => $this->announcement,
            'text' => $this->text,
            'publish_date' => $this->publish_date,
            'author' => new AuthorResource($this->author),
            'rubrics' => RubricResource::collection($this->rubrics),
        ];
    }
}
