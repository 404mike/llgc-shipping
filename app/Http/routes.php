<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route to AngularJS
Route::get('/', function () {
    return File::get(public_path() . '/shipping/app/index.html');
});

// API Routing
Route::group(['prefix' => 'api/v1'] , function(){

  $api = 'api\v1\Controller\\';

  Route::get('ships' , $api.'ShipController@getShips');
  Route::get('shipslogbook' , $api.'ShipController@getShipLogBook');
  Route::get('logbook' , $api.'ShipController@getLogBook');
  Route::get('search' , $api.'ShipController@getSearch');

}); 
