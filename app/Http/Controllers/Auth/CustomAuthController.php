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
     * Maneja el inicio de sesión
     */
    public function login(Request $request)
    {
        // Valida que el email y contraseña estén presentes y en formato correcto
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
        // Intenta autenticar con las credenciales. Si son válidas
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Actualizar último login
            $user = User::find(Auth::id());
            $user->last_login_at = now();
            $user->save();

            // Si el usuario es admin, lo redirige al panel de administración
            // Si es un adoptante, lo redirige a su perfil y dashboard
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
     * Maneja el registro de usuarios
     */
    public function register(Request $request)
    {
        // Los datos a ingresar son obligatorios y en fecha de nacimiento debe ser mayor de 20 años
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
            'role' => 'user', // Crea un nuevo usuario con rol "user"
            'email_verified_at' => now(), // Marcar como verificado automáticamente
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('user.profile'); //Redirige al perfil del usuario
    }
}

