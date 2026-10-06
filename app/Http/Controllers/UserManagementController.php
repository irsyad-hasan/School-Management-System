<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::where('archived', false)->orderBy('role')->orderBy('username')->get();
        return view('users.index', compact('users'));
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->user_id === Auth::id()) {
            return back()->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Akun admin dilindungi dan tidak dapat dihapus.');
        }

        $user->update(['archived' => true]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun pengguna berhasil dinonaktifkan.');
    }
}
