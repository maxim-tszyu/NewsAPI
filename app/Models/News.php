<?php

namespace App\Models;

use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    /** @use HasFactory<NewsFactory> */
    use HasFactory;

    protected $table = "news";

    protected $guarded = [];
    protected $casts = [
        'publish_date' => 'datetime'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function rubrics(): BelongsToMany
    {
        return $this->belongsToMany(Rubric::class);
    }
}
