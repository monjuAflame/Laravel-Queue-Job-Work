<?php

namespace App\Console\Commands;

use App\Jobs\MarkMessageAsRead;
use App\Models\Message;
use Illuminate\Console\Command;

class MessageSendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = Message::create([
            'sender_id' => 1,
            'recipient_id' => 4,
            'title' => 'Test',
            'message' => 'Hello world!',
        ]);

        MarkMessageAsRead::dispatch($message);

        return 0;
    }
}
