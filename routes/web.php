<?php

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
});

Route::get('/access-denied', function() {
	return 'Access Denied';
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@getIndex');
Route::get('/invitations/accept/{email}', 'InvitationsController@getAccept');

Route::get('/email-login', 'AuthController@getEmailLogin');
Route::post('/email-login', 'AuthController@postEmailLogin');
Route::get('/email-logout', 'AuthController@getEmailLogout');

Route::group(['middleware' => ['service_owner']], function() {
	Route::get('/services', 'ServicesController@getIndex');
	Route::get('/services/details/{id}', 'ServicesController@getDetails');
	Route::get('/services/requirements/{id}', 'ServicesController@getRequirements');
	Route::get('/services/delivery/{id}', 'ServicesController@getDelivery');

	Route::get('/services/edit-owner/{id}', 'ServicesController@getEditOwner');
	Route::post('/services/edit-owner/{id}', 'ServicesController@postEditOwner');
	Route::get('/services/add-name/{id}', 'ServicesController@getAddName');
	Route::post('/services/add-name/{id}', 'ServicesController@postAddName');
	Route::get('/services/edit-name/{id}', 'ServicesController@getEditName');
	Route::post('/services/edit-name/{id}', 'ServicesController@postEditName');
	Route::get('/services/delete-name/{id}', 'ServicesController@getDeleteName');
	Route::post('/services/delete-name/{id}', 'ServicesController@postDeleteName');
	Route::get('/services/change-url/{id}', 'ServicesController@getChangeUrl');
	Route::post('/services/change-url/{id}', 'ServicesController@postChangeUrl');
	Route::get('/services/add-category/{id}', 'ServicesController@getAddCategory');
	Route::post('/services/add-category/{id}', 'ServicesController@postAddCategory');
	Route::get('/services/delete-category/{id}', 'ServicesController@getDeleteCategory');
	Route::post('/services/delete-category/{id}', 'ServicesController@postDeleteCategory');
	Route::get('/services/add-keyword/{id}', 'ServicesController@getAddKeyword');
	Route::post('/services/add-keyword/{id}', 'ServicesController@postAddKeyword');
	Route::get('/services/delete-keyword/{id}', 'ServicesController@getDeleteKeyword');
	Route::post('/services/delete-keyword/{id}', 'ServicesController@postDeleteKeyword');
	Route::get('/services/edit-keyword/{id}', 'ServicesController@getEditKeyword');
	Route::post('/services/edit-keyword/{id}', 'ServicesController@postEditKeyword');
	Route::get('/services/add-description/{id}', 'ServicesController@getAddDescription');
	Route::post('/services/add-description/{id}', 'ServicesController@postAddDescription');
	Route::get('/services/edit-description/{id}', 'ServicesController@getEditDescription');
	Route::post('/services/edit-description/{id}', 'ServicesController@postEditDescription');
	Route::get('/services/delete-description/{id}', 'ServicesController@getDeleteDescription');
	Route::post('/services/delete-description/{id}', 'ServicesController@postDeleteDescription');
	Route::get('/services/edit-details/{id}', 'ServicesController@getEditDetails');
	Route::post('/services/edit-details/{id}', 'ServicesController@postEditDetails');
	Route::get('/services/edit-eligibility/{id}', 'ServicesController@getEditEligibility');
	Route::post('/services/edit-eligibility/{id}', 'ServicesController@postEditEligibility');

	Route::get('/services/add-prerequisite/{id}', 'ServicesController@getAddPrerequisite');
	Route::post('/services/add-prerequisite/{id}', 'ServicesController@postAddPrerequisite');
	Route::get('/services/delete-prerequisite/{id}', 'ServicesController@getDeletePrerequisite');
	Route::post('/services/delete-prerequisite/{id}', 'ServicesController@postDeletePrerequisite');

	Route::get('/services/change-parent-service/{id}', 'ServicesController@getChangeParentService');
	Route::post('/services/change-parent-service/{id}', 'ServicesController@postChangeParentService');

	Route::get('/services/add-event/{id}', 'ServicesController@getAddEvent');
	Route::post('/services/add-event/{id}', 'ServicesController@postAddEvent');
	Route::get('/services/edit-event/{id}', 'ServicesController@getEditEvent');
	Route::post('/services/edit-event/{id}', 'ServicesController@postEditEvent');
	Route::get('/services/delete-event/{id}', 'ServicesController@getDeleteEvent');
	Route::post('/services/delete-event/{id}', 'ServicesController@postDeleteEvent');

	Route::get('/services/add-evidence/{id}', 'ServicesController@getAddEvidence');
	Route::post('/services/add-evidence/{id}', 'ServicesController@postAddEvidence');
	Route::get('/services/edit-evidence/{id}', 'ServicesController@getEditEvidence');
	Route::post('/services/edit-evidence/{id}', 'ServicesController@postEditEvidence');
	Route::get('/services/delete-evidence/{id}', 'ServicesController@getDeleteEvidence');
	Route::post('/services/delete-evidence/{id}', 'ServicesController@postDeleteEvidence');
});
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth','admin']], function() {
	Route::get('/dashboard', 'DashboardController@getIndex');
	Route::get('/services', 'ServicesController@getIndex');
});
