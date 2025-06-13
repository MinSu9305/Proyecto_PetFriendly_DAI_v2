<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\AdoptionRequestController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PetController as UserPetController;
use App\Http\Controllers\User\DonationController as UserDonationController;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Auth;

// Página principal con Livewire
Route::get('/', HomePage::class)->name('home');
 // Definir una ruta dashboard que redirija a user.profile
Route::get('/dashboard', function () {
    return redirect()->route('user.profile');
})->middleware(['auth'])->name('dashboard');

// Rutas de autenticación tradicionales
Route::post('/login', [CustomAuthController::class, 'login'])->name('login');
Route::post('/register', [CustomAuthController::class, 'register'])->name('register');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// Dashboard Admin (requiere autenticación y rol admin)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/adoptantes', [DashboardController::class, 'adoptantes'])->name('adoptantes');


    // Rutas de mascotas (CRUD)
    Route::resource('pets', PetController::class);
    
    // Rutas de solicitudes de adopción (CRUD)
    Route::resource('adoption-requests', AdoptionRequestController::class);
    Route::post('/adoption-requests/{adoptionRequest}/process', [AdoptionRequestController::class, 'process'])->name('adoption-requests.process');
    
    // Rutas de donaciones (solo index y show)
    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
    Route::get('/donations/{donation}/certificate', [DonationController::class, 'generateCertificate'])->name('donations.certificate');
    
    Route::get('/solicitudes', [DashboardController::class, 'solicitudes'])->name('solicitudes');
    Route::get('/donaciones', [DashboardController::class, 'donaciones'])->name('donaciones');
    
    // AJAX routes para adoptantes
    Route::get('/adoptantes/{user}/view', [DashboardController::class, 'viewAdoptante'])->name('adoptantes.view');
    Route::delete('/adoptantes/{user}/delete', [DashboardController::class, 'deleteAdoptante'])->name('adoptantes.delete');
});


// Rutas para usuarios normales (adoptantes)
// Eliminar el middleware 'verified'
Route::middleware(['auth'])->name('user.')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    
    // Mascotas
    Route::get('/pets', [UserPetController::class, 'index'])->name('pets.index');
    Route::get('/pets/{pet}', [UserPetController::class, 'show'])->name('pets.show');
    Route::get('/pets/{pet}/adoption-form', [UserPetController::class, 'adoptionForm'])->name('pets.adoption-form');
    Route::post('/pets/{pet}/adoption', [UserPetController::class, 'submitAdoption'])->name('pets.submit-adoption');
    
    // Donaciones
    Route::get('/donations', [UserDonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/create', [UserDonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [UserDonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/{donation}/certificate', [UserDonationController::class, 'downloadCertificate'])->name('donations.certificate');
});



// Incluir rutas de autenticación de Laravel Breeze
require __DIR__.'/auth.php';


