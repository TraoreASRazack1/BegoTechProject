<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\TaskController;
use App\Models\User;
use App\Mail\ContactMail;


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

Route::get('/auth', function (Request $request) {
    return [
        "name" => $request ->path(),
    ];
});


Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create', ])->name('tasks.create');
Route::get('/tasks/edit/{id}', [TaskController::class, 'edit'])->name('tasks.edit');
Route::post('/api/tasks', [TaskController::class, 'store']);
Route::get('/users', function () {
    $users = User::all(['email']);
    return response()->json(['users' => $users]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/tasks/filter', [TaskController::class, 'filter'])->name('tasks.filter');
Route::get('/tasks/mail/{id}', [TaskController::class, 'mail'])->name('tasks.mail');
Route::get('/assign-role/{userId}/{roleName}', [TaskController::class, 'assignRoleToUser']);
