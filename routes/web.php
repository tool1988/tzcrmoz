<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZohoController;
use App\Http\Controllers\IndexController;

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('zoho/authorize', [ZohoController::class, 'authorize'])->name('zoho.authorize');
Route::get('zoho/callback', [ZohoController::class, 'callback'])->name('zoho.profile');

Route::post('/accountdeal', [IndexController::class, 'createAccountDeal'])->name('createAccountDeal');
Route::post('/account', [IndexController::class, 'createAccount'])->name('createAccount');
Route::post('/deal', [IndexController::class, 'createDeal'])->name('createDeal');
