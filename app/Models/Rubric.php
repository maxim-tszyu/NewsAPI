<?php

namespace App\Models;

use Database\Factories\RubricFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rubric extends Model
{
    /** @use HasFactory<RubricFactory> */
    use HasFactory;

    protected $table = "rubrics";
    protected $guarded = [];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Rubric::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Rubric::class, 'parent_id');
    }

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}
