<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('admin.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (! hash_equals((string) config('app.admin_password'), $validated['password'])) {
            return back()->withErrors(['password' => 'Password admin tidak betul.']);
        }

        $request->session()->put('admin_authenticated', true);

        return redirect()->route('admin.posts.index');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_authenticated');

        return redirect()->route('home');
    }
}
