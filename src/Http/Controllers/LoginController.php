<?php

namespace Combindma\Richcms\Http\Controllers;

use Carbon\Carbon;
use Combindma\Richcms\Enums\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('richcms::auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            if (Auth::user()?->hasAnyRole([ Roles::Admin, Roles::Editor, Roles::Manager])) {
                $this->authenticated($request, Auth::user());

                return redirect(config('richcms.admin_url'));
            }
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
            config('recaptcha.token_name') => ['required','string', 'recaptcha'],
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1], $request->get('remember'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->action([LoginController::class, 'login']);
    }

    protected function authenticated(Request $request, $user)
    {
        $user->last_login_at = Carbon::now();
        $user->last_login_ip = $request->getClientIp();
        $user->save();
    }
}
