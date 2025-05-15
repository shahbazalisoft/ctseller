<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomRoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveryManController;
use App\Http\Controllers\Admin\DmVehicleController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RetailerController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\VendorController;


Route::middleware(['web'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    #Category Management
    Route::prefix('category')->as('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/add', 'add')->name('add');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/status/{id}/{status}', 'status')->name('status');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::get('/update-priority/{category}', 'update_priority')->name('priority');
        Route::get('remove-image', 'remove_image')->name('remove-image');
        Route::get('view/{id}', 'view')->name('view');
        Route::get('get-all', 'get_all')->name('get-all');
        #SubCategory
        Route::get('/sub-category', 'sub_index')->name('sub-category');
        Route::get('/sub-category/add', 'sub_add')->name('add-sub-category');
        Route::post('/sub-category/store', 'sub_store')->name('store-sub-category');
        Route::get('/sub-category/edit/{id}', 'sub_edit')->name('edit-sub-category');
    });
    #Attributes Management
    Route::prefix('attribute')->as('attribute.')->controller(AttributeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        // Route::get('/add-new', 'add')->name('add');
        Route::post('/store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
        Route::get('export-attributes', 'export_attributes')->name('export-attributes');
    });
    #Unit Management
    Route::prefix('unit')->as('unit.')->controller(UnitController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
        Route::get('export-attributes', 'export_attributes')->name('export-attributes');
    });
    #Item Management
    Route::prefix('item')->as('item.')->controller(ItemController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/list', 'list')->name('list');
        Route::get('/add-new', 'index')->name('add-new');
        Route::post('/store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::delete('delete/{id}', 'delete')->name('delete');
        Route::post('update/{id}', 'update')->name('update');


        Route::get('remove-image', 'remove_image')->name('remove-image');
        Route::post('/variant-combination', 'variant_combination')->name('variant-combination');
        Route::get('/product-gallery', 'product_gallery')->name('product_gallery');
        Route::get('view/{id}', 'view')->name('view');
        Route::get('status/{id}/{status}', 'status')->name('status');

        //ajax request
        Route::get('/get-categories', 'get_categories')->name('get-categories');
        Route::get('/get-items', 'get_items')->name('getitems');
        Route::get('/variation-generate', 'variation_generator')->name('variation-generate');
        // Route::get('/export', 'export')->name('export');
        Route::get('new/item/list', 'approval_list')->name('approval_list');
    });
    Route::get('store/view/{id}', [VendorController::class, 'view'])->name('store.view');
    Route::get('store/get-stores', [VendorController::class, 'get_stores'])->name('get-stores');
    Route::get('module/{id}', [ModuleController::class, 'show'])->name('show');

    #Wholeseler Management
    Route::prefix('wholesaler')->as('wholesaler.')->controller(VendorController::class)->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('view/{store}/{tab?}/{sub_tab?}', 'view')->name('view');
        Route::get('status/{store}/{status}', 'status')->name('status');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::delete('delete/{store}', 'destroy')->name('delete');
        Route::get('pending-requests', 'pending_requests')->name('pending-requests');
        Route::get('deny-requests', 'deny_requests')->name('deny-requests');
        Route::get('update-application/{id}/{status}', 'update_application')->name('application');
    });

    #Retailer Management
    Route::prefix('retailer')->as('retailer.')->controller(RetailerController::class)->group(function () {
        Route::get('list', 'retailer_list')->name('list');
        Route::get('view/{user_id}', 'view')->name('view');
        // Route::get('view/{store}/{tab?}/{sub_tab?}', 'view')->name('view');
        // Route::get('status/{store}/{status}', 'status')->name('status');
        Route::get('status/{customer}/{status}file-manager', 'status')->name('status');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::delete('delete/{store}', 'destroy')->name('delete');
        Route::get('pending-requests', 'pending_requests')->name('pending-requests');
        Route::get('deny-requests', 'deny_requests')->name('deny-requests');
        Route::get('pending-requests/{id}/{status}', 'update_request')->name('update-request');
        Route::get('export', 'export')->name('export');
        Route::get('search', 'search')->name('search');
        Route::get('order-export', 'customer_order_export')->name('order-export');
    });

    #Employee Management
    Route::prefix('custom-role')->as('custom-role.')->controller(CustomRoleController::class)->group(function () {
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete/{id}', 'distroy')->name('delete');
        Route::post('search', 'search')->name('search');
    });
    Route::prefix('employee')->as('employee.')->controller(EmployeeController::class)->group(function () {
        Route::get('add-new', 'add_new')->name('add-new');
        Route::post('add-new', 'store');
        Route::get('list', 'list')->name('list');
        Route::get('update/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete/{id}', 'distroy')->name('delete');
        Route::post('search', 'search')->name('search');
        Route::get('export', 'export')->name('export');
    });
    // Delivery Man Main Routes
    Route::prefix('delivery-man')->as('delivery-man.')->controller(DeliveryManController::class)->group(function () {
        Route::get('add', 'index')->name('add');
        Route::post('store', 'store')->name('store');
        Route::get('list', 'list')->name('list');
        Route::get('new', 'new_delivery_man')->name('new');
        Route::get('deny', 'deny_delivery_man')->name('deny');
        Route::get('preview/{id}/{tab?}', 'preview')->name('preview');
        Route::get('status/{id}/{status}', 'status')->name('status');
        Route::get('earning/{id}/{status}', 'earning')->name('earning');
        Route::get('update-application/{id}/{status}', 'update_application')->name('application');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
        Route::post('search', 'search')->name('search');
        Route::post('active-search', 'active_search')->name('active-search');

        // Delivery Man Vehicle Routes
        Route::prefix('vehicle')->as('vehicle.')->controller(DmVehicleController::class)->group(function () {
            Route::get('list', 'list')->name('list');
            Route::get('add', 'create')->name('create');
            Route::get('status/{vehicle}/{status}', 'status')->name('status');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store', 'store')->name('store');
            Route::post('update/{vehicle}', 'update')->name('update');
            Route::delete('delete', 'destroy')->name('delete');
            Route::get('view/{vehicle}', 'view')->name('view');
        });
    });
});

Route::controller(OrderController::class)->group(function () {
    Route::get('/admin/order/list/{status}', 'index')->name('admin.order.list');
});
