<?php

namespace Combindma\Richcms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class LoginController
{
    use AuthenticatesUsers;

    protected $maxAttempts = 3;
    protected $decayMinutes = 2;
    protected $redirectTo = '/dash';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('richcms::auth.login');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
            config('recaptcha.token_name') => ['required','string', 'recaptcha'],
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return redirect()->intended(route('admin::home'));
        }

        $this->incrementLoginAttempts($request);

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'));
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin::login');
    }

    public function authenticated(Request $request, $user)
    {
        $user->last_login_at = Carbon::now();
        $user->last_login_ip = $request->getClientIp();
        $user->save();
    }
}
