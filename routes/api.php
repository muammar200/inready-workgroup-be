<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\BPOController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConcentrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PresidiumController;
use App\Http\Controllers\Public\ActivityController as PublicActivityController;
use App\Http\Controllers\Public\BlogCategoryController;
use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\BPOController as PublicBPOController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\MemberController as PublicMemberController;
use App\Http\Controllers\Public\WorksController;
use App\Http\Controllers\SliderController;
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

Route::prefix("public")->group(function () {
  Route::prefix("home")->group(function () {
    Route::controller(HomeController::class)->group(function () {
      Route::get('slider', 'slider');
      Route::get('work', 'work');
      Route::get('blog', 'article');
      Route::get('gallery', 'gallery');
      Route::get('agenda', 'agenda');
    });
  });

  Route::prefix("blog")->group(function () {

    Route::get('/categories', [BlogCategoryController::class, 'index']);

    Route::controller(BlogController::class)->group(function () {
      Route::get('/', 'index');
      Route::get('/show/{article:slug}', 'show');
    });
  });

  Route::prefix("activity")->group(function () {
    Route::controller(PublicActivityController::class)->group(function () {
      Route::get('/', 'index');
      Route::get('/show/{activity}', 'show');
    });
  });

  Route::prefix("works")->group(function () {
    Route::controller(WorksController::class)->group(function () {
      Route::get('/', 'index');
      Route::get('/show/{activity}', 'show');
    });
  });

  Route::get('/bpo', [PublicBPOController::class, 'index']);
  Route::get('/member', [PublicMemberController::class, 'index']);
});

// Route::middleware(['auth:sanctum'])->group(function () {
  Route::prefix("dashboard")->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('member_chart', 'member_chart');
    });
  });
  Route::get('/member/all', [MemberController::class, 'getAllMember']);
  Route::resource('bpo', BPOController::class)->except(['create', 'edit']);
  Route::resource('category', CategoryController::class)->except(['create', 'edit']);
  Route::resource('major', MajorController::class)->except(['create', 'edit']);
  Route::resource('concentration', ConcentrationController::class)->except(['create', 'edit']);
  Route::resource('article', ArticleController::class)->except(['create', 'edit'])->parameters(["article" => "article:slug"]);
  Route::resource('agenda', AgendaController::class)->except(['create', 'edit'])->parameters(["agenda" => "agenda:slug"]);
  Route::resource('activity', ActivityController::class)->except(['create', 'edit']);
  Route::resource('member', MemberController::class)->except(['create', 'edit']);
  Route::resource('work', WorkController::class)->except(['create', 'edit']);
  Route::resource('user', UserController::class)->except(['create', 'edit']);
  Route::resource('slider', SliderController::class)->except(['create', 'edit']);
  Route::resource('gallery', GalleryController::class)->except(['create', 'edit']);
  Route::resource('presidium', PresidiumController::class)->except(['create', 'edit']);
  Route::resource('division', DivisionController::class)->except(['create', 'edit']);
// });

Route::controller(AuthenticateController::class)->group(function () {
  Route::post('login', 'login');
  Route::get('logout', 'logout')->middleware(['auth:sanctum']);
});
