<?php

namespace App\Models;

use Database\Factories\AuthorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Author extends Model
{
    /** @use HasFactory<AuthorFactory> */
    use HasFactory;

    protected $table = "authors";
    protected $guarded = [];
    protected $casts = [
        'avatar' => 'string',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function getAvatarUrlAttribute(): ?string
    {
        if (empty($this->avatar)) {
            return null;
        }
        return asset('storage/' . ltrim($this->avatar, '/'));
    }

}
