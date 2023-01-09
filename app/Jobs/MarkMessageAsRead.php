<?php

namespace App\Jobs;

use App\Listeners\MessageIsReadNotification;
use App\Models\Message;
use App\Notifications\MessageIsReadNotification as NotificationsMessageIsReadNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class MarkMessageAsRead implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message_id)
    {
        $this->message_id = $message_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = Message::find($this->message_id);
        if ($message) {
            
            if (!$message->read_at) {
                $message->update(['read_at'=>now()]);
            }
    
            Notification::route('mail', $message->sender->email)
            ->notify(new NotificationsMessageIsReadNotification($this->message));
        }
    }
}
