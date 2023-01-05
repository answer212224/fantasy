<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MemberController as FrontendMemberController;
use App\Http\Controllers\Backend\MemberController as BackendMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\FacebookSessionController;
use App\Http\Controllers\Backend\AwardController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\GameController;
use App\Http\Controllers\Backend\PrizeController;
use App\Http\Controllers\Backend\ScoreController;
use Laravel\Socialite\Facades\Socialite;


Route::get('/', [HomeController::class, 'index']);
Route::get('/info', [HomeController::class, 'info']);
Route::get('/awards', [HomeController::class, 'awards']);
// Route::get('/test', [HomeController::class, 'test']);
Route::get('/member', [FrontendMemberController::class, 'index'])->middleware('auth.member');
Route::get('/member/search', [FrontendMemberController::class, 'search'])->middleware('auth.member');
Route::post('/member', [FrontendMemberController::class, 'store']);
Route::get('/players/{id}', [GameController::class, 'playersByGameId']);

Route::get('/fblogin', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('/callback', [FacebookSessionController::class, 'index']);

Route::get('/fblogout', [FacebookSessionController::class, 'destroy'])
    ->middleware('auth.member');

Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->middleware(['auth']);
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth']);
    Route::post('weight', [DashboardController::class, 'weight'])
        ->middleware(['auth']);
    Route::post('setting', [DashboardController::class, 'setting'])
        ->middleware(['auth']);

    Route::get('members', [BackendMemberController::class, 'index'])
        ->middleware(['auth']);
    Route::get('members/export', [BackendMemberController::class, 'export'])
        ->middleware(['auth']);
    Route::get('members/{member}', [BackendMemberController::class, 'show'])
        ->middleware(['auth']);
    Route::get('members/histories/{history}', [BackendMemberController::class, 'showSelections'])
        ->middleware(['auth']);

    Route::get('/ranking/overall', [HomeController::class, 'showOverallRanking'])->middleware(['auth']);

    Route::get('scores/overall', [ScoreController::class, 'overallRanking'])->middleware(['auth']);
    Route::get('scores/weekly', [ScoreController::class, 'weeklyRanking'])->middleware(['auth']);

    Route::get('games', [GameController::class, 'index'])
        ->middleware(['auth']);
    Route::get('games/search', [GameController::class, 'search'])
        ->middleware(['auth']);
    Route::get('games/{game}', [GameController::class, 'players'])
        ->middleware(['auth']);
    Route::post('games/update', [GameController::class, 'update'])
        ->middleware(['auth']);

    Route::get('scores', [ScoreController::class, 'index'])
        ->middleware(['auth']);
    Route::get('scores/search', [ScoreController::class, 'search'])
        ->middleware(['auth']);
    Route::post('scores', [ScoreController::class, 'update'])
        ->middleware(['auth']);

    Route::get('prizes', [PrizeController::class, 'index'])
        ->middleware(['auth']);
    Route::post('prizes/{prize}', [PrizeController::class, 'update'])
        ->middleware(['auth']);

    Route::get('awards', [AwardController::class, 'index'])
        ->middleware(['auth']);
    Route::post('awards/details', [AwardController::class, 'store'])
        ->middleware(['auth']);
    Route::delete('awards/{award}', [AwardController::class, 'destroy'])
        ->middleware(['auth']);
    Route::get('awards/{award}/details', [AwardController::class, 'show'])
        ->middleware(['auth']);
    Route::put('details/{awardDetail}', [AwardController::class, 'updateDetail'])
        ->middleware(['auth']);
    Route::delete('details/{awardDetail}', [AwardController::class, 'destroyDetail'])
        ->middleware(['auth']);
});

require __DIR__ . '/auth.php';
