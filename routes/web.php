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
use App\Http\Controllers\SalespaymentController;
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
    // DASHBOARD FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/home/datefilter', [HomeController::class, 'datefilter'])->name('home.datefilter');

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
        // CHECK DUPLICATE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/customer/checkduplicate', [CustomerController::class, 'checkduplicate'])->name('customer.checkduplicate');
         // VIEW
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/customer/view/{unique_key}', [CustomerController::class, 'view'])->name('customer.view');
         // REPORT VIEW
         Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/customer/viewfilter', [CustomerController::class, 'viewfilter'])->name('customer.viewfilter');
         // INDEX BRANCH WISE
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/customer/branchdata/{branch_id}', [CustomerController::class, 'branchdata'])->name('customer.branchdata');
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
        // CHECK DUPLICATE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/supplier/checkduplicate', [SupplierController::class, 'checkduplicate'])->name('supplier.checkduplicate');
        // VIEW
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/supplier/view/{unique_key}', [SupplierController::class, 'view'])->name('supplier.view');
        // REPORT VIEW
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/supplier/viewfilter', [SupplierController::class, 'viewfilter'])->name('supplier.viewfilter');
         // INDEX BRANCH WISE
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/supplier/branchdata/{branch_id}', [SupplierController::class, 'branchdata'])->name('supplier.branchdata');



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
        // CREATE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/expence/create', [ExpenceController::class, 'create'])->name('expence.create');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/expence/edit/{unique_key}', [ExpenceController::class, 'edit'])->name('expence.edit');
         // UPDATE
         Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/expence/update/{unique_key}', [ExpenceController::class, 'update'])->name('expence.update');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/expence/store', [ExpenceController::class, 'store'])->name('expence.store');
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
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/productlist', [ProductlistController::class, 'index'])->name('product.index');
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
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchase/invoiceedit/{unique_key}', [PurchaseController::class, 'invoiceedit'])->name('purchase.invoiceedit');
        // INVOICE UPDATE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchase/invoiceedit_update/{unique_key}', [PurchaseController::class, 'invoiceedit_update'])->name('purchase.invoiceedit_update');
    });



    // PURCHASE PAYMENT CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchasepayment', [PurchasePaymentController::class, 'index'])->name('purchasepayment.index');
        // CREATE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchasepayment/create', [PurchasePaymentController::class, 'create'])->name('purchasepayment.create');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/purchasepayment/store', [PurchasePaymentController::class, 'store'])->name('purchasepayment.store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchasepayment/edit/{unique_key}', [PurchasePaymentController::class, 'edit'])->name('purchasepayment.edit');
        // UPDATE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchasepayment/update/{unique_key}', [PurchasePaymentController::class, 'update'])->name('purchasepayment.update');
        // DELETE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchasepayment/delete/{unique_key}', [PurchasePaymentController::class, 'delete'])->name('purchasepayment.delete');
         // INDEX BRANCH WISE
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchasepayment/branchdata/{branch_id}', [PurchasePaymentController::class, 'branchdata'])->name('purchasepayment.branchdata');
         // DATAE FILTER
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchasepayment/datefilter', [PurchasePaymentController::class, 'datefilter'])->name('purchasepayment.datefilter');
    });


    // SALES PAYMENT CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/salespayment', [SalespaymentController::class, 'index'])->name('salespayment.index');
         // CREATE
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/salespayment/create', [SalespaymentController::class, 'create'])->name('salespayment.create');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/salespayment/store', [SalespaymentController::class, 'store'])->name('salespayment.store');
         // EDIT
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/salespayment/edit/{unique_key}', [SalespaymentController::class, 'edit'])->name('salespayment.edit');
         // UPDATE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/salespayment/update/{unique_key}', [SalespaymentController::class, 'update'])->name('salespayment.update');
        // INDEX BRANCH WISE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/salespayment/branchdata/{branch_id}', [SalespaymentController::class, 'branchdata'])->name('salespayment.branchdata');
        // DATAE FILTER
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/salespayment/datefilter', [SalespaymentController::class, 'datefilter'])->name('salespayment.datefilter');

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




    // PURCHASE ORDER CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchaseorder', [PurchaseController::class, 'purchaseorder_index'])->name('purchaseorder.purchaseorder_index');
         // INDEX BRANCH WISE
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchaseorder/purchaseorder_branchdata/{branch_id}', [PurchaseController::class, 'purchaseorder_branchdata'])->name('purchaseorder.purchaseorder_branchdata');
         // DATAE FILTER
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchaseorder/purchaseorder_datefilter', [PurchaseController::class, 'purchaseorder_datefilter'])->name('purchaseorder.purchaseorder_datefilter');
         // CREATE
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchaseorder/purchaseorder_create', [PurchaseController::class, 'purchaseorder_create'])->name('purchaseorder.purchaseorder_create');
         // STORE
         Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/purchaseorder/purchaseorder_store', [PurchaseController::class, 'purchaseorder_store'])->name('purchaseorder.purchaseorder_store');
         // EDIT
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchaseorder/purchaseorder_edit/{unique_key}', [PurchaseController::class, 'purchaseorder_edit'])->name('purchaseorder.purchaseorder_edit');
         // UPDATE
         Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchaseorder/purchaseorder_update/{unique_key}', [PurchaseController::class, 'purchaseorder_update'])->name('purchaseorder.purchaseorder_update');
         // INVOICE
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchaseorder/purchaseorder_invoice/{unique_key}', [PurchaseController::class, 'purchaseorder_invoice'])->name('purchaseorder.purchaseorder_invoice');
         // INVOICE UPDATE
         Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchaseorder/purchaseorder_invoiceupdate/{unique_key}', [PurchaseController::class, 'purchaseorder_invoiceupdate'])->name('purchaseorder.purchaseorder_invoiceupdate');
         // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchaseorder/purchaseorder_invoiceedit/{unique_key}', [PurchaseController::class, 'purchaseorder_invoiceedit'])->name('purchaseorder.purchaseorder_invoiceedit');
        // INVOICE UPDATE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/purchaseorder/purchaseorder_invoiceeditupdate/{unique_key}', [PurchaseController::class, 'purchaseorder_invoiceeditupdate'])->name('purchaseorder.purchaseorder_invoiceeditupdate');
        // VIEW
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/purchaseorder/purchaseorder_printview/{unique_key}', [PurchaseController::class, 'purchaseorder_printview'])->name('purchaseorder.purchaseorder_printview');
    });



    // SALES ORDER CONTROLLER
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // INDEX
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/salesorder', [SalesController::class, 'salesorder_index'])->name('salesorder.salesorder_index');
        // CREATE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/salesorder/salesorder_create', [SalesController::class, 'salesorder_create'])->name('salesorder.salesorder_create');
        // STORE
        Route::middleware(['auth:sanctum', 'verified'])->post('/zworktech-pos/salesorder/salesorder_store', [SalesController::class, 'salesorder_store'])->name('salesorder.salesorder_store');
        // EDIT
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/salesorder/salesorder_edit/{unique_key}', [SalesController::class, 'salesorder_edit'])->name('salesorder.salesorder_edit');
        // UPDATE
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/salesorder/salesorder_update/{unique_key}', [SalesController::class, 'salesorder_update'])->name('salesorder.salesorder_update');
        // INDEX BRANCH WISE
        Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/salesorder/salesorder_branchdata/{branch_id}', [SalesController::class, 'salesorder_branchdata'])->name('salesorder.salesorder_branchdata');
         // VIEW
         Route::middleware(['auth:sanctum', 'verified'])->get('/zworktech-pos/salesorder/salesorder_printview/{unique_key}', [SalesController::class, 'salesorder_printview'])->name('salesorder.salesorder_printview');
        // DATAE FILTER
        Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-pos/salesorder/salesorder_datefilter', [SalesController::class, 'salesorder_datefilter'])->name('salesorder.salesorder_datefilter');
    });

});



