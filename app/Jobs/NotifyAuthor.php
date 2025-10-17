<?php

namespace App\Jobs;

use App\Mail\NewsUploadedMail;
use App\Models\News;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class NotifyAuthor implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public News $news)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $author = $this->news->author;

            if (!$author || !$author->email) {
                Log::warning("News #{$this->news->id} has no author email to notify.");
                return;
            }

            Mail::to($author->email)->send(new NewsUploadedMail($this->news));

            Log::info("✅ Email sent to author ({$author->email}) about news #{$this->news->id}");
        } catch (Throwable $e) {
            Log::error("❌ Failed to send email for news #{$this->news->id}: {$e->getMessage()}");
        }
    }
}
