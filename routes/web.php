<?php

use App\Http\Controllers\MainAppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AmountLimitController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;

use App\Http\Controllers\Auth\ChangePasswordController;

use  Illuminate\Support\Facades\Auth;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Artist
    Route::delete('artists/destroy', 'ArtistController@massDestroy')->name('artists.massDestroy');
    Route::resource('artists', 'ArtistController');

    // Loan
    Route::delete('loans/destroy', 'LoanController@massDestroy')->name('loans.massDestroy');
    Route::resource('loans', 'LoanController');

    // Amount Limit
    Route::delete('amount-limits/destroy', 'AmountLimitController@massDestroy')->name('amount-limits.massDestroy');
    Route::resource('amount-limits', 'AmountLimitController');

    // Payment
    Route::delete('payments/destroy', 'PaymentController@massDestroy')->name('payments.massDestroy');
    Route::resource('payments', 'PaymentController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'App\Http\Controllers\Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::post('/4dbbcf85b5bd89d2b4e783f1c6bc17d3', [MainAppController::class, 'ussdRequestHandler'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;
