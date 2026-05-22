<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('Login.index');
});

Route::get('/index',function(){
    return view('Index.index');
});

Route::get('/login',function(){
    return view('Login.index');
})->name('login');

Route::get('/cadastro', function(){
    return view('Cadastro.index');
})->middleware('auth');

Route::get('/dashboard',function(){
    return view('Dashboard.index');
})->middleware('auth');;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class,'logout']);

Route::post('/cadastro',[AuthController::class,'cadastro']);