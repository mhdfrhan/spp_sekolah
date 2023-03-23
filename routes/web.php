<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', 'DashboardController@getIndex')->middleware('auth:admin');
routecontroller('/','HomeController');

Route::group(['prefix' => 'admin'], function(){
	Route::namespace('Auth\Admin')->name('admin.')->group(function(){
		Route::get('/login','LoginController@showLoginForm')->name('login');
		Route::post('/login','LoginController@login');
		Route::post('/logout','LoginController@logout')->name('logout');

		Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
		Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

		Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
		Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

	});

	Route::group(['middleware' => 'auth:admin'], function () {
		routecontroller('/','DashboardController');
		routecontroller('json','DataController');
		routecontroller('data','AdminsController');
		routecontroller('students','StudentsController');
		routecontroller('rombels','RombelsController');
		routecontroller('spp','SppController');
		routecontroller('transactions','TransactionsController');
		routecontroller('invoice','InvoiceController');
		routecontroller('settings','SettingsController');
		routecontroller('log','ActivityController');
		routecontroller('test','TestingController');
	});

});

Route::group(['middleware' => 'auth:admin'], function () {
	Route::get('admin/invoice/reject/{id}', 'InvoiceController@reject');
	Route::get('admin/invoice/print/{id}', 'TransactionsController@print')->name('invoice.print');
	Route::get('admin/invoice/print', 'TransactionsController@printAll')->name('print.allInvoice');
	Route::get('admin/student/export', 'StudentsController@studentExport')->name('export.student');
	Route::get('admin/data/export', 'AdminsController@adminExport')->name('export.admin');
	Route::post('admin/students/import', 'StudentsController@studentImport')->name('import.student');
	Route::post('admin/data/import', 'AdminsController@adminImport')->name('import.admin');
	Route::get('admin/data/profile', 'AdminsController@showProfile')->name('admin.profile');
	Route::put('admin/data/profile', 'AdminsController@changeProfile')->name('change.profile');
	Route::get('admin/data/profile/image', 'AdminsController@deleteImage')->name('delete.image');
	Route::put('/admin/data/change-password', 'AdminsController@postChangePassword')->name('change.password');
	Route::get('admin/payment/reports', 'ReportsController@indexReports')->name('payment.reports');
	Route::get('admin/payment/arrears', 'ReportsController@indexArrears')->name('payment.arrears');
});

Route::get('user/change-password', 'UsersController@getChangePassword');


Auth::routes(['register' => false]);
Route::group(['middleware' => 'auth'], function () {
	routecontroller('dashboard','UsersDashboardController');
	routecontroller('transactions','UsersTransactionController');
	routecontroller('history','UsersHistoryController');
	routecontroller('user','UsersController');
});