<?php
use Illuminate\Support\Facades\Auth;


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::controllers([
    'admin/auth' => 'Admin\Auth\AuthController',
    //'admin/password' => 'Admin\Auth\PasswordController',
]);

Route::group(['middleware' => 'client.auth'], function () {

    //Index
    get('/', 'HomeController@index');

    //Users
    get('user/{id}',function($id){
        Session::put('user_id',$id);
        return Redirect::to('/');
    });
    Route::group(['namespace' => 'Users'], function () {
        get('users/modal/{modal}',['as'=>'users.modal', 'uses'  =>'UsersController@modal']);
        post('users/save-account','UsersController@saveAccount');
        get('users/files','FilesController@index');
        get('users/current','UsersController@current');
        post('users/save','UsersController@save');
        post('login','LoginController@doLogin');
    });

    //Help
    post('help','HelpController@index');

    //Flag
    post('flag','FlagController@index');

    //Activity
    get('activity','ActivityController@index');

    //Upload
    post('upload/file','UploadController@file');
    post('upload/processing','UploadController@processing');
    post('upload/progress_json','UploadController@progress');
    get('upload/progress_json','UploadController@progress');

    //Power
    get('power/index','PowerController@index');
    post('power/map','PowerController@map');
    post('power/map','PowerController@map');
    get('power/achievement','PowerController@achievement');

    //Ride ;
    post('ride', 'RideController@index');
    get('ride/chart/{id}','RideController@chart');
    post('ride/map','RideController@map');
    post('ride/details','RideController@details');

    //Statistics ;
    post('statistics', 'StatisticsController@index');

    //Rankings ;
    post('rankings', 'RankingsController@index');
    // POWER SPEED STAMINA TENACITY USER
    post('rankings/psst', 'RankingsController@getUserPSST');

    //Player Cards
    get('cards','CardsController@index');
    post('cards','CardsController@save');

    //Player Tutorial
    post('tutorial/update','TutorialController@update');

    //Player awards
    get('awards','AwardsController@index');
    post('awards','AwardsController@save');
    put('awards','AwardsController@order');

    // Feed
    get('feed','ActivityFeedController@index');

    //Achievements
    get('achievements/categories','AchievementsController@categories');
    get('achievements/{id?}','AchievementsController@index');

    // Strava Test
    get('strava/index','StravaController@index');
    get('strava/login','StravaController@login');
    get('strava/activities','StravaController@activities');

    get('test-login','TestController@stravaLogin');
    get('strava-login','TestController@getstravaLogin');
    get('test-csv','TestController@testCsv');

    get('logout',function(){
        Auth::client()->logout();
        return Redirect::to('/');
    });
});



Route::group(['prefix' => 'admin', 'middleware' => 'adminauth', 'namespace' => 'Admin'], function () {

    Route::get('/', function () {
        return redirect('admin/dashboard');
    });

    Route::get('dashboard', 'DashboardController@index');

    get('users','UsersController@index');
    get('users/edit/{user_id}', 'UsersController@edit');
    post('users/save/{user_id?}', 'UsersController@save');
    get('users/add', 'UsersController@add');
    get('users/ban/{user_id}', 'UsersController@ban');
    get('users/unban/{user_id}', 'UsersController@unban');
    get('users/delete/{user_id}','UsersController@delete');

    get('admins','AdministratorsController@index');
    get('admins/edit/{user_id}', 'AdministratorsController@edit');
    post('admins/save/{user_id?}', 'AdministratorsController@save');
    get('admins/add', 'AdministratorsController@add');
    get('admins/delete/{user_id}','AdministratorsController@delete');

    get('achievements','AchievementsController@index');
    get('achievements/add','AchievementsController@add');
    post('achievements/ajax-subcategories','AchievementsController@ajaxSubcategories');
    post('achievements/save/{id?}','AchievementsController@save');
    get('achievements/edit/{id}','AchievementsController@edit');
    get('achievements/delete/{id}','AchievementsController@delete');

    get('cards','CardsController@index');
    get('cards/edit/{card_id}', 'CardsController@edit');
    post('cards/save/{card_id?}', 'CardsController@save');
    get('cards/add', 'CardsController@add');
    get('cards/delete/{card_id}','CardsController@delete');

    get('awards','AwardsController@index');
    get('awards/edit/{award_id}', 'AwardsController@edit');
    post('awards/save/{award_id?}', 'AwardsController@save');
    get('awards/add', 'AwardsController@add');
    get('awards/delete/{award_id}','AwardsController@delete');


    //upload
    post('upload','UploadController@index');


});