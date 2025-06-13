<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class CustomAuthController extends Controller
{
    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Actualizar último login
            $user = User::find(Auth::id());
            $user->last_login_at = now();
            $user->save();

            // Redirigir según el rol
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.adoptantes'));
            }

            return redirect()->intended(route('user.profile'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'birth_date' => ['required', 'date', 'before:' . Carbon::now()->subYears(20)->format('Y-m-d')],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'birth_date.before' => 'Debes ser mayor de 20 años para registrarte.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'email.unique' => 'Este correo ya está registrado.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'password' => Hash::make($request->password),
            'role' => 'user', // Por defecto es usuario normal
            'email_verified_at' => now(), // Marcar como verificado automáticamente
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('user.profile');
    }
}

