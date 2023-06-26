<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ProductlistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ExpenceController;
use App\Http\Controllers\PurchasePaymentController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

// INVITE ACCEPT
Route::get('/accept/{token}', [InviteController::class, 'accept']);

Auth::routes();

// BACKEND - ROUTE - WITH SANTUM VERIFIED
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // DASHBOARD
    Route::middleware(['auth:sanctum', 'verified'])->get('/home', [HomeController::class, 'index'])->name('home');

    // INVITE CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/invite', [InviteController::class, 'index'])->name('invite.index');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/invite/store', [InviteController::class, 'store'])->name('invite.store');
    });

    // BRANCH CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/branch', [BranchController::class, 'index'])->name('branch.index');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/branch/store', [BranchController::class, 'store'])->name('branch.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/branch/edit/{unique_key}', [BranchController::class, 'edit'])->name('branch.edit');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/branch/delete/{unique_key}', [BranchController::class, 'delete'])->name('branch.delete');
    });

    // CUSTOMER CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/customer', [CustomerController::class, 'index'])->name('customer.index');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/customer/store', [CustomerController::class, 'store'])->name('customer.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/customer/edit/{unique_key}', [CustomerController::class, 'edit'])->name('customer.edit');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/customer/delete/{unique_key}', [CustomerController::class, 'delete'])->name('customer.delete');
    });

    // SUPPLIER CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/supplier', [SupplierController::class, 'index'])->name('supplier.index');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/supplier/edit/{unique_key}', [SupplierController::class, 'edit'])->name('supplier.edit');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/supplier/delete/{unique_key}', [SupplierController::class, 'delete'])->name('supplier.delete');
        // CHECK BALANCE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/supplier/checkbalance/{id}', [SupplierController::class, 'checkbalance'])->name('supplier.checkbalance');
    });


    // UNIT CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/unit', [UnitController::class, 'index'])->name('unit.index');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/unit/store', [UnitController::class, 'store'])->name('unit.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/unit/edit/{unique_key}', [UnitController::class, 'edit'])->name('unit.edit');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/unit/delete/{unique_key}', [UnitController::class, 'delete'])->name('unit.delete');
    });


    // EXPENCE CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/expence', [ExpenceController::class, 'index'])->name('expence.index');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/expence/store', [ExpenceController::class, 'store'])->name('expence.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/expence/edit/{unique_key}', [ExpenceController::class, 'edit'])->name('expence.edit');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/expence/delete/{unique_key}', [ExpenceController::class, 'delete'])->name('expence.delete');
        // REPORT
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/expence/report', [ExpenceController::class, 'report'])->name('expence.report');
        // REPORT VIEW
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/expence/report_view', [ExpenceController::class, 'report_view'])->name('expence.report_view');
        // INDEX BRANCH WISE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/expence/branchdata/{branch_id}', [ExpenceController::class, 'branchdata'])->name('expence.branchdata');
        // DATAE FILTER
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/expence/datefilter', [ExpenceController::class, 'datefilter'])->name('expence.datefilter');
    });


    // BANK CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/bank', [BankController::class, 'index'])->name('bank.index');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/bank/store', [BankController::class, 'store'])->name('bank.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/bank/edit/{unique_key}', [BankController::class, 'edit'])->name('bank.edit');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/bank/delete/{unique_key}', [BankController::class, 'delete'])->name('bank.delete');
    });

    // PRODUCTLIST CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/product', [ProductlistController::class, 'index'])->name('product.index');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/productlist/store', [ProductlistController::class, 'store'])->name('productlist.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/productlist/edit/{unique_key}', [ProductlistController::class, 'edit'])->name('productlist.edit');
    });


    // PRODUCT CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/product', [ProductController::class, 'index'])->name('product.index');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/product/store', [ProductController::class, 'store'])->name('product.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/product/edit/{unique_key}', [ProductController::class, 'edit'])->name('product.edit');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/product/delete/{unique_key}', [ProductController::class, 'delete'])->name('product.delete');
        // STOCK
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/stockmanagement', [ProductController::class, 'stockmanagement'])->name('stockmanagement.index');
    });


    // PURCHASE CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
        // CREATE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchase/create', [PurchaseController::class, 'create'])->name('purchase.create');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/purchase/store', [PurchaseController::class, 'store'])->name('purchase.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchase/edit/{unique_key}', [PurchaseController::class, 'edit'])->name('purchase.edit');
        // UPDATE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchase/update/{unique_key}', [PurchaseController::class, 'update'])->name('purchase.update');
        // INVOICE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchase/invoice/{unique_key}', [PurchaseController::class, 'invoice'])->name('purchase.invoice');
        // INVOICE UPDATE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchase/invoice_update/{unique_key}', [PurchaseController::class, 'invoice_update'])->name('purchase.invoice_update');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchase/delete/{unique_key}', [PurchaseController::class, 'delete'])->name('purchase.delete');
        // VIEW
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchase/print_view/{unique_key}', [PurchaseController::class, 'print_view'])->name('purchase.print_view');
        // INDEX BRANCH WISE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchase/branchdata/{branch_id}', [PurchaseController::class, 'branchdata'])->name('purchase.branchdata');
        // REPORT
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchase/report', [PurchaseController::class, 'report'])->name('purchase.report');
        // REPORT VIEW
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchase/report_view', [PurchaseController::class, 'report_view'])->name('purchase.report_view');
        // DATAE FILTER
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchase/datefilter', [PurchaseController::class, 'datefilter'])->name('purchase.datefilter');
    });



    // PURCHASE PAYMENT CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchasepayment', [PurchasePaymentController::class, 'index'])->name('purchasepayment.index');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/purchasepayment/store', [PurchasePaymentController::class, 'store'])->name('purchasepayment.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/purchasepayment/edit/{unique_key}', [PurchasePaymentController::class, 'edit'])->name('purchasepayment.edit');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchasepayment/delete/{unique_key}', [PurchasePaymentController::class, 'delete'])->name('purchasepayment.delete');
    });


    // SALES CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/sales', [SalesController::class, 'index'])->name('sales.index');
        // CREATE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/sales/create', [SalesController::class, 'create'])->name('sales.create');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/sales/store', [SalesController::class, 'store'])->name('sales.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/sales/edit/{unique_key}', [SalesController::class, 'edit'])->name('sales.edit');
        // UPDATE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/sales/update/{unique_key}', [SalesController::class, 'update'])->name('sales.update');
        // INVOICE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/sales/invoice/{unique_key}', [SalesController::class, 'invoice'])->name('sales.invoice');
        // INVOICE UPDATE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/sales/invoice_update/{unique_key}', [SalesController::class, 'invoice_update'])->name('sales.invoice_update');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/sales/delete/{unique_key}', [SalesController::class, 'delete'])->name('sales.delete');
        // INDEX BRANCH WISE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/sales/branchdata/{branch_id}', [SalesController::class, 'branchdata'])->name('sales.branchdata');
         // VIEW
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/sales/print_view/{unique_key}', [SalesController::class, 'print_view'])->name('sales.print_view');
         // REPORT
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/sales/report', [SalesController::class, 'report'])->name('sales.report');
        // REPORT VIEW
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/sales/report_view', [SalesController::class, 'report_view'])->name('sales.report_view');
        // DATAE FILTER
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/sales/datefilter', [SalesController::class, 'datefilter'])->name('sales.datefilter');
    });
});



Route::get('getProducts/', [PurchaseController::class, 'getProducts']);

Route::get('/getoldbalance', [PurchaseController::class, 'getoldbalance']);
Route::get('/getoldbalanceforPayment', [PurchaseController::class, 'getoldbalanceforPayment']);

Route::get('/getoldbalanceforSales', [SalesController::class, 'getoldbalanceforSales']);
Route::get('/getPurchaseview', [PurchaseController::class, 'getPurchaseview']);
Route::get('/getSalesview', [SalesController::class, 'getSalesview']);
Route::get('/getsupplierbalance', [SupplierController::class, 'getsupplierbalance']);
Route::get('/getBranchName', [PurchaseController::class, 'getBranchName']);
Route::get('/getbranchwiseProducts', [SalesController::class, 'getbranchwiseProducts']);
Route::get('/getProductsdetail', [SalesController::class, 'getProductsdetail']);