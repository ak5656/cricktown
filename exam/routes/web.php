<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;



Route::get('/', function () {
    return view('welcome');
});




Route::get('matchComm/{matchid?}', [ApiController::class, 'matchComm']);
Route::get('matchScoreCard/{matchid?}', [ApiController::class, 'matchScoreCard']);
Route::get('stats/rankings/{person}/{formatType?}', [ApiController::class, 'rankings']);
Route::get('stats/rankings/{person}/{formatType?}/women', [ApiController::class, 'rankingsWomen']);
Route::get('series/{seriesType}', [ApiController::class, 'series']);
Route::get('stats/series/{seriesId}/{detail?}', [ApiController::class, 'statsSeries']);
Route::get('matches/{status}', [ApiController::class, 'matches']);