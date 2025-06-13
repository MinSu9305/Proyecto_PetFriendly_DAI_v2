<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class HomePage extends Component
{
    public $showModal = false;
    public $currentTab = 'login';

    // Login form
    public $loginEmail = '';
    public $loginPassword = '';

    // Register form
    public $registerName = '';
    public $registerEmail = '';
    public $registerBirthDate = '';
    public $registerPassword = '';
    public $registerPasswordConfirmation = '';

    protected $rules = [
        'loginEmail' => 'required|email',
        'loginPassword' => 'required|min:6',
        'registerName' => 'required|min:2',
        'registerEmail' => 'required|email|unique:users,email',
        'registerBirthDate' => 'required|date',
        'registerPassword' => 'required|min:6',
        'registerPasswordConfirmation' => 'required|same:registerPassword',
    ];

    protected $messages = [
        'loginEmail.required' => 'El correo es requerido',
        'loginEmail.email' => 'Ingresa un correo válido',
        'loginPassword.required' => 'La contraseña es requerida',
        'loginPassword.min' => 'La contraseña debe tener al menos 6 caracteres',
        'registerName.required' => 'El nombre es requerido',
        'registerName.min' => 'El nombre debe tener al menos 2 caracteres',
        'registerEmail.required' => 'El correo es requerido',
        'registerEmail.email' => 'Ingresa un correo válido',
        'registerEmail.unique' => 'Este correo ya está registrado',
        'registerBirthDate.required' => 'La fecha de nacimiento es requerida',
        'registerPassword.required' => 'La contraseña es requerida',
        'registerPassword.min' => 'La contraseña debe tener al menos 6 caracteres',
        'registerPasswordConfirmation.required' => 'Confirma tu contraseña',
        'registerPasswordConfirmation.same' => 'Las contraseñas no coinciden',
    ];

    public function showAuthModal($tab = 'login')
    {
        $this->currentTab = $tab;
        $this->showModal = true;
        $this->resetErrorBag();
    }

    public function switchTab($tab)
    {
        $this->currentTab = $tab;
        $this->resetErrorBag();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetErrorBag();
    }

    public function login()
    {
        $this->validate([
            'loginEmail' => 'required|email',
            'loginPassword' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->loginEmail, 'password' => $this->loginPassword])) {
            // Actualizar último login
            $user = User::find(Auth::id());
            if ($user) {
                $user->last_login_at = now();
                $user->save();
            }

            session()->regenerate();
            
            // Redirigir según el rol
            if (Auth::user()->role === 'admin') {
                return $this->redirect(route('admin.adoptantes'), navigate: true);
            }

            // Cambiar esta línea para redirigir a la ruta user.profile en lugar de dashboard
            return $this->redirect(route('user.profile'), navigate: true);
        }

        $this->addError('loginEmail', 'Las credenciales no coinciden con nuestros registros.');
    }

    public function register()
    {
        $this->validate([
            'registerName' => 'required|min:2',
            'registerEmail' => 'required|email|unique:users,email',
            'registerBirthDate' => 'required|date',
            'registerPassword' => 'required|min:6',
            'registerPasswordConfirmation' => 'required|same:registerPassword',
        ]);

        // Validar edad
        $birthDate = Carbon::parse($this->registerBirthDate);
        $age = $birthDate->diffInYears(Carbon::now());
        
        if ($age < 20) {
            $this->addError('registerBirthDate', 'Debes ser mayor de 20 años para registrarte.');
            return;
        }

        $user = User::create([
            'name' => $this->registerName,
            'email' => $this->registerEmail,
            'birth_date' => $this->registerBirthDate,
            'password' => Hash::make($this->registerPassword),
            'role' => 'user',
            'email_verified_at' => now(), // Marcar como verificado automáticamente
        ]);

        Auth::login($user);

        session()->flash('message', 'Registro exitoso. ¡Bienvenido a Pet Friendly!');
        
        return $this->redirect(route('user.profile'), navigate: true);
    }

    private function resetForm()
    {
        $this->loginEmail = '';
        $this->loginPassword = '';
        $this->registerName = '';
        $this->registerEmail = '';
        $this->registerBirthDate = '';
        $this->registerPassword = '';
        $this->registerPasswordConfirmation = '';
    }

    public function render()
    {
        // Cambiar el layout a uno que sabemos que existe
        return view('livewire.home-page');
    }
}
