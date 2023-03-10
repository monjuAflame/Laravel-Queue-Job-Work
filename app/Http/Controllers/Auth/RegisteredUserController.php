<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendWelcomeMessage;
use App\Jobs\UserRegisterNotification;
use App\Mail\UserRegisterMail;
use App\Models\User;
use App\Notifications\RegisteredUserNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // UserRegisterNotification::dispatch($user);
        $jobs = [];
        foreach (User::where('id', '!=', $user->id)->pluck('id') as $recipient) {
            $jobs[] = new SendWelcomeMessage($user->id, $recipient);
        }

        $batch = Bus::batch($jobs)->dispatch();

        event(new Registered($user));

        Auth::login($user);

        return redirect('/dashboard?batch_id='.$batch->id);

        return redirect(RouteServiceProvider::HOME);
    }
}
