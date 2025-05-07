<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;


Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/', [TarefaController::class, 'index']);
    Route::get('/tasks/pdf', [TarefaController::class, 'exportPdf'])->name('tasks.exportPdf');
    Route::resource('tasks', TarefaController::class);
});
