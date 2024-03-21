<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

// ### after project download from live, if there is no changes effecs come in local
//  Run this commands
# php artisan config:clear
# php artisan event:clear
# php artisan route:clear
# php artisan view:clear
// ### 

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('matchComm/{matchid}', [ApiController::class, 'matchComm']);
    Route::get('matchScoreCard/{matchid}', [ApiController::class, 'matchScoreCard']);
    Route::get('matchInfo/{matchid}', [ApiController::class, 'matchInfo']);
    Route::get('team/{matchid}/{teamid}', [ApiController::class, 'team']);
    Route::get('stats/rankings/{person}/{formatType?}', [ApiController::class, 'rankings']);
    Route::get('stats/rankings/{person}/{formatType?}/women', [ApiController::class, 'rankingsWomen']);
    Route::get('series/{seriesType}', [ApiController::class, 'series']);
    Route::get('stats/series/{seriesId}/{detail?}', [ApiController::class, 'statsSeries']);
    Route::get('publicStats/series/{seriesId}/{statsType?}', [ApiController::class, 'publicStatsSeries']);
    Route::get('matches/{status}', [ApiController::class, 'matches']);
    Route::get('stats/player/{id}/{info?}', [ApiController::class, 'statsPlayer']);
})->middleware('EnsureTokenIsValid');