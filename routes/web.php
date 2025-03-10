<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\IRedMailController;

Route::prefix('email')->group(function () {
    Route::get('/send-test', [IRedMailController::class, 'sendTestEmail'])->name('email.sendTest');
    Route::post('/send', [IRedMailController::class, 'sendCustomEmail'])->name('email.sendCustom');
});

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\EmployeAuth\LoginController;
use App\Http\Controllers\EmployeAuth\ChangePasswordController;

Route::prefix('employes')->name('employes.')->group(function () {
    // Connexion et déconnexion
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');

    // Changement de mot de passe
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('changePassword');
    Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('changePassword.submit');

    // Tableau de bord après connexion
    Route::get('/dashboard', function () {
        return view('employes.dashboard');
    })->middleware('auth:employes')->name('dashboard');

    // Gestion des employés (CRUD)
    Route::get('/', [EmployeController::class, 'index'])->name('index');
    Route::get('/create', [EmployeController::class, 'create'])->name('create');
    Route::post('/store', [EmployeController::class, 'store'])->name('store');
    Route::get('/{employe}/edit', [EmployeController::class, 'edit'])->name('edit');
    Route::post('/{employe}/update', [EmployeController::class, 'update'])->name('update');
    Route::delete('/{employe}/delete', [EmployeController::class, 'destroy'])->name('destroy');
});


// Routes pour les clients
Route::resource('clients', ClientController::class);

// Routes pour les documents
Route::resource('documents', DocumentController::class);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Routes pour l'admin
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/employees', [App\Http\Controllers\AdminController::class, 'employees'])->name('admin.employees');
    Route::get('/clients', [App\Http\Controllers\AdminController::class, 'clients'])->name('admin.clients');
});

// Protéger certaines routes
Route::middleware(['auth'])->group(function () {
    Route::resource('clients', ClientController::class);
    Route::resource('documents', DocumentController::class);
});

Route::middleware(['web'])->group(function () {
    Auth::routes();

    // Routes publiques (accessibles sans authentification)
    #Route::get('/employes/login', [LoginController::class, 'showLoginForm'])->name('employes.login');
    #Route::post('/employes/login', [LoginController::class, 'login'])->name('employes.login.submit');

    // Routes protégées par authentification
Route::middleware(['auth:employes'])->group(function () {
    Route::get('/employes/dashboard', function () {
        return view('employes.dashboard');
    })->name('employes.dashboard');
});
    
        Route::get('/employes/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('employes.changePassword');
        Route::post('/employes/change-password', [ChangePasswordController::class, 'changePassword'])->name('employes.changePassword.submit');

        Route::middleware(['admin'])->group(function () {
            Route::get('/admin', function () {
                return view('admin.dashboard');
            })->name('admin.dashboard');
        });

        Route::middleware(['employe'])->group(function () {
            Route::get('/mes-documents', [DocumentController::class, 'index'])->name('document.index');
            Route::post('/documents', [DocumentController::class, 'store'])->name('document.store');
        });
    });

use App\Http\Controllers\FileTransferController;

Route::middleware(['auth'])->group(function () {
    Route::get('/files/{employee_id?}', [FileTransferController::class, 'index'])->name('files.index');
    Route::post('/files/upload', [FileTransferController::class, 'upload'])->name('files.upload');
    Route::get('/files/download/{id}', [FileTransferController::class, 'download'])->name('files.download');
    Route::delete('/files/{id}', [FileTransferController::class, 'destroy'])->name('files.destroy');
});