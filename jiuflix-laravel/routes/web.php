<?php

use Illuminate\Support\Facades\Route;
use App\Controllers\AlunoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/aluno/create', [AlunoController::class, 'create']);
Route::get('/alunos', [AlunoController::class, 'getAll']);
Route::get('/aluno/{id}', [AlunoController::class, 'show'])->whereNumber('id');
Route::delete('/aluno/{id}', [AlunoController::class, 'deleted'])->whereNumber('id');
Route::put('/aluno/{id}', [AlunoController::class, 'updated'])->whereNumber('id');
