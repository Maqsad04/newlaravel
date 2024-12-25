<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class QuestionRejectedNotification extends Notification
{
    use Queueable;

    private $question;

    public function __construct($question)
    {
        $this->question = $question;
    }

    public function via($notifiable)
    {
        return ['database']; // Store in the database
    }

    public function toArray($notifiable)
    {
        return [
            // 'message' => "Your question '{$this->question->title}' has been rejected.",
            'message' => "A new question has been submitted: {$this->question->title}",
            'question_id' => $this->question->id,
        ];
    }
}