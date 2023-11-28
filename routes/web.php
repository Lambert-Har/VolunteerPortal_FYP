<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountActions;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\PayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('user.index');
})->name('user.index');
Route::get('/create-accounts', function () {
    return view('user.create-accounts');
})->name('user.create-accounts');
Route::get('/vol-signup', function () {
    return view('user.vol-signup');
})->name('user.vol-signupp');
Route::get('/vol-login', function () {
    return view('user.vol-login');
})->name('user.vol-loginn');
Route::get('/vol-verification', function () {
    return view('user.vol-verification');
})->name('user.vol-verificationn');

Route::post('/vol-signup', [HomeController::class, 'volunteerSignup'])->name('user.vol-signup');
Route::post('/vol-verification', [HomeController::class, 'volunteerVerification'])->name('user.vol-verification');
Route::post('/vol-login', [HomeController::class, 'volunteerLogin'])->name('user.vol-login');
Route::get('/vol-logout', [HomeController::class, 'volunteerLogout'])->name('user.vol-logout');

// organization
Route::get('/org-signup', function () {
    return view('user.org-signup');
})->name('user.org-signupp');
Route::get('/org-login', function () {
    return view('user.org-login');
})->name('user.org-loginn');
Route::get('/org-verification', function () {
    return view('user.org-verification');
})->name('user.org-verificationn');

Route::post('/org-signup', [HomeController::class, 'organizationSignup'])->name('user.org-signup');
Route::post('/org-verification', [HomeController::class, 'organizationVerification'])->name('user.org-verification');
Route::post('/org-login', [HomeController::class, 'organizationLogin'])->name('user.org-login');
Route::get('/org-logout', [HomeController::class, 'organizationLogout'])->name('user.org-logout');


// inside accounts
// cadidate
Route::get('/home', [AccountActions::class, 'candHome'])->name('cand.home');
Route::get('/dashboard', [AccountActions::class, 'candDashboard'])->name('cand.dashboard');
Route::get('/pastevent', [AccountActions::class, 'candPastEvent'])->name('cand.pastevent');
Route::get('/community', [AccountActions::class, 'community'])->name('cand.community');
Route::get('/settings', [AccountActions::class, 'settings'])->name('cand.settings');
Route::get('/support', [AccountActions::class, 'support'])->name('cand.support');
// Route::get('/apply/{opportunityId}', [AccountActions::class, 'candHome'])->name('apply');
Route::get('/apply/{opportunityId}', [AccountActions::class, 'apply'])->name('apply');



// company
Route::get('/org-newpost', function () {
    $organizationId = session('organization')->id;
    return view('org.newpost', ['organizationId' => $organizationId]);
})->name('org.newpostt'); 

Route::get('/ogr-dashboard', [AccountActions::class, 'orgDashboard'])->name('org.dashboard');
Route::post('/org-newpost', [AccountActions::class, 'newPost'])->name('org.newpost');
Route::get('/org-applicants', [AccountActions::class, 'orgApplicants'])->name('org.applicants');
Route::get('/org-community', [AccountActions::class, 'orgCommunity'])->name('org.community');
Route::get('/org-settings', [AccountActions::class, 'orgSettings'])->name('org.settings');
Route::get('/org-support', [AccountActions::class, 'orgSupport'])->name('org.support');


// org CRUD operations
// dashboard
Route::put('/opportunity/update/{opportunity}', [CrudController::class, 'updateOpportunity'])->name('opportunity.update');
Route::put('/opportunity/cancel', [CrudController::class, 'cancelOpportunity'])->name('opportunity.cancel');
Route::put('/opportunity/complete', [CrudController::class, 'completeOpportunity'])->name('opportunity.complete');
// Route::put('/opportunity/delete', [CrudController::class, 'deleteOpportunity'])->name('opportunity.delete');

// applicants
Route::put('/application/accept', [CrudController::class, 'accceptApplication'])->name('application.accept');
Route::put('/application/reject', [CrudController::class, 'rejectApplication'])->name('application.reject');
Route::put('/application/suspend', [CrudController::class, 'suspendApplication'])->name('application.suspend');

//post
Route::post('/community/post', [CommunityController::class, 'store'])->name('community.post');
Route::post('/community/Org/post', [CommunityController::class, 'storeOrgCommunity'])->name('community.orgpost');

// settings
Route::post('/settings/org/update/{organisationId}', [CrudController::class, 'updateOrg'])->name('org.update-profile');
Route::post('/settings/org/pass/update/{organisationId}', [CrudController::class, 'updatePassOrg'])->name('org.update-password');
Route::put('/settings/org/delete', [CrudController::class, 'deleteOrg'])->name('org.delete-account');

// Volunteer CRUD operation
Route::post('/settings/update/{userId}', [CrudController::class, 'updateUser'])->name('user.update-profile');
Route::post('/settings/pass/update/{userId}', [CrudController::class, 'updatePassUser'])->name('user.update-password');
Route::put('/settings/delete', [CrudController::class, 'deleteUser'])->name('user.delete-account');
Route::delete('/cancel/application', [CrudController::class, 'cancelApplication'])->name('user.delete-application');


// Admin
Route::get('/admin-login', function () {
    return view('admin.login');
})->name('admin.ad-login');
Route::get('/admin-register', function () {
    return view('admin.register');
})->name('admin.ad-register');


Route::post('/register', [AdminController::class, 'adminRegister'])->name('admin.register');
Route::post('/login', [AdminController::class, 'adminLogin'])->name('admin.login');
Route::get('/admin-logout', [AdminController::class, 'adminLogout'])->name('admin.logout');

Route::get('/admin-dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');

// users
Route::get('/all-users', [AdminController::class, 'adminUsers'])->name('admin.users');
Route::put('/user-update/{userId}', [AdminController::class, 'updateUser'])->name('admin.update-user');
Route::put('/user/recover', [AdminController::class, 'recoverUser'])->name('admin.recover-user');
Route::delete('/user/delete', [AdminController::class, 'deleteUserAccount'])->name('admin.delete-user');

// organizations
Route::get('/all-organizations', [AdminController::class, 'adminOrganizations'])->name('admin.organizations');
Route::put('/organization-update/{organizationId}', [AdminController::class, 'updateOrganization'])->name('admin.update-organization');
Route::put('/organization/recover', [AdminController::class, 'recoverOrganization'])->name('admin.recover-organization');
Route::delete('/organizationIdrganization/delete', [AdminController::class, 'deleteOrganizationAccount'])->name('admin.delete-organization');

// posts
Route::get('/all-opportunities', [AdminController::class, 'adminOpportunities'])->name('admin.opportunities');
Route::delete('/event/delete', [AdminController::class, 'deleteOpportunity'])->name('admin.delete-opportunity');

// payment
Route::get('/payment', function () {
    return view('payment.pay');
})->name('payment.payment');
Route::get('/confirmation', function () {
    return view('payment.confirmation');
})->name('payment.confirmation');

Route::post('/payments', [PayController::class, 'payment'])->name('pay.payment');
Route::get('/confirm', [PayController::class, 'confirm'])->name('pay.confirm');
