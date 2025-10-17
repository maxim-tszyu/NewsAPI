<?php

namespace App\Mail;

use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsUploadedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public News $news)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject("Новая новость опубликована: {$this->news->title}")
            ->view('emails.news_uploaded')
            ->with([
                'title' => $this->news->title,
                'author' => $this->news->author->full_name ?? 'Неизвестный автор',
                'publish_date' => $this->news->publish_date,
            ]);
    }
}
