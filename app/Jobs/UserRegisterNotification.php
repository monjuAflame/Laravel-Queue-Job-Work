<?php

namespace App\Jobs;

use App\Mail\UserRegisterFailKnowAdmin;
use App\Mail\UserRegisterMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserRegisterNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $tries = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->user->email_verified_at) {
            $admins = User::where('is_admin', 1)->get();
            foreach ($admins as $admin) {
                Mail::to($admin)->send(new UserRegisterMail($this->user));        
            }
        } else {
            if ($this->attempts() < 2) {
                $this->release(60);
            } else {
                $this->release(600);
            }
        }
    }

    // public function failed(\Throwable $exception)
    // {
    //     $admin = User::where('is_admin', 1)->first();
    //     Mail::to('admin@admin.com')->send(new UserRegisterFailKnowAdmin($admin));
    //     info('failed to process notify: '. get_class($exception) . '-'. $exception->getMessage());
    // }
}
