<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AuthorResource",
 *     type="object",
 *     title="Author Resource",
 *     description="Represents an author entity",
 *     @OA\Property(property="id", type="integer", example=1, description="Author ID"),
 *     @OA\Property(property="full_name", type="string", example="John Doe", description="Full name of the author"),
 *     @OA\Property(property="email", type="string", example="john@example.com", description="Author email address"),
 *     @OA\Property(property="avatar", type="string", nullable=true, example="avatars/john.jpg", description="Path to avatar image (if stored)"),
 *     @OA\Property(property="avatar_url", type="string", nullable=true, example="https://example.com/storage/avatars/john.jpg", description="Full URL to avatar image")
 * )
 */
class AuthorResource extends JsonResource
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
            'full_name' => $this->full_name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'avatar_url' => $this->avatar_url,
        ];
    }
}
