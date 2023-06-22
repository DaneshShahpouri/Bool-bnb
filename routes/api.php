<?php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ApartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('apartments', [ApartmentController::class, 'index']);

Route::get('apartmentempty/{rooms?}/{beds?}/{bath?}/{services?}', [ApartmentController::class, 'getApartmentByCityEmptyName']);
Route::get('apartments/getapartment/{lat}/{lon}/{radius}/{rooms?}/{beds?}/{bath?}/{services?}', [ApartmentController::class, 'getApartmentByCity']);


// Route::get('apartments/distance/{lat1}/{lon2}/{lat2}/{lon2}', [ApartmentController::class, 'distance']);

Route::get('apartments/{name?}', [ApartmentController::class, 'name']);

Route::get('services', [ApartmentController::class, 'services']);

Route::get('apartments-show/{slug}', [ApartmentController::class, 'show']);

Route::post('messages/store', [MessageController::class, 'store']);


//debug---------------------------
// Route::get('test', function () {
//     return 'ciao';
// });

// Route::post('apartments/search', [ApartmentController::class, 'search']);


// Route::get('apartments/prova', [ApartmentController::class, 'provaci']);

// Route::get('/posts/{post}/comments/{comment}', function (string $postId, string $commentId) {
//     return [$postId, $commentId];
// });
//---------debug