Route::get('getProducts/', [PurchaseController::class, 'getProducts']);

Route::get('/getoldbalance', [PurchaseController::class, 'getoldbalance']);
Route::get('/getoldbalanceforPayment', [PurchaseController::class, 'getoldbalanceforPayment']);
Route::get('/oldbalanceforsalespayment', [SalesController::class, 'oldbalanceforsalespayment']);

Route::get('/getoldbalanceforSales', [SalesController::class, 'getoldbalanceforSales']);
Route::get('/getPurchaseview', [PurchaseController::class, 'getPurchaseview']);
Route::get('/getSalesview', [SalesController::class, 'getSalesview']);
Route::get('/getsupplierbalance', [SupplierController::class, 'getsupplierbalance']);
Route::get('/getBranchName', [PurchaseController::class, 'getBranchName']);
Route::get('/getbranchwiseProducts', [SalesController::class, 'getbranchwiseProducts']);
Route::get('/getProductsdetail', [SalesController::class, 'getProductsdetail']);

Route::get('/Checkinvoiceupdated', [PurchaseController::class, 'Checkinvoiceupdated']);



Route::get('/getpurchaseorderview', [PurchaseController::class, 'getpurchaseorderview']);
Route::get('/salesorderview', [SalesController::class, 'salesorderview']);

Route::get('/pdf_export/{last_word}', [SupplierController::class, 'pdf_export']);

Route::get('/allpdf_export', [SupplierController::class, 'allpdf_export']);
