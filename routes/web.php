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

Auth::routes();

Route::get('/signin', function () {
    return view('signin');
});

Route::post('/loginMy', 'SecurityController@signin')->name('loginMy');

//User Management
Route::post('/saveUser', 'UserController@save')->name('saveUser');
Route::get('/sign-up', function () {
    return view('sign-up', ['title' => 'Sign Up']);
});



Route::group(['middleware' => 'auth', 'prefix' => ''], function () {
    

    Route::get('/index', 'DashboardController@index')->name('index');
   

    Route::get('/logout', 'SecurityController@logoutNow')->name('logout');
    Route::post('/activateDeactivate', 'CommonController@activateDeactivate')->name('activateDeactivate');


     //booking
     Route::get('/make-a-booking', 'CustomerBookingController@makeABooking')->name('make-a-booking');
     Route::post('/getProductPrice', 'CustomerBookingController@getProductPrice')->name('getProductPrice');
     
     Route::post('/getAvailableQty', 'CustomerBookingController@getAvailableQty')->name('getAvailableQty');
 

     Route::post('/saveTempBookingInvProduct', 'CustomerBookingController@saveTempProduct')->name('saveTempBookingInvProduct');
     Route::post('/tableData', 'CustomerBookingController@tableData')->name('tableData');
     Route::post('/deleteTempBooking', 'CustomerBookingController@deleteTempBooking')->name('deleteTempBooking');
     Route::post('/editTempBooking', 'CustomerBookingController@editTempBooking')->name('editTempBooking');
     Route::post('/saveBooking', 'CustomerBookingController@saveBooking')->name('saveBooking');
 
    
    Route::group(['middleware' => 'customer', 'prefix' => ''], function () {
    
   
        
    //booking details
    Route::get('/completed-cus-works', 'CustomerBookingController@completedCusWorksIndex')->name('completed-cus-works');
    Route::get('/pending-cus-works', 'CustomerBookingController@pendingCusWorks')->name('pending-cus-works');
    Route::get('/test-page', 'TestController@testPage')->name('test-page');

     //user
     Route::get('/view-cus-customers', 'UserController@viewCustomersIndex')->name('view-cus-customers');
     Route::post('/updatePassword', 'UserController@updatePassword')->name('updatePassword');
     Route::post('/updateUser', 'UserController@updateUser')->name('updateUser');
     Route::post('/getUserById', 'UserController@getUserById')->name('getUserById');
   
     
     
});





    Route::group(['middleware' => 'admin', 'prefix' => ''], function () {

    //users
    Route::get('/add-employee', 'UserController@addemployeeIndex')->name('add-customer');
    Route::post('/saveDriver', 'UserController@saveDriver')->name('saveDriver');
    Route::get('/view-users', 'UserController@viewUsersIndex')->name('view-users');

    //categories
    Route::get('/categories', 'CategoryController@categories')->name('categories');
    Route::post('/saveCategory', 'CategoryController@save')->name('saveCategory');
    Route::post('/editCategory', 'CategoryController@edit')->name('editCategory');
    Route::post('/changeStatus', 'CategoryController@changeStatus')->name('changeStatus');

    //category prices
    Route::get('/category-prices', 'CategoryPriceController@categoryPrices')->name('category-prices');
    Route::post('/saveCategoryPrice', 'CategoryPriceController@store')->name('saveCategoryPrice');
    Route::post('/editCategoryPrice', 'CategoryPriceController@edit')->name('editCategoryPrice');



    Route::get('/main-categories', 'MainCategoryController@categoriesIndex')->name('main-categories');
    Route::post('/saveMainCategory', 'MainCategoryController@store')->name('saveMainCategory');
    Route::post('/updateMainCategory', 'MainCategoryController@update')->name('updateCategory');

    //Product
    Route::get('/products', 'ProductController@productsIndex')->name('products');
    Route::post('/saveProduct', 'ProductController@store')->name('saveProduct');
    Route::post('/saveItemImage', 'ProductController@imageStore')->name('saveItemImage');
    Route::get('/search-product', 'ProductController@search')->name('search-product');
    Route::post('/viewProduct', 'ProductController@viewProduct')->name('viewProduct');
    Route::post('/getProductById', 'ProductController@getById')->name('getProductById');
    Route::post('/updateProduct', 'ProductController@update')->name('updateProduct');
    Route::post('/updateItemImage', 'ProductController@imageUpdate')->name('updateItemImage');


    //PO
    Route::get('/add-po', 'PurchaseOrderController@addPoIndex')->name('add-po');
    Route::post('/getPOTempTableData', 'PurchaseOrderController@getPOTempTableData')->name('getPOTempTableData');
    Route::post('/saveTempPO', 'PurchaseOrderController@saveTempPO')->name('saveTempPO');
    Route::post('/deleteTempPO', 'PurchaseOrderController@deleteTempPO')->name('deleteTempPO');
    Route::post('/savePO', 'PurchaseOrderController@store')->name('savePO');
    Route::get('/pending-po', 'PurchaseOrderController@pendingPoIndex')->name('pending-po');
    Route::post('/viewPOById', 'PurchaseOrderController@getById')->name('viewPOById');
    Route::post('/getPOByID', 'PurchaseOrderController@getPOByID')->name('getPOByID');
    Route::post('/updateTempPO', 'PurchaseOrderController@updateTempPO')->name('updateTempPO');
    Route::get('/search-pending-po', 'PurchaseOrderController@searchPendingPo')->name('search-pending-po');
    Route::post('/approvedPO', 'PurchaseOrderController@approvedPO')->name('approvedPO');
    Route::get('/approved-po', 'PurchaseOrderController@approvedPoIndex')->name('approved-po');
    Route::get('/search-approved-po', 'PurchaseOrderController@searchApprovedPo')->name('search-approved-po');
    Route::get('/completed-po', 'PurchaseOrderController@completedPoIndex')->name('completed-po');
    Route::get('/search-completed-po', 'PurchaseOrderController@searchCompletedPo')->name('search-completed-po');

    //bbooking
    Route::get('/pending-works', 'BookingController@pendingWorksIndex')->name('pending-works');
    Route::post('/viewItemList', 'BookingController@viewItemList')->name('viewItemList');
    Route::post('/approvedOrder', 'BookingController@approvedOrder')->name('approvedOrder');

    Route::get('/accepted-works', 'BookingController@acceptedWorksIndex')->name('accepted-works');
    Route::post('/completedOrder', 'BookingController@completedOrder')->name('completedOrder');
    Route::get('/completed-works', 'BookingController@completeWorksIndex')->name('completed-works');
    Route::post('/generateBarCode', 'BookingController@generateBarCode')->name('generateBarCode');
    Route::get('/generate-invoice', 'BookingController@generateInvoiceIndex')->name('generate-invoice');
    
    Route::get('print_barcode/{id}', 'BookingController@printBarcode')->name('print_barcode');
   
    
    //invoice
    Route::post('/tableInvoiceData', 'InvoiceController@tableInvoiceData')->name('tableInvoiceData');
    Route::post('/saveTempInvProduct', 'InvoiceController@saveTempProduct')->name('saveTempInvProduct');
    Route::post('/deleteTempInv', 'InvoiceController@deleteTempInv')->name('deleteTempInv');
    Route::post('/editTempInvItem', 'InvoiceController@editTempInvItem')->name('editTempInvItem');
    Route::post('/saveInvoice', 'InvoiceController@saveInvoice')->name('saveInvoice');
    Route::get('/invoice-history', 'InvoiceController@invoiceHistoryIndex')->name('invoice-history');
    Route::get('print_invoice/{id}', 'InvoiceController@printInvoice')->name('print_invoice');
    Route::post('/getInvoiceItems', 'InvoiceController@getInvoiceItems')->name('getInvoiceItems');
   

    //reports
    Route::get('/pending-orders', 'ReportController@pendingOrdersIndex')->name('pending-orders');
    Route::get('/accepted-orders', 'ReportController@acceptedOrdersIndex')->name('accepted-orders');
    Route::get('/completed-orders', 'ReportController@completedOrdersIndex')->name('completed-orders');
    Route::get('/active-stock', 'ReportController@activeStockIndex')->name('active-stock');
    Route::get('/deactive-stock', 'ReportController@deactiveStockIndex')->name('deactive-stock');
    Route::get('/income-report', 'ReportController@incomeOrderIndex')->name('income-report');
   
   
    
    
    //Supplier
    Route::get('/suppliers', 'SupplierController@suppliersIndex')->name('suppliers');
    Route::post('/saveSupplier', 'SupplierController@store')->name('saveSupplier');
    Route::post('viewSupplier', 'SupplierController@viewTableData')->name('viewSupplier');
    Route::post('getSupplierById', 'SupplierController@getById')->name('getSupplierById');
    Route::post('updateSupplier', 'SupplierController@update')->name('updateSupplier');



      //GRN
      Route::get('/add-grn', 'GRNController@addGrnIndex')->name('add-grn');
      Route::post('/getProducts', 'GRNController@getProducts')->name('getProducts');
      Route::post('/getTempTableData', 'GRNController@getTempTableData')->name('getTempTableData');
      Route::post('/saveTempProduct', 'GRNController@tempStore')->name('saveTempProduct');
      Route::post('/getGrnItemById', 'GRNController@getTempById')->name('getGrnItemById');
      Route::post('/deleteGrnTemp', 'GRNController@deleteGrnTemp')->name('deleteGrnTemp');
      Route::post('saveGrn', 'GRNController@store')->name('saveGrn');
      Route::get('grn-history', 'GRNController@grnHistoryIndex')->name('grn-history');
      Route::get('search-grn-history', 'GRNController@search')->name('search-grn-history');
      Route::post('/getMoreByGrnID', 'GRNController@getMoreByGrnID')->name('getMoreByGrnID');
      Route::post('getGrnByID', 'GRNController@getByID')->name('getGrnByID');
      Route::post('getPOByDetails', 'GRNController@getPOByDetails')->name('getPOByDetails');
      Route::post('getTempProductId', 'GRNController@getTempProductId')->name('getTempProductId');
      Route::post('updateTempProduct', 'GRNController@updateTempProduct')->name('updateTempProduct');

    
    });

});
