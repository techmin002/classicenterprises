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

use Modules\Lead\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;
use Modules\Lead\Http\Controllers\CustomerInstallationController;
use Modules\Lead\Http\Controllers\InstallationCategoryController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('leads', 'LeadController');
    Route::post('lead/transfer', [LeadController::class, 'leadtransfer'])->name('lead.transfer');
    Route::get('hot-leads', [LeadController::class, 'hotLeads'])->name('hot-leads');
    Route::get('warm-leads', [LeadController::class, 'warmLeads'])->name('warm-leads');
    Route::get('cold-leads', [LeadController::class, 'coldLeads'])->name('cold-leads');
    Route::get('salecategories', [LeadController::class, 'salecategories'])->name('salecategories');
    Route::get('salecategories.retailler', [LeadController::class, 'retailler'])->name('salecategories.retailler');
    Route::get('salecategories.wholeseller', [LeadController::class, 'wholeseller'])->name('salecategories.wholeseller');

    Route::post('response-store', [LeadController::class, 'responseStore'])->name('response.store');
    Route::post('response-update/{id}', [LeadController::class, 'responseUpdate'])->name('response.update');
    Route::delete('response-delete/{id}', [LeadController::class, 'responseDelete'])->name('response.destroy');
    Route::get('followups', [LeadController::class, 'followups'])->name('followups');
    Route::get('lead-convert/{id}', [LeadController::class, 'leadToClient'])->name('lead.clients');
    Route::post('lead-convert/store/', [LeadController::class, 'leadToClientStore'])->name('leads.convert.store');
    // web.php
    Route::get('/getproducts', [LeadController::class, 'getProducts'])->name('products');
    Route::get('/accessories', [LeadController::class, 'getAccessories'])->name('accessories');
    Route::get('/installation-queue/{sale_type}', [CustomerInstallationController::class, 'index'])->name('installation-queue.index');
    Route::get('/installation-create/{id}', [CustomerInstallationController::class, 'create'])->name('installation-create.create');

    Route::delete('/customer/destroy/{id}', [CustomerInstallationController::class, 'destroy'])->name('customers.destroy');


    Route::post('/installation-store/{id}', [CustomerInstallationController::class, 'store'])->name('store.installation.customer');
    Route::get('/installation-reports/{sale_type}', [CustomerInstallationController::class, 'installationReport'])->name('installation.reports');
    Route::get('/installation-complete/{sale_type}', [CustomerInstallationController::class, 'installationComplete'])->name('installation.complete');
    Route::get('customer/payment/details/{id}', [CustomerInstallationController::class, 'customerPaymentDetails'])->name('customer.payment.details');
    Route::get('customer/details/{id}', [CustomerInstallationController::class, 'customerDetails'])->name('customer.details');
    Route::get('customer/documents/{id}', [CustomerInstallationController::class, 'customerDocuments'])->name('customer.documents');


    Route::get('/installation-assign/{sale_type}', [CustomerInstallationController::class, 'assignindex'])->name('installation-assign.index');
    Route::put('/installation-assignstore/{id}', [CustomerInstallationController::class, 'assignStore'])->name('installation-assign.store');
    Route::put('/installation-messageupdate/{id}', [CustomerInstallationController::class, 'messageupdate'])->name('leads.message.update');



    Route::get('/installation-category-queue/{installation_category}', [InstallationCategoryController::class, 'index'])->name('installation-category-queue.index');
    Route::get('/installation-category-create/{id}', [InstallationCategoryController::class, 'create'])->name('installation-category-create.create');
    Route::post('/installation-category-store/{id}', [InstallationCategoryController::class, 'store'])->name('store.installation-category.customer');
    Route::get('/installation-category-assign/{installation_category}', [InstallationCategoryController::class, 'assignindex'])->name('installation-category-assign.index');
    Route::put('/installation-category-assignstore/{id}', [InstallationCategoryController::class, 'assignstore'])->name('installation-category-assign.store');
    Route::get('/installation-category-reports/{installation_category}', [InstallationCategoryController::class, 'installationCategoryReport'])->name('installation-category.reports');
    Route::get('/installation-category-complete/{installation_category}', [InstallationCategoryController::class, 'installationCategoryComplete'])->name('installation-category.complete');
    Route::get('/get-staff', [LeadController::class, 'getStaff'])->name('get.staff');
    Route::get('/get-customer', [LeadController::class, 'getcustomer'])->name('get.customer');


    // Route::get('customer/payment/details/{id}', [InstallationCategoryController::class, 'customerPaymentDetails'])->name('customer.payment.details');
    Route::get('customer/details/{id}', [InstallationCategoryController::class, 'customerDetails'])->name('customer.details');
    Route::get('lead/details/{id}', [LeadController::class, 'LeadDetails'])->name('lead.details');

    Route::get('/customer/{id}/pdf', [InstallationCategoryController::class, 'customerDetailsPDF'])->name('customer.pdf');
});
