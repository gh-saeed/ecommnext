<?php

use App\Http\Controllers\Seller\CarrierController;
use App\Http\Controllers\Seller\CheckoutController;
use App\Http\Controllers\Seller\CostController;
use App\Http\Controllers\Seller\ExcelController;
use App\Http\Controllers\Seller\GalleryController;
use App\Http\Controllers\Seller\InventoryController;
use App\Http\Controllers\Seller\PayController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\StoryController;
use App\Http\Controllers\Seller\TankController;
use App\Http\Controllers\Seller\TicketController;
use App\Http\Controllers\Seller\WidgetController;
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

Route::get('/dashboard', [SellerController::class , 'index']);

////////////////////////////////// gallery
Route::get('/gallery', [GalleryController::class , 'index']);
Route::post('/upload-image', [GalleryController::class , 'upload']);
Route::get('/get-image', [GalleryController::class , 'getImage']);
Route::delete('/gallery/{MyGallery}/delete', [GalleryController::class , 'deleteImage']);

//////////// checkout
Route::get('/checkout', [CheckoutController::class , 'checkout']);
Route::post('/checkout', [CheckoutController::class , 'checkoutStore']);

//////// product
Route::get('/product', [ProductController::class , 'index']);
Route::put('/product/{MyProduct}/edit', [ProductController::class , 'update']);
Route::get('/product/{MyProduct}/edit', [ProductController::class , 'edit']);
Route::get('/product/{MyProduct}/copy', [ProductController::class , 'copy']);
Route::get('/product/digikala', [ProductController::class , 'digikala']);
Route::post('/product/digikala', [ProductController::class , 'digikalaStore']);
Route::get('/product/create', [ProductController::class , 'create']);
Route::post('/product/create', [ProductController::class , 'store']);
Route::get('/product/change', [ProductController::class , 'change']);
Route::post('/product/change', [ProductController::class , 'changeData']);

//// inventory
Route::get('/inventory', [InventoryController::class , 'index']);
Route::get('/empty', [InventoryController::class , 'empty']);

//// pay
Route::group(['prefix' => 'widget'] , function () {
    Route::get('/', [WidgetController::class , 'index']);
    Route::get('/create', [WidgetController::class , 'create']);
    Route::post('/create', [WidgetController::class , 'store']);
    Route::post('/demo', [WidgetController::class , 'demo']);
});

//// pay
Route::group(['prefix' => 'pay'] , function () {
    Route::get('/', [PayController::class , 'index']);
    Route::get('/returned', [PayController::class , 'returned']);
    Route::get('/group',  [PayController::class, 'group']);
    Route::get('/{SellerPay}', [PayController::class , 'edit']);
    Route::put('/{SellerPay}', [PayController::class , 'update']);
    Route::get('/invoice/{SellerPay}',  [PayController::class, 'invoice']);
});

//// carrier
Route::group(['prefix' => 'carrier'] , function () {
    Route::get('/', [CarrierController::class, 'index']);
    Route::post('/', [CarrierController::class, 'store']);
    Route::get('/{MyCarrier}/edit', [CarrierController::class, 'edit']);
    Route::put('/{MyCarrier}/edit', [CarrierController::class, 'update']);
    Route::delete('/{MyCarrier}/delete', [CarrierController::class, 'delete']);
});

//// story
Route::group(['prefix' => 'story'] , function () {
    Route::get('/', [StoryController::class, 'index']);
    Route::get('/create', [StoryController::class, 'create']);
    Route::post('/create', [StoryController::class, 'store']);
    Route::get('/{MyStory}/edit', [StoryController::class, 'edit']);
    Route::put('/{MyStory}/edit', [StoryController::class, 'update']);
    Route::delete('/{MyStory}/delete', [StoryController::class, 'delete']);
});

Route::get('/inquiry', [InventoryController::class , 'inquiry']);
Route::post('/inquiry/change', [InventoryController::class , 'inquiryChange']);

//////// tank
Route::get('/tank', [TankController::class , 'index']);
Route::post('/tank', [TankController::class , 'store']);
Route::delete('/tank/{MyTank}/delete', [TankController::class , 'delete']);
Route::get('/tank/{MyTank}/edit', [TankController::class , 'edit']);
Route::post('/tank/{MyTank}/edit', [TankController::class , 'update']);
Route::post('/add-tank', [TankController::class , 'addTank']);
Route::post('/tank/add-detail', [TankController::class , 'addDetail']);

///////////////////////////////////////// ticket
Route::get('/ticket',  [TicketController::class, 'index']);
Route::post('/ticket/get-ticket',  [TicketController::class, 'getTicketParent']);
Route::post('/ticket/send-ticket',  [TicketController::class, 'sendTicket']);

///////////////////////////////////////// chat
Route::get('/chat',  [TicketController::class, 'chat']);
Route::post('/chat/get-parent',  [TicketController::class, 'getChatParent']);
Route::post('/chat/get-chat',  [TicketController::class, 'getChatTicket']);
Route::post('/chat/send-chat',  [TicketController::class, 'sendChat']);
Route::post('/chat/delete',  [TicketController::class, 'deleteChat']);

Route::get('/cost-benefit', [CostController::class , 'all']);
Route::get('/statistics/product', [CostController::class , 'product']);

///////////////////////////////////////// excel
Route::get('/excel',  [ExcelController::class, 'index']);
Route::get('/import',  [ExcelController::class, 'import']);
Route::post('/import-product',  [ExcelController::class, 'import_product']);
Route::get('/get-excel/{data}',  [ExcelController::class, 'getExcel']);
