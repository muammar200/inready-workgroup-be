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
      Route::get('slider/show/{activity}', 'showSlider');
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

Route::middleware(['auth:sanctum'])->group(function () {
Route::prefix("admin")->group(function () {
  Route::middleware(['role:editor,admin'])->group(function () {
    
  });
  Route::prefix("dashboard")->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('member_chart', 'member_chart');
        Route::get('member_column_chart', 'member_column_chart');
        Route::get('upcoming_agenda', 'upcoming_agenda');
    });
  });
  Route::get('/member/all', [MemberController::class, 'getAllMember']);
  Route::prefix("bpo")->controller(BPOController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{bpo}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{bpo}', 'update');
        Route::delete('{bpo}', 'destroy');
    });
  });
  Route::prefix("category")->controller(CategoryController::class)->group(function () {
      Route::get('', 'index');
      Route::get('{category}', 'show');
      Route::middleware(['role:admin,editor'])->group(function () {
          Route::post('', "store");
          Route::put('{category}', "update");
          Route::delete('{category}', "destroy");
      });
  });
  Route::prefix("major")->controller(MajorController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{major}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{major}', 'update');
        Route::delete('{major}', 'destroy');
    });
  });
  Route::prefix("concentration")->controller(ConcentrationController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{concentration}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{concentration}', 'update');
        Route::delete('{concentration}', 'destroy');
    });
  });
  Route::prefix("article")->controller(ArticleController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{article:slug}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{article:slug}', 'update');
        Route::delete('{article:slug}', 'destroy');
    });
  });
  Route::prefix("agenda")->controller(AgendaController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{agenda:slug}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{agenda:slug}', 'update');
        Route::delete('{agenda:slug}', 'destroy');
    });
  });
  Route::prefix("activity")->controller(ActivityController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{activity}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{activity}', 'update');
        Route::delete('{activity}', 'destroy');
    });
  });
  Route::prefix("member")->controller(MemberController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{member}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{member}', 'update');
        Route::delete('{member}', 'destroy');
    });
  });
  Route::prefix("work")->controller(WorkController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{work}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{work}', 'update');
        Route::delete('{work}', 'destroy');
    });
  });
  Route::prefix("user")->controller(UserController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{user}', 'show');
    Route::middleware(['role:admin'])->group(function () {
        Route::post('', 'store');
        Route::put('{user}', 'update');
        Route::delete('{user}', 'destroy');
    });
  });
  Route::prefix("slider")->controller(SliderController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{slider}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{slider}', 'update');
        Route::delete('{slider}', 'destroy');
    });
  });
  Route::prefix("gallery")->controller(GalleryController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{gallery}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{gallery}', 'update');
        Route::delete('{gallery}', 'destroy');
    });
  });
  Route::prefix("presidium")->controller(PresidiumController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{presidium}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{presidium}', 'update');
        Route::delete('{presidium}', 'destroy');
    });
  });
  Route::prefix("division")->controller(DivisionController::class)->group(function () {
    Route::get('', 'index');
    Route::get('{division}', 'show');
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::post('', 'store');
        Route::put('{division}', 'update');
        Route::delete('{division}', 'destroy');
    });
  });
});
});

Route::controller(AuthenticateController::class)->group(function () {
  Route::post('admin/login', 'login');
  Route::get('admin/logout', 'logout')->middleware(['auth:sanctum']);
});
