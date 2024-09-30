<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POSController;
use App\Http\Controllers\AvatarController;
use App\Http\Livewire\InventoryAdjustment;


// Public routes
Route::get('/', [POSController::class, 'index'])->name('home'); // Home route
Route::get('/login', [POSController::class, 'index'])->name('login'); // Login view route
Route::post('/login', [POSController::class, 'login']); // Login POST route
Route::post('/logout', [POSController::class, 'logout'])->name('logout'); // Logout route


// Protected routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [POSController::class, 'dashboard'])->name('dashboard');

    Route::get('/cashierdashobard', [POSController::class, 'cashierDashboard'])->name('cashierdashboard');
    Route::get('/salereturn', [POSController::class, 'salereturn'])->name('salereturn');
    Route::get('/saletransaction', [POSController::class, 'saletransaction'])->name('saletransaction');

    // User management

    Route::get('/user', [POSController::class, 'user'])->name('user');
    Route::get('/user_account', [POSController::class, 'userInformation'])->name('user_account');
    Route::post('/upload-avatar', [AvatarController::class, 'upload'])->name('upload.avatar');


    // Supplier information
    Route::get('/supplier', [POSController::class, 'supplier'])->name('supplier');
    Route::get('/order', [POSController::class, 'orderSupplies'])->name('order_supplies');
    Route::get('/delivery', [POSController::class, 'delivery'])->name('delivery');

    // Item management
    Route::get('/item_management', [POSController::class, 'itemManagement'])->name('item_management');


    // Inventory management
    Route::get('/inventory_management', [POSController::class, 'inventoryManagement'])->name('inventory_management');
    Route::get('/inventory_adjustment', [POSController::class, 'inventoryAdjustment'])->name('inventory_adjustment');

    // Activity log
    Route::get('/activity_log', [POSController::class, 'activityLog'])->name('activity_log');

    // Reports
    Route::get('/inventory_report', [POSController::class, 'inventoryReport'])->name('inventory_report');
    Route::get('/reorder_list_report', [POSController::class, 'reorderListReport'])->name('reorder_list_report');
    Route::get('/fast_moving_item_report', [POSController::class, 'fastMovingItemReport'])->name('fast_moving_item_report');
    Route::get('/slow_moving_item_report', [POSController::class, 'slowMovingItemReport'])->name('slow_moving_item_report');
    Route::get('/sales_report', [POSController::class, 'salesReport'])->name('sales_report');
    Route::get('/stock_movement_report', [POSController::class, 'stockMovementReport'])->name('stock_movement_report');
    Route::get('/expiration_report', [POSController::class, 'expirationReport'])->name('expiration_report');
    Route::get('/sales_return_report', [POSController::class, 'salesReturnReport'])->name('sales_return_report');
    Route::get('/transaction_history_report', [POSController::class, 'transactionHistoryReport'])->name('transaction_history_report');
});
