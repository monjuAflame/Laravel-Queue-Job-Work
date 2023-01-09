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

    private $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->message->update(['read_at'=>now()]);
        
        Notification::route('mail', $this->message->sender->email)
        ->notify(new NotificationsMessageIsReadNotification($this->message));
    }
}
