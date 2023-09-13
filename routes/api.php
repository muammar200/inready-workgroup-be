<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConcentrationController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('category', [CategoryController::class, 'index']);
Route::get('major', [MajorController::class, 'index']);
Route::get('concentration', [ConcentrationController::class, 'index']);
Route::resource('article', ArticleController::class)->except(['create', 'edit'])->parameters(["article" => "article:slug"]);
Route::resource('agenda', AgendaController::class)->except(['create', 'edit'])->parameters(["agenda" => "agenda:slug"]);
Route::resource('activity', ActivityController::class)->except(['create', 'edit']);
Route::resource('member', MemberController::class)->except(['create', 'edit']);
Route::resource('work', WorkController::class)->except(['create', 'edit']);
Route::resource('user', UserController::class)->except(['create', 'edit']);
