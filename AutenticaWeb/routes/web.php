<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('Login.index'));
Route::get('/login', fn () => view('Login.index'))->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('Dashboard.index'))->name('dashboard');

    Route::middleware('role:admin,responsavel')->group(function () {
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/criar', [UserController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    });

    Route::middleware('role:admin,responsavel')->group(function () {
        Route::get('/criar_autorizacao', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    });

    Route::middleware('role:admin,responsavel,professor,portaria')->group(function () {
        Route::get('/notificacoes', [NotificationController::class, 'index'])->name('notificacoes.index');
        Route::patch('/tickets/{ticket}/lida', [NotificationController::class, 'markAsRead'])->name('tickets.read');
        Route::patch('/tickets/{ticket}/confirmar', [NotificationController::class, 'confirm'])->name('tickets.confirm');
    });
});
