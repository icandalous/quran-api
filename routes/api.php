<?php

use Illuminate\Http\Request;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Groupe de routes pour le versioning d'API
Route::group(array('prefix' => 'quran/v1', 'before' => 'auth.basic'), function()
{
	Route::get('ayats/{id}', 'AyatController@ayats');
	Route::get('ayats', 'AyatController@index');
	Route::get('ayats/search/{valeur}', 'AyatController@search');
	
	Route::get('sourates', 'CoranController@index');
	Route::get('sourates/{valeur}', 'CoranController@sourate');
	
	Route::get('mutashab', 'MutashabController@index');
	Route::get('mutashab/{valeur}', 'MutashabController@mutashab');
	Route::get('mutashab/search/{valeur}', 'MutashabController@search');
});



