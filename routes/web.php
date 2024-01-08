<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthFeController;

Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionController');

    // Roles
    Route::delete('roles/destroy', 'RoleController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RoleController');

    //Requests
    Route::resource('requests', 'RequestController');

    // Members
    Route::delete('members/destroy', 'MemberController@massDestroy')->name('members.massDestroy');
    Route::resource('members', 'MemberController');

    //Divisions
    Route::resource('divisions', 'DivisionController');

    //Teams
    Route::resource('teams', 'TeamController');

    //Points
    Route::resource('points', 'PointActionController');

    //Notification
    Route::resource('notification', 'NotificationController');

    //Leave
    Route::get('show-request', 'LeaveController@showRequest')->name('showRequest');
    Route::get('add-all-leave', 'LeaveController@addAllLeave')->name('addAllLeave');
    Route::post('store-all-leave', 'LeaveController@storeAllLeave')->name('storeAllLeave');
    Route::resource('leaves', 'LeaveController');

    //Holidays
    Route::resource('holidays', 'HolidayController');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});
Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'FrontEnd', 'middleware' => ['auth']], function () {
    // notification
    Route::resource('notification', 'NotificationController');
    Route::resource('r-point', 'PointController');
    Route::resource('profile', 'MemberController');
    Route::resource('timesheet', 'TimeSheetController');
    Route::post('get-over-time', 'TimeSheetController@getOverTime')->name('getOverTime');
});
Route::group([ 'middleware' => ['auth']], function () {
    // login

});
Route::get('user/login', [AuthFeController::class, 'index'])->name('login.user.index');
Route::post('user/login-store', [AuthFeController::class, 'store'])->name('login.store');
Route::put('user/logout', [AuthFeController::class, 'logout'])->name('logout.put');
