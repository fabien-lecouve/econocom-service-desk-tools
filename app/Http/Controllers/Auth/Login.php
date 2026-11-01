<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $project = Auth::user()
                ->memberships
                ->first()
                ?->project;

            return redirect()
                ->route('projects.show', $project);
        }

        return back()
            ->withErrors([
                'email' => 'Les identifiants fournis ne correspondent pas à nos dossiers',
            ])
            ->onlyInput('email');
    }
}
