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

Route::get('/', function () {
    return 'Hello!';
});

Route::group(['middleware' => 'cors', 'prefix' => 'v1'], function(\Illuminate\Routing\Router $router) {
    $router->get('/users', 'UserController@showAll');
    $router->get('/users/{search}', 'UserController@searchUsers');
    $router->post('/user/photo', 'UserController@setPhoto');
    $router->get('/user/{id}', 'UserController@show');
    $router->get('/roles', 'RoleController@showAll');
    $router->get('/role/{id}', 'RoleController@show');
    $router->get('/categories', 'CategoryController@showAll');
    $router->get('/categories/friend', 'CategoryController@showFriendCategories');
    $router->get('/wishes', 'WishController@showAll');
    $router->post('/wish/add', 'WishController@addWish');
    $router->delete('/wish/{id}', 'WishController@deleteWish');
    $router->put('/wish/{id}', 'WishController@editWish');

    $router->get('/friends', 'FriendController@showAllFriends');
    $router->get('/friends/{id}', 'FriendController@showUserFriends');

    $router->post('/user/login', 'UserController@login');
    $router->post('/user/auth', 'UserController@getProfile');
    $router->post('/user/logout', 'UserController@logout');
    $router->post('/user/registration', 'UserController@registration');

    $router->post('/friend/add', 'FriendController@addFriend');
    $router->post('/friend/edit', 'FriendController@editFriend');
    $router->post('/friend/remove', 'FriendController@removeFriend');

    $router->get('/wishes/{id}', 'WishController@showFriendWishes');

    $router->put('publish_state_true/{id}', 'WishController@changePublishStateTrue');
    $router->put('publish_state_false/{id}', 'WishController@changePublishStateFalse');

    $router->put('present_state_true/{id}', 'WishController@changePresentStateTrue');
    $router->put('present_state_false/{id}', 'WishController@changePresentStateFalse');
});
