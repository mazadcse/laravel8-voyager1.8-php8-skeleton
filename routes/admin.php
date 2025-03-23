<?php

use Illuminate\Support\Facades\Route;

Voyager::routes();

Route::any('/registration', [\App\Http\Controllers\Admin\AuthenticationController::class, 'registration'])->name('voyager.registration');
Route::any('/registration-success', [\App\Http\Controllers\Admin\AuthenticationController::class, 'registrationSuccess'])->name('voyager.registration');
Route::any('/forgot', [\App\Http\Controllers\Admin\AuthenticationController::class, 'forgot'])->name('voyager.forgot');


Route::get('admin/users/relation', [\App\Http\Controllers\Admin\VoyagerUserController::class, 'relation'])->name('voyager.users.relation');
