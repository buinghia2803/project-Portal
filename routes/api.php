<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1/user', 'as' => 'api.', 'namespace' => 'Api\V1\Auth'], function () {
    //login, signup
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
});

Route::group(['prefix' => 'v1/user', 'as' => 'api.', 'namespace' => 'Api\V1\Auth', 'middleware' => ['auth:api']], function () {
    Route::get('/', 'AuthController@user');

    Route::get('logout', 'AuthController@logout');
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Member', 'middleware' => ['auth:api']], function () {
    Route::post('profile/change-password', 'MemberController@changePassword');

    //points
    Route::apiResource('points', 'PointsApiController');

    //Notifications
    Route::apiResource('notifications', 'NotificationsApiController');

    //Members
    Route::apiResource('members', 'MemberController');
    // Route::apiResource('profile', 'MemberController');
    Route::post('profile', 'MemberController@update');
    Route::get('profile', 'MemberController@index');

    Route::apiResource('requests', 'RequestApiController');
    Route::post('requests/{request}', 'RequestApiController@update');
    //Time sheet 
    // Route::apiResource('timesheets', 'TimeSheetApiController');
    Route::get('timesheets', 'TimeSheetApiController@index');
    Route::get('timesheets/{work_day}', 'TimeSheetApiController@detail');

    // Member shift detail
    Route::get('member_shift_detail', 'MemberController@memberShiftDetail');

    // Member checklogs
    Route::get('checklogs/{work_day}', 'TimeSheetApiController@checklogs');
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {

    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // leave quotas
    Route::apiResource('leave_quotas', 'LeaveQuotaApiController');

    //Notifications
    Route::apiResource('admin/notifications', 'NotificationsApiController');
});

Route::group(['prefix' => 'v1/manager', 'as' => 'api.', 'namespace' => 'Api\V1\Manager', 'middleware' => ['auth:api']], function () {
    // requests manager
    Route::apiResource('requests', 'RequestsManagerApiController');
});

Route::group(['prefix' => 'v1/admin', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // requests admin
    Route::apiResource('requests', 'RequestsAdminApiController');
});
