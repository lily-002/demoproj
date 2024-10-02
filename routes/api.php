<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EledgerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\EInvoiceController;
use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\DeliveryNoteController;
use App\Http\Controllers\ProducerReceiptController;
use App\Http\Controllers\IncomingDeliveryNoteController;
use App\Http\Controllers\OutGoingDeliveryNoteController;
use App\Http\Controllers\OutgoingProducerReceiptController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Auth Routes */
Route::post('/auth/login', [AuthController::class, 'login'])->name('login')->withoutMiddleware('role:admin');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register')->withoutMiddleware('role:admin');

Route::group([
    'middleware' => ['auth:api', 'role:admin'],
    'prefix' => '/admin/invoices' // Change the prefix as appropriate for invoices
], function ($router) {
    Route::post('/fetch-send-type', [InvoiceController::class, 'getSendType']);
});

// Route::post('/auth/login', [AuthController::class, 'login'])->name('login')->withoutMiddleware('role:admin');
// Route::post('/auth/register', [AuthController::class, 'register'])->name('register')->withoutMiddleware('role:admin');
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password')->withoutMiddleware('role:admin');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password')->withoutMiddleware('role:admin');

// Contact routes
Route::get('/admin/contacts', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/admin/contacts/{id}', [ContactController::class, 'show']);
// Route::put('/admin/contacts/{id}', [ContactController::class, 'update']);
Route::delete('/admin/contacts/{id}', [ContactController::class, 'destroy']);
 
 Route::group([
    'middleware' => ['auth:api', 'role:admin,user'],
     'prefix' => 'user'
 ], function ($router) {
     Route::get('me', [UserController::class, 'me']);
     Route::get('company', [UserController::class, 'company']);
     Route::put('update_profile', [UserController::class, 'updateProfile']);
     Route::put('update_password', [UserController::class, 'updatePassword']);
     Route::post('logout', [UserController::class, 'logout']);
});

// Company Routes for Admin 
Route::group([
    'middleware' => ['auth:api', 'role:admin'],
    'prefix' => '/admin/companies'
], function ($router) {
    Route::post('', [CompanyController::class, 'createCompany']);
    Route::get('', [CompanyController::class, 'listCompany']);
    Route::get('{id}', [CompanyController::class, 'showCompany']);
    Route::put('{id}', [CompanyController::class, 'updateCompany']);
    Route::delete('{id}', [CompanyController::class, 'deleteCompany']);
});

// Users Routes for Admin
Route::group([
    'middleware' => ['auth:api', 'role:admin'],
    'prefix' => 'admin/users'
], function ($router) {
    Route::post('', [UsersController::class, 'createUser']);
    Route::get('', [UsersController::class, 'listUsers']);
    Route::get('company/{id}', [UsersController::class, 'listUsersForCompany']);
    Route::get('{id}', [UsersController::class, 'showUser']);
    Route::put('{id}', [UsersController::class, 'updateUser']);
    Route::delete('{id}', [UsersController::class, 'deleteUser']);
});

// E-Invoice Routes for User
Route::group([
    'middleware' => ['auth:api', 'role:user,admin'],
    'prefix' => 'user/invoice'
], function ($router) {
    Route::get("", [InvoiceController::class, 'getInvoices']);
    Route::post("", [InvoiceController::class, 'createInvoice']);
    Route::get('{id}', [InvoiceController::class, 'getInvoice']);
    Route::put('{id}', [InvoiceController::class, 'update']);
    Route::delete('{id}', [InvoiceController::class, 'delete']);
    Route::get('ubl/{id}', [InvoiceController::class, 'generateUblXml']);
    Route::get('ubl/{id}', [InvoiceController::class, 'generateUbl']);

});

// E-Delivery Note Routes for User
Route::group([
    'middleware' => ['auth:api', 'role:user,admin'],
    'prefix' => 'user/delivery-note'



    
], function ($router) {
    Route::get("", [DeliveryNoteController::class, 'getDeliveryNotes']);
    Route::post("", [DeliveryNoteController::class, 'createDeliveryNote']);
    Route::get('{id}', [DeliveryNoteController::class, 'getDeliveryNote']);
    Route::put('{id}', [DeliveryNoteController::class, 'updateDeliveryNote']);
    Route::delete('{id}', [DeliveryNoteController::class, 'deleteDeliveryNote']);
    Route::get('ubl/{id}', [DeliveryNoteController::class, 'generateUbl']);
});

// E-Ledger Routes for User
Route::group([
    'middleware' => ['auth:api', 'role:user,admin'],
    'prefix' => 'user/eledger'
], function ($router) {
    Route::get("", [EledgerController::class, 'getEledgers']);
    Route::post("", [EledgerController::class, 'addEledger']);
    Route::get('{id}', [EledgerController::class, 'getEledger']);
    Route::put('{id}', [EledgerController::class, 'updateEledger']);
    Route::delete('{id}', [EledgerController::class, 'deleteEledger']);
});

// Producer receipt
Route::group([
    'middleware' => ['auth:api', 'role:user,admin'],
    'prefix' => 'user/producer-receipts'
], function () {
    Route::get("/", [ProducerReceiptController::class, 'index']);
    Route::post("/", [ProducerReceiptController::class, 'store']);
    Route::get('/{id}', [ProducerReceiptController::class, 'show']);
    Route::put('/{id}', [ProducerReceiptController::class, 'update']);
    Route::delete('/{id}', [ProducerReceiptController::class, 'destroy']);
    Route::get('/ubl/{id}', [ProducerReceiptController::class, 'generateUbl']);
});

Route::group([
    'middleware' => ['auth:api', 'role:user'],
    'prefix' => 'user/einvoice'
], function ($router) {
    Route::post('create/{id}', [EInvoiceController::class, 'create']);
    Route::get('{id}', [EInvoiceController::class, 'list']);
    Route::get('show/{id}', [EInvoiceController::class, 'show']);
    Route::put('update/{id}', [EInvoiceController::class, 'update']);
    Route::delete('delete/{id}', [EInvoiceController::class, 'delete']);
    Route::get('ubl/{id}', [EInvoiceController::class, 'createUblXml']);

});

//Incoming delivery note routes
Route::group([
    'middleware' => ['auth:api', 'role:user,admin'],
    'prefix' => 'user/id-notes'
], function () {
    //Incoming
    Route::get('incoming', [IncomingDeliveryNoteController::class, 'getNotesIncoming']);
    Route::get('incoming/{id}', [IncomingDeliveryNoteController::class, 'getNoteIncoming']);
    Route::post('incoming', [IncomingDeliveryNoteController::class, 'createNoteIncoming']);
    Route::put('incoming/{id}', [IncomingDeliveryNoteController::class, 'updateNoteIncoming']);
    Route::delete('incoming/{id}', [IncomingDeliveryNoteController::class, 'deleteNoteIncoming']);
    Route::get('incoming/ubl/{id}', [IncomingDeliveryNoteController::class, 'generateUblIncoming']);

    //Call
    Route::get('call', [IncomingDeliveryNoteController::class, 'getNotesCall']);
    Route::get('call/{id}', [IncomingDeliveryNoteController::class, 'getNoteCall']);
    Route::post('call', [IncomingDeliveryNoteController::class, 'createNoteCall']);
    Route::put('call/{id}', [IncomingDeliveryNoteController::class, 'updateNoteCall']);
    Route::delete('call/{id}', [IncomingDeliveryNoteController::class, 'deleteNoteCall']);
    Route::get('call/ubl/{id}', [IncomingDeliveryNoteController::class, 'generateUblCall']);

    //Archive
    Route::get('archive', [IncomingDeliveryNoteController::class, 'getNotesArchive']);
    Route::get('archive/{id}', [IncomingDeliveryNoteController::class, 'getNoteArchive']);
    Route::post('archive', [IncomingDeliveryNoteController::class, 'createNoteArchive']);
    Route::put('archive/{id}', [IncomingDeliveryNoteController::class, 'updateNoteArchive']);
    Route::delete('archive/{id}', [IncomingDeliveryNoteController::class, 'deleteNoteArchive']);
    Route::get('archive/ubl/{id}', [IncomingDeliveryNoteController::class, 'generateUblArchive']);

});

//Outgoing delivery note routes
Route::group([
    'middleware' => ['auth:api', 'role:user,admin'],
    'prefix' => 'user/od-note'
], function () {
    //Outgoing
    Route::get('outgoing', [OutGoingDeliveryNoteController::class, 'getODNotesOutgoing']);
    Route::get('outgoing/{id}', [OutGoingDeliveryNoteController::class, 'getODNoteOutgoing']);
    Route::post('outgoing', [OutGoingDeliveryNoteController::class, 'createODNoteOutgoing']);
    Route::put('outgoing/{id}', [OutGoingDeliveryNoteController::class, 'updateODNoteOutgoing']);
    Route::delete('outgoing/{id}', [OutGoingDeliveryNoteController::class, 'deleteODNoteOutgoing']);
    Route::get('outgoing/ubl/{id}', [OutGoingDeliveryNoteController::class, 'generateUblOutgoing']);

    //Archive
    Route::get('archive', [OutGoingDeliveryNoteController::class, 'getODNotesArchive']);
    Route::get('archive/{id}', [OutGoingDeliveryNoteController::class, 'getODNoteArchive']);
    Route::post('archive', [OutGoingDeliveryNoteController::class, 'createODNoteArchive']);
    Route::put('archive/{id}', [OutGoingDeliveryNoteController::class, 'updateODNoteArchive']);
    Route::delete('archive/{id}', [OutGoingDeliveryNoteController::class, 'deleteODNoteArchive']);
    Route::get('archive/ubl/{id}', [OutGoingDeliveryNoteController::class, 'generateUblArchive']);

    //Cancellation
    Route::get('cancellation', [OutGoingDeliveryNoteController::class, 'getODNotesCancellation']);
    Route::get('cancellation/{id}', [OutGoingDeliveryNoteController::class, 'getODNoteCancellation']);
    Route::post('cancellation', [OutGoingDeliveryNoteController::class, 'createODNoteCancellation']);
    Route::put('cancellation/{id}', [OutGoingDeliveryNoteController::class, 'updateODNoteCancellation']);
    Route::delete('cancellation/{id}', [OutGoingDeliveryNoteController::class, 'deleteODNoteCancellation']);

     //Call
    Route::get('call', [OutGoingDeliveryNoteController::class, 'getODNotesCall']);
    Route::get('call/{id}', [OutGoingDeliveryNoteController::class, 'getODNoteCall']);
    Route::post('call', [OutGoingDeliveryNoteController::class, 'createODNoteCall']);
    Route::put('call/{id}', [OutGoingDeliveryNoteController::class, 'updateODNoteCall']);
    Route::delete('call/{id}', [OutGoingDeliveryNoteController::class, 'deleteODNoteCall']); 
});

//Outgoing producer receipt routes
Route::group([
    'middleware' => ['auth:api', 'role:user,admin'],
    'prefix' => 'user/producer-receipts'
], function () {
    // Archives
    Route::get('/archives', [OutgoingProducerReceiptController::class, 'indexArchives']);
    Route::get('/archives/{id}', [OutgoingProducerReceiptController::class, 'showArchives']);
    Route::post('/archives', [OutgoingProducerReceiptController::class, 'storeArchives']);
    Route::put('/archives/{id}', [OutgoingProducerReceiptController::class, 'updateArchives']);
    Route::delete('/archives/{id}', [OutgoingProducerReceiptController::class, 'destroyArchives']);
    Route::get('/archives/{id}/ubl', [OutgoingProducerReceiptController::class, 'generateUblArchives']);
    // Calls
    Route::get('/calls', [OutgoingProducerReceiptController::class, 'indexCalls']);
    Route::get('/calls/{id}', [OutgoingProducerReceiptController::class, 'showCalls']);
    Route::post('/calls', [OutgoingProducerReceiptController::class, 'storeCalls']);
    Route::put('/calls/{id}', [OutgoingProducerReceiptController::class, 'updateCalls']);
    Route::delete('/calls/{id}', [OutgoingProducerReceiptController::class, 'destroyCalls']);
    Route::get('/calls/{id}/ubl', [OutgoingProducerReceiptController::class, 'generateUblCalls']);
    // Cancellations
    Route::get('/cancellations', [OutgoingProducerReceiptController::class, 'indexCancellations']);
    Route::get('/cancellations/{id}', [OutgoingProducerReceiptController::class, 'showCancellations']);
    Route::post('/cancellations', [OutgoingProducerReceiptController::class, 'storeCancellations']);
    Route::put('/cancellations/{id}', [OutgoingProducerReceiptController::class, 'updateCancellations']);
    Route::delete('/cancellations/{id}', [OutgoingProducerReceiptController::class, 'destroyCancellations']);
    Route::get('/cancellations/{id}/ubl', [OutgoingProducerReceiptController::class, 'generateUblCancellations']);
    // Outgoings
    Route::get('/outgoings', [OutgoingProducerReceiptController::class, 'indexOutgoings']);
    Route::get('/outgoings/{id}', [OutgoingProducerReceiptController::class, 'showOutgoings']);
    Route::post('/outgoings', [OutgoingProducerReceiptController::class, 'storeOutgoings']);
    Route::put('/outgoings/{id}', [OutgoingProducerReceiptController::class, 'updateOutgoings']);
    Route::delete('/outgoings/{id}', [OutgoingProducerReceiptController::class, 'destroyOutgoings']);
    Route::get('/outgoings/{id}/ubl', [OutgoingProducerReceiptController::class, 'generateUblOutgoings']);
});

// Address Book Routes for User
Route::group([
    'middleware' => ['auth:api', 'role:user,admin'],
    'prefix' => 'user/address-books'
], function ($router) {
    Route::get("", [AddressBookController::class, 'getAll']);
    Route::post("", [AddressBookController::class, 'create']);
    Route::get('{id}', [AddressBookController::class, 'getById']);
});

Route::group([
    'middleware' => ['auth:api', 'role:admin'],
    'prefix' => 'user/address-books'
], function ($router) {
    Route::put('{id}', [AddressBookController::class, 'update']);
    Route::delete('{id}', [AddressBookController::class, 'delete']);
});

// Utils Routes 
  Route::group([
    'middleware' => ['auth:api', 'role:admin,user'],
     'prefix' => 'utils'
 ], function ($router) {
     Route::get('invoice_send_types', [UtilsController::class, 'getInvoiceSendTypes']);
     Route::get('invoice_types', [UtilsController::class, 'getInvoiceTypes']);
     Route::get('invoice_scenarios', [UtilsController::class, 'getInvoiceScenarios']);
     Route::get('currencies', [UtilsController::class, 'getCurrencies']);
     Route::get('units', [UtilsController::class, 'getUnits']);
     Route::get('delivery_note_submission_types', [UtilsController::class, 'getDeliveryNoteSubmissionTypes']);
     Route::get('delivery_note_invoice_scenarios', [UtilsController::class, 'getDeliveryNoteInvoiceScenarios']);
     Route::get('delivery_note_despatch_types', [UtilsController::class, 'getDeliveryNoteDespatchTypes']);
     Route::get('eledger_categories', [UtilsController::class, 'getEledgerCategories']);
     Route::get('payment_methods', [UtilsController::class, 'getPaymentMethods']);
     Route::get('eledger_statuses', [UtilsController::class, 'getEledgerStatuses']);
     Route::get('eledger_tax_infos', [UtilsController::class, 'getEledgerTaxInfos']);
     Route::get('eledger_transaction_types', [UtilsController::class, 'getEledgerTransactionTypes']);
     Route::get('product_categories', [UtilsController::class, 'getProductCategories']);
     Route::get('product_subcategories/{id}', [UtilsController::class, 'getProductSubCategories']);
 });
















