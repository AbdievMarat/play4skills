<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Mail\WelcomeEmail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showRegisterForm(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request): RedirectResponse
    {
        $email = $request->validated()['email'];

        $user = User::query()->where('email', $email)->first();

        $name = $user->name;
        $password = $user->decrypted_password;

        $mailer = Mail::to($email)->send(new WelcomeEmail($email, $name, $password));

        if ($mailer) {
            User::query()
                ->where('email', '=', $email)
                ->update(['access_sent' => true]);

            $text = 'Доступ отправлен на Вашу почту!';
        } else {
            $text = 'Доступ не был отправлен, обратитесь к администратору!';
        }

        return redirect()->route('login')->with('success', ['text' => $text]);
    }
}
