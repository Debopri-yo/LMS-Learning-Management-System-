<?php

namespace App\Notifications;

use App\Models\Content;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewContentAdded extends Notification
{
    use Queueable;

    protected $content;

    public function __construct(Content $content)
    {
        $this->content = $content->load('course'); // Ensure course is loaded
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'course_id' => $this->content->course_id,
            'course_name' => $this->content->course->name,
            'content_id' => $this->content->id,
            'content_title' => $this->content->title,
            'message' => "New content \"{$this->content->title}\" has been added to \"{$this->content->course->name}\".",
        ];
    }
}
