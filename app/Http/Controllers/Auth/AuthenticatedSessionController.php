<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

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
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            // El usuario ha sido autenticado correctamente

            $user = Auth::user();

            if ($user->estado == 1) {
                $request->authenticate();

                $request->session()->regenerate();
        
                return redirect()->intended(RouteServiceProvider::HOME);
            } else {
                // El usuario no está activo, cerrar la sesión y mostrar un mensaje de error
                Auth::logout();
                throw ValidationException::withMessages([
                    'estado' => ['Tu cuenta no está activa.'],
                ]);
            }
        }

        // La autenticación falló, redirigir de vuelta al formulario de inicio de sesión con un mensaje de error
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
       
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
