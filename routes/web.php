<?php

use Illuminate\Support\Facades\Request;
use  Illuminate\Support\Facades\Response;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
    //return view('welcome');
});

Route::get('/search', function () {
    //return redirect('/login');
    Redirect::away('/search');
});


/*Route::get('/configuracao', function () {
    return Redirect::to('configuracao');
});*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('inputs', 'InputsController@index');
    Route::get('scraps', 'ScrapsController@index');
    Route::get('testes', 'TestesController@testes');
    Route::get('show/{id}/{data}/{device}/{hora}', 'ScrapsController@show');
    Route::get('category/{id}', 'ScrapsController@category');
    Route::get('search/{id}', 'ScrapsController@search');
    Route::post('inputs', 'InputsController@index');
    Route::post('search', 'InputsController@search');
    Route::get('inputs/get-loja-list', 'InputsController@lojasList');
    Route::post('inputs/update', 'InputsController@update');

    Route::prefix('reports')->group(function () {
        Route::get('report_overview', 'ReportController@loadReportOverview');
/*        Route::get('report_shelf', 'ReportController@loadShereOfShelf');
        Route::get('report_search', 'ReportController@loadSearch');
        Route::get('data', 'ReportController@data');
        Route::get('form', 'ReportController@form');
        Route::get('get-loja-list', 'ReportController@lojasList');*/
    });

   // Route::get('/getRequest', 'ScrapsController@getRequest');

    //   Route::get('show/{id}', 'ScrapsController@modal');
  /*  Route::get('/getRequest', function(){
        if(Request::ajax()){
            return 'Retornando dadados ajax';
        }
    });*/

});

/*Route::group(['domain' => 'sonar.iprospect.com.br/{configuracao}'], function()
{

    Route::get('configuracao/{id}', function($configuracao, $id)
    {
        //
    });

});*/