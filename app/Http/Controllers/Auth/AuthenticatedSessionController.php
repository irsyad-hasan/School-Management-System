<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user) {
            ActivityLogger::record('login', 'Masuk ke dalam sistem.');
        }

        if ($user?->role === 'teacher') {
            $teacherName = $user->teacher?->full_name ?? $user->username;
            $isFirstLogin = $user->first_login_at === null;

            if ($isFirstLogin) {
                $user->forceFill(['first_login_at' => now()])->save();
            }

            $request->session()->put('teacher_greeting', [
                'type' => $isFirstLogin ? 'new' : 'returning',
                'name' => $teacherName,
            ]);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            ActivityLogger::record('logout', 'Keluar dari sistem.');
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
