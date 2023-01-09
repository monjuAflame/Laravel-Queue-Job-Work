<?php

namespace App\Jobs;

use App\Models\Message;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWelcomeMessage implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $sender_id;
    private $recipient_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $recipient_id)
    {
        $this->sender_id = $user_id;
        $this->recipient_id = $recipient_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        usleep(50000);
        $message = Message::create([
            'sender_id' => $this->sender_id,
            'recipient_id' => $this->recipient_id,
            'title' => 'Welcome',
            'message' => 'Hello world!',
        ]);
    }
}
