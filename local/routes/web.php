<?php

use App\Http\Controllers\Admin\AskController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CarrierController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChangeController;
use App\Http\Controllers\Admin\CheckoutController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ExcelController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GuaranteeController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\PayController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TankController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\WidgetController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\RedirectController;
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


Route::get('/', [PanelController::class , 'index'])->middleware(['permission:داشبورد']);
Route::get('/show-update', [PanelController::class , 'update'])->middleware(['permission:داشبورد']);
Route::get('/online', [PanelController::class , 'online'])->middleware(['permission:داشبورد']);
Route::post('/check-user', [PanelController::class , 'checkUser'])->middleware(['permission:داشبورد']);

////////////////////////////////// gallery
Route::get('/gallery', [GalleryController::class , 'index'])->middleware(['permission:گالری']);
Route::post('/upload-image', [GalleryController::class , 'upload'])->middleware(['permission:گالری']);
Route::get('/get-image', [GalleryController::class , 'getImage'])->middleware(['permission:گالری']);
Route::delete('/gallery/{gallery}/delete', [GalleryController::class , 'deleteImage'])->middleware(['permission:گالری']);

//////// product
Route::get('/product', [PostController::class , 'index'])->middleware(['permission:همه محصولات']);
Route::post('/product/get-data', [PostController::class , 'getData'])->middleware(['permission:همه محصولات']);
Route::get('/product/change', [PostController::class , 'change'])->middleware(['permission:همه محصولات']);
Route::post('/product/change', [PostController::class , 'changeData'])->middleware(['permission:همه محصولات']);
Route::post('/product/delete', [PostController::class , 'deleteGroup'])->middleware(['permission:همه محصولات']);
Route::delete('/product/{product}/delete', [PostController::class , 'delete'])->middleware(['permission:همه محصولات']);
Route::put('/product/{product}/edit', [PostController::class , 'update'])->middleware(['permission:همه محصولات']);
Route::get('/product/{product}/edit', [PostController::class , 'edit'])->middleware(['permission:همه محصولات']);
Route::get('/product/{product}/show', [PostController::class , 'show'])->middleware(['permission:همه محصولات']);
Route::get('/product/{product}/copy', [PostController::class , 'copy'])->middleware(['permission:همه محصولات']);
Route::get('/product/create', [PostController::class , 'create'])->middleware(['permission:افزودن محصول']);
Route::post('/product/create', [PostController::class , 'store'])->middleware(['permission:افزودن محصول']);
Route::get('/product/group/create', [PostController::class , 'groupAdd'])->middleware(['permission:افزودن محصول']);
Route::post('/product/group/create', [PostController::class , 'groupAddStore'])->middleware(['permission:افزودن محصول']);


Route::group(['prefix' => 'digikala'] , function (){
    Route::get('/', [PostController::class,'digikala'])->middleware(['permission:افزودن محصول']);
    Route::post('/', [PostController::class,'storeDigikala'])->middleware(['permission:افزودن محصول']);
    Route::get('/{auto}/edit', [PostController::class,'getDigikala'])->middleware(['permission:افزودن محصول']);
    Route::get('/{auto}/reset', [PostController::class,'reset'])->middleware(['permission:افزودن محصول']);
    Route::put('/{auto}/edit', [PostController::class,'updateDigikala'])->middleware(['permission:افزودن محصول']);
    Route::delete('/{auto}/delete', [PostController::class,'destroy'])->middleware(['permission:افزودن محصول']);
});
//// cost
Route::get('/cost-benefit', [CostController::class , 'statistics'])->middleware(['permission:همه سفارشات']);

//////// tank
Route::get('/tank', [TankController::class , 'index'])->middleware(['permission:وضعیت موجودی']);
Route::post('/tank', [TankController::class , 'store'])->middleware(['permission:وضعیت موجودی']);
Route::delete('/tank/{tank}/delete', [TankController::class , 'delete'])->middleware(['permission:وضعیت موجودی']);
Route::get('/tank/{tank}/edit', [TankController::class , 'edit'])->middleware(['permission:وضعیت موجودی']);
Route::post('/tank/{tank}/edit', [TankController::class , 'update'])->middleware(['permission:وضعیت موجودی']);
Route::post('/add-tank', [TankController::class , 'addTank'])->middleware(['permission:وضعیت موجودی']);
Route::post('/tank/add-detail', [TankController::class , 'addDetail'])->middleware(['permission:وضعیت موجودی']);

//////// blog
Route::get('/blog', [NewsController::class , 'index'])->middleware(['permission:همه بلاگ ها']);
Route::delete('/blog/{news}/delete', [NewsController::class , 'delete'])->middleware(['permission:همه بلاگ ها']);
Route::put('/blog/{news}/edit', [NewsController::class , 'update'])->middleware(['permission:همه بلاگ ها']);
Route::get('/blog/{news}/edit', [NewsController::class , 'edit'])->middleware(['permission:همه بلاگ ها']);
Route::get('/blog/{news}/show', [NewsController::class , 'show'])->middleware(['permission:همه بلاگ ها']);
Route::get('/blog/create', [NewsController::class , 'create'])->middleware(['permission:افزودن بلاگ']);
Route::post('/blog/create', [NewsController::class , 'store'])->middleware(['permission:افزودن بلاگ']);

//////// page
Route::get('/page', [PageController::class , 'index'])->middleware(['permission:برگه ها']);
Route::delete('/page/{page}/delete', [PageController::class , 'delete'])->middleware(['permission:برگه ها']);
Route::put('/page/{page}/edit', [PageController::class , 'update'])->middleware(['permission:برگه ها']);
Route::get('/page/{page}/edit', [PageController::class , 'edit'])->middleware(['permission:برگه ها']);
Route::get('/page/create', [PageController::class , 'create'])->middleware(['permission:برگه ها']);
Route::post('/page/create', [PageController::class , 'store'])->middleware(['permission:برگه ها']);

//////// ask
Route::get('/ask', [AskController::class , 'index'])->middleware(['permission:برگه ها']);
Route::delete('/ask/{ask}/delete', [AskController::class , 'delete'])->middleware(['permission:برگه ها']);
Route::put('/ask/{ask}/edit', [AskController::class , 'update'])->middleware(['permission:برگه ها']);
Route::get('/ask/{ask}/edit', [AskController::class , 'edit'])->middleware(['permission:برگه ها']);
Route::get('/ask/create', [AskController::class , 'create'])->middleware(['permission:برگه ها']);
Route::post('/ask/create', [AskController::class , 'store'])->middleware(['permission:برگه ها']);

//// redirect
Route::get('/redirect', [RedirectController::class , 'index'])->middleware(['permission:تاکسونامی']);
Route::post('/redirect', [RedirectController::class , 'store'])->middleware(['permission:تاکسونامی']);
Route::get('/redirect/{redirect}/edit', [RedirectController::class , 'edit'])->middleware(['permission:تاکسونامی']);
Route::put('/redirect/{redirect}/edit', [RedirectController::class , 'update'])->middleware(['permission:تاکسونامی']);
Route::delete('/redirect/{redirect}/delete', [RedirectController::class , 'delete'])->middleware(['permission:تاکسونامی']);

//// brand
Route::get('/brand', [BrandController::class , 'index'])->middleware(['permission:تاکسونامی']);
Route::post('/brand', [BrandController::class , 'store'])->middleware(['permission:تاکسونامی']);
Route::get('/brand/{brand}/edit', [BrandController::class , 'edit'])->middleware(['permission:تاکسونامی']);
Route::put('/brand/{brand}/edit', [BrandController::class , 'update'])->middleware(['permission:تاکسونامی']);
Route::delete('/brand/{brand}/delete', [BrandController::class , 'delete'])->middleware(['permission:تاکسونامی']);
Route::get('/brand/{brand}/show', [BrandController::class , 'show'])->middleware(['permission:تاکسونامی']);

//// category
Route::get('/category', [CategoryController::class , 'index'])->middleware(['permission:تاکسونامی']);
Route::post('/category', [CategoryController::class , 'store'])->middleware(['permission:تاکسونامی']);
Route::get('/category/{category}/edit', [CategoryController::class , 'edit'])->middleware(['permission:تاکسونامی']);
Route::put('/category/{category}/edit', [CategoryController::class , 'update'])->middleware(['permission:تاکسونامی']);
Route::delete('/category/{category}/delete', [CategoryController::class , 'delete'])->middleware(['permission:تاکسونامی']);
Route::get('/category/{category}/show', [CategoryController::class , 'show'])->middleware(['permission:تاکسونامی']);

/////////////////////////////////////// comment
Route::get('/comment',  [CommentController::class, 'index'])->middleware(['permission:دیدگاه']);
Route::get('/comment/{comment}/edit',  [CommentController::class, 'edit'])->middleware(['permission:دیدگاه']);
Route::post('/comment/{comment}/edit',  [CommentController::class, 'update'])->middleware(['permission:دیدگاه']);
Route::delete('/comment/{comment}/delete',  [CommentController::class, 'delete'])->middleware(['permission:دیدگاه']);

/////////////////////////////////////// report
Route::get('/report',  [ReportController::class, 'index'])->middleware(['permission:گزارش']);
Route::get('/report/{report}/edit',  [ReportController::class, 'edit'])->middleware(['permission:گزارش']);
Route::post('/report/{report}/edit',  [ReportController::class, 'update'])->middleware(['permission:گزارش']);
Route::delete('/report/{report}/delete',  [ReportController::class, 'delete'])->middleware(['permission:گزارش']);

//// tag
Route::get('/tag', [TagController::class , 'index'])->middleware(['permission:تاکسونامی']);
Route::post('/tag', [TagController::class , 'store'])->middleware(['permission:تاکسونامی']);
Route::get('/tag/{tag}/edit', [TagController::class , 'edit'])->middleware(['permission:تاکسونامی']);
Route::put('/tag/{tag}/edit', [TagController::class , 'update'])->middleware(['permission:تاکسونامی']);
Route::delete('/tag/{tag}/delete', [TagController::class , 'delete'])->middleware(['permission:تاکسونامی']);
Route::get('/tag/{tag}/show', [TagController::class , 'show'])->middleware(['permission:تاکسونامی']);

//// guarantee
Route::get('/guarantee', [GuaranteeController::class , 'index'])->middleware(['permission:تاکسونامی']);
Route::post('/guarantee', [GuaranteeController::class , 'store'])->middleware(['permission:تاکسونامی']);
Route::get('/guarantee/{guarantee}/edit', [GuaranteeController::class , 'edit'])->middleware(['permission:تاکسونامی']);
Route::put('/guarantee/{guarantee}/edit', [GuaranteeController::class , 'update'])->middleware(['permission:تاکسونامی']);
Route::delete('/guarantee/{guarantee}/delete', [GuaranteeController::class , 'delete'])->middleware(['permission:تاکسونامی']);
Route::get('/guarantee/{guarantee}/show', [GuaranteeController::class , 'show'])->middleware(['permission:تاکسونامی']);

//// inventory
Route::get('/inventory', [InventoryController::class , 'index'])->middleware(['permission:وضعیت موجودی']);
Route::get('/empty', [InventoryController::class , 'empty'])->middleware(['permission:وضعیت موجودی']);
Route::get('/inquiry', [InventoryController::class , 'inquiry'])->middleware(['permission:وضعیت موجودی']);
Route::post('/inquiry/change', [InventoryController::class , 'inquiryChange'])->middleware(['permission:وضعیت موجودی']);

//// role
Route::get('/role', [RoleController::class , 'index'])->middleware(['permission:تاکسونامی']);
Route::post('/role', [RoleController::class , 'store'])->middleware(['permission:تاکسونامی']);
Route::get('/role/{role}/edit', [RoleController::class , 'edit'])->middleware(['permission:تاکسونامی']);
Route::put('/role/{role}/edit', [RoleController::class , 'update'])->middleware(['permission:تاکسونامی']);
Route::delete('/role/{role}/delete', [RoleController::class , 'delete'])->middleware(['permission:تاکسونامی']);
Route::get('/role/{role}/show', [RoleController::class , 'show'])->middleware(['permission:تاکسونامی']);

//// carrier
Route::get('/carrier', [CarrierController::class , 'index'])->middleware(['permission:تاکسونامی']);
Route::post('/carrier', [CarrierController::class , 'store'])->middleware(['permission:تاکسونامی']);
Route::get('/carrier/{carrier}/edit', [CarrierController::class , 'edit'])->middleware(['permission:تاکسونامی']);
Route::put('/carrier/{carrier}/edit', [CarrierController::class , 'update'])->middleware(['permission:تاکسونامی']);
Route::delete('/carrier/{carrier}/delete', [CarrierController::class , 'delete'])->middleware(['permission:تاکسونامی']);

//// link
Route::get('/link', [LinkController::class , 'index'])->middleware(['permission:لینک هدر']);
Route::post('/link', [LinkController::class , 'store'])->middleware(['permission:لینک هدر']);
Route::post('/link/change', [LinkController::class , 'changeLink'])->middleware(['permission:لینک هدر']);
Route::get('/link/{link}/edit', [LinkController::class , 'edit'])->middleware(['permission:لینک هدر']);
Route::put('/link/{link}/edit', [LinkController::class , 'update'])->middleware(['permission:لینک هدر']);
Route::delete('/link/{link}/delete', [LinkController::class , 'delete'])->middleware(['permission:لینک هدر']);

//// pay
Route::get('/pay', [PayController::class , 'index'])->middleware(['permission:همه سفارشات']);
Route::get('/pay/create', [PayController::class , 'create'])->middleware(['permission:همه سفارشات']);
Route::post('/pay/create', [PayController::class , 'createP'])->middleware(['permission:همه سفارشات']);
Route::get('/pay/returned', [PayController::class , 'returned'])->middleware(['permission:همه سفارشات']);
Route::get('/pay/{pay}', [PayController::class , 'edit'])->middleware(['permission:ویرایش سفارش']);
Route::put('/pay/{pay}', [PayController::class , 'update'])->middleware(['permission:ویرایش سفارش']);
Route::post('/add-pay/{pay}', [PayController::class , 'addPay'])->middleware(['permission:ویرایش سفارش']);
Route::put('/delete-pay/{pay_meta}', [PayController::class , 'deleteMeta'])->middleware(['permission:ویرایش سفارش']);
Route::get('/pay/invoice/{pay}', [PayController::class , 'invoice'])->middleware(['permission:همه سفارشات']);
Route::delete('/pay/{pay}/delete', [PayController::class , 'delete'])->middleware(['permission:همه سفارشات']);
Route::get('/pay/print/{pay}', [PayController::class , 'print'])->middleware(['permission:همه سفارشات']);
Route::get('/invoice/group', [PayController::class , 'group'])->middleware(['permission:همه سفارشات']);

///////////////// chart
Route::get('/chart', [PayController::class , 'chart'])->middleware(['permission:آمارگیری']);
Route::get('/statistics/product', [PayController::class , 'statisticsProduct'])->middleware(['permission:آمارگیری']);

///////////////// document
Route::get('/document', [App\Http\Controllers\Admin\SellerController::class , 'document'])->middleware(['permission:بررسی فروشنده']);
Route::get('/document/{document}/edit', [App\Http\Controllers\Admin\SellerController::class , 'edit'])->middleware(['permission:بررسی فروشنده']);
Route::post('/document/{document}/edit', [App\Http\Controllers\Admin\SellerController::class , 'update'])->middleware(['permission:بررسی فروشنده']);
Route::delete('/document/{document}/delete', [App\Http\Controllers\Admin\SellerController::class , 'deleteDoc'])->middleware(['permission:بررسی فروشنده']);

///////////////// seller
Route::get('/sellers', [App\Http\Controllers\Admin\SellerController::class , 'index'])->middleware(['permission:بررسی فروشنده']);
Route::delete('/sellers/{user}/delete', [App\Http\Controllers\Admin\SellerController::class , 'delete'])->middleware(['permission:بررسی فروشنده']);

//// user
Route::get('/user', [\App\Http\Controllers\Admin\UserController::class , 'index'])->middleware(['permission:همه سفارشات']);
Route::get('/user/create', [\App\Http\Controllers\Admin\UserController::class , 'create'])->middleware(['permission:ویرایش سفارش']);
Route::post('/user/create', [\App\Http\Controllers\Admin\UserController::class , 'store'])->middleware(['permission:ویرایش سفارش']);
Route::get('/user/{user}/edit', [\App\Http\Controllers\Admin\UserController::class , 'edit'])->middleware(['permission:ویرایش سفارش']);
Route::put('/user/{user}/edit', [\App\Http\Controllers\Admin\UserController::class , 'update'])->middleware(['permission:ویرایش سفارش']);
Route::get('/user/{user}/show', [\App\Http\Controllers\Admin\UserController::class , 'show'])->middleware(['permission:ویرایش سفارش']);
Route::delete('/user/{user}/delete', [\App\Http\Controllers\Admin\UserController::class , 'delete'])->middleware(['permission:همه سفارشات']);

//// discount
Route::get('/discount', [DiscountController::class , 'index'])->middleware(['permission:کد تخفیف']);
Route::post('/discount', [DiscountController::class , 'store'])->middleware(['permission:کد تخفیف']);
Route::get('/discount/{discount}/edit', [DiscountController::class , 'edit'])->middleware(['permission:کد تخفیف']);
Route::put('/discount/{discount}/edit', [DiscountController::class , 'update'])->middleware(['permission:کد تخفیف']);
Route::delete('/discount/{discount}/delete', [DiscountController::class , 'delete'])->middleware(['permission:کد تخفیف']);

//// widget
Route::get('/widget', [WidgetController::class , 'index'])->middleware(['permission:ویجت']);
Route::get('/widget/mobile', [WidgetController::class , 'mobileIndex'])->middleware(['permission:ویجت']);
Route::post('/widget', [WidgetController::class , 'change'])->middleware(['permission:ویجت']);
Route::get('/widget/create', [WidgetController::class , 'create'])->middleware(['permission:ویجت']);
Route::post('/widget/create', [WidgetController::class , 'store'])->middleware(['permission:ویجت']);
Route::get('/widget/{widget}/edit', [WidgetController::class , 'edit'])->middleware(['permission:ویجت']);
Route::put('/widget/{widget}/edit', [WidgetController::class , 'update'])->middleware(['permission:ویجت']);
Route::delete('/widget/{widget}/delete', [WidgetController::class , 'delete'])->middleware(['permission:ویجت']);

//// setting
Route::get('/setting/category', [SettingController::class , 'categoryIndex'])->middleware(['permission:تنظیمات دسته بندی']);
Route::post('/setting/category', [SettingController::class , 'categoryUpdate'])->middleware(['permission:تنظیمات دسته بندی']);
Route::get('/setting/manage', [SettingController::class , 'manageIndex'])->middleware(['permission:تنظیمات سایت']);
Route::post('/setting/manage', [SettingController::class , 'manageUpdate'])->middleware(['permission:تنظیمات سایت']);
Route::get('/setting/seo', [SettingController::class , 'seoIndex'])->middleware(['permission:تنظیمات سئو']);
Route::post('/setting/seo', [SettingController::class , 'seoUpdate'])->middleware(['permission:تنظیمات سئو']);
Route::get('/setting/payment', [SettingController::class , 'paymentIndex'])->middleware(['permission:تنظیمات پرداخت']);
Route::post('/setting/payment', [SettingController::class , 'paymentUpdate'])->middleware(['permission:تنظیمات پرداخت']);
Route::post('/setting/ads-header', [SettingController::class , 'adsHeader'])->middleware(['permission:تنظیمات سایت']);
Route::post('/setting/pop-up', [SettingController::class , 'popUp'])->middleware(['permission:تنظیمات سایت']);
Route::get('/setting/message', [SettingController::class , 'messageIndex'])->middleware(['permission:تنظیمات پیامک']);
Route::post('/setting/message', [SettingController::class , 'messageUpdate'])->middleware(['permission:تنظیمات پیامک']);
Route::get('/setting/float', [SettingController::class , 'floatIndex'])->middleware(['permission:تنظیمات شناور']);
Route::post('/setting/float', [SettingController::class , 'floatUpdate'])->middleware(['permission:تنظیمات شناور']);
Route::get('/setting/script', [SettingController::class , 'scriptIndex'])->middleware(['permission:تنظیمات سایت']);
Route::post('/setting/script', [SettingController::class , 'scriptUpdate'])->middleware(['permission:تنظیمات سایت']);
Route::get('/setting/file', [SettingController::class , 'fileIndex'])->middleware(['permission:تنظیمات سایت']);
Route::post('/setting/file', [SettingController::class , 'fileUpdate'])->middleware(['permission:تنظیمات سایت']);
Route::get('/setting/theme', [SettingController::class , 'themeIndex'])->middleware(['permission:تنظیمات سایت']);
Route::post('/setting/theme', [SettingController::class , 'themeUpdate'])->middleware(['permission:تنظیمات سایت']);
Route::get('/setting/cache', [SettingController::class , 'cacheIndex'])->middleware(['permission:تنظیمات سایت']);
Route::post('/setting/cache', [SettingController::class , 'cacheUpdate'])->middleware(['permission:تنظیمات سایت']);
Route::post('/setting/change-cache', [SettingController::class , 'changeCache'])->middleware(['permission:تنظیمات سایت']);
Route::get('/setting/gallery', [SettingController::class , 'galleryIndex'])->middleware(['permission:تنظیمات سایت']);
Route::post('/setting/gallery', [SettingController::class , 'galleryCache'])->middleware(['permission:تنظیمات سایت']);
Route::post('/setting/redirect', [SettingController::class , 'redirect'])->middleware(['permission:تنظیمات سایت']);

///////////////////////////////////////// excel
Route::get('/excel',  [ExcelController::class, 'index'])->middleware(['permission:خروجی اکسل']);
Route::get('/import',  [ExcelController::class, 'import'])->middleware(['permission:خروجی اکسل']);
Route::post('/import-user',  [ExcelController::class, 'import_user'])->middleware(['permission:خروجی اکسل']);
Route::post('/import-blog',  [ExcelController::class, 'import_blog'])->middleware(['permission:خروجی اکسل']);
Route::post('/import-product',  [ExcelController::class, 'import_product'])->middleware(['permission:خروجی اکسل']);
Route::get('/get-excel/{data}',  [ExcelController::class, 'getExcel'])->middleware(['permission:خروجی اکسل']);

///////////////////////////////////////// wallet
Route::get('/wallet',  [WalletController::class, 'index'])->middleware(['permission:کیف پول']);
Route::post('/wallet',  [WalletController::class, 'store'])->middleware(['permission:کیف پول']);
Route::get('/wallet/{wallet}/edit',  [WalletController::class, 'edit'])->middleware(['permission:کیف پول']);
Route::put('/wallet/{wallet}/edit',  [WalletController::class, 'update'])->middleware(['permission:کیف پول']);
Route::delete('/wallet/{wallet}/delete',  [WalletController::class, 'delete'])->middleware(['permission:کیف پول']);

///////////////////////////////////////// change price
Route::get('/change-price/excel',  [ChangeController::class, 'excel'])->middleware(['permission:تغییر قیمت']);
Route::get('/change-price/increase',  [ChangeController::class, 'increase'])->middleware(['permission:تغییر قیمت']);
Route::post('/change-price/increase',  [ChangeController::class, 'increasePrice'])->middleware(['permission:تغییر قیمت']);
Route::get('/change-price/decrease',  [ChangeController::class, 'decrease'])->middleware(['permission:تغییر قیمت']);
Route::post('/change-price/decrease',  [ChangeController::class, 'decreasePrice'])->middleware(['permission:تغییر قیمت']);
Route::post('/change-price/excel',  [ChangeController::class, 'changePriceExcel'])->middleware(['permission:تغییر قیمت']);

///////////////////////////////////////// ticket
Route::get('/ticket',  [\App\Http\Controllers\Admin\TicketController::class, 'index'])->middleware(['permission:درخواست ها']);
Route::post('/ticket/get-parent',  [\App\Http\Controllers\Admin\TicketController::class, 'getTicketParent'])->middleware(['permission:درخواست ها']);
Route::post('/ticket/send-ticket',  [\App\Http\Controllers\Admin\TicketController::class, 'sendTicket'])->middleware(['permission:درخواست ها']);

///////////////////////////////////////// chat
Route::get('/chat',  [\App\Http\Controllers\Admin\TicketController::class, 'chat'])->middleware(['permission:درخواست ها']);
Route::post('/chat/get-parent',  [\App\Http\Controllers\Admin\TicketController::class, 'getChatParent'])->middleware(['permission:درخواست ها']);
Route::post('/chat/get-chat',  [\App\Http\Controllers\Admin\TicketController::class, 'getChatTicket'])->middleware(['permission:درخواست ها']);
Route::post('/chat/send-chat',  [\App\Http\Controllers\Admin\TicketController::class, 'sendChat'])->middleware(['permission:درخواست ها']);
Route::post('/chat/delete',  [\App\Http\Controllers\Admin\TicketController::class, 'deleteChat'])->middleware(['permission:درخواست ها']);

///// event
Route::group(['prefix' => 'event'] , function () {
    Route::get('/', [EventController::class, 'parent'])->middleware(['permission:فعالیت ها']);
    Route::post('/', [EventController::class, 'store'])->middleware(['permission:فعالیت ها']);
    Route::get('/{event}/edit', [EventController::class, 'edit'])->middleware(['permission:فعالیت ها']);
    Route::put('/{event}/edit', [EventController::class, 'update'])->middleware(['permission:فعالیت ها']);
    Route::delete('/{event}/delete', [EventController::class, 'delete'])->middleware(['permission:فعالیت ها']);
});

///// notification
Route::group(['prefix' => 'notification'] , function () {
    Route::get('/sms', [EventController::class, 'sms'])->middleware(['permission:فعالیت ها']);
    Route::post('/sms', [EventController::class, 'smsStore'])->middleware(['permission:فعالیت ها']);
    Route::get('/email', [EventController::class, 'email'])->middleware(['permission:فعالیت ها']);
    Route::post('/email', [EventController::class, 'emailStore'])->middleware(['permission:فعالیت ها']);
});

///// subscribe
Route::group(['prefix' => 'subscribe'] , function () {
    Route::get('/', [EventController::class, 'subscribe'])->middleware(['permission:فعالیت ها']);
    Route::post('/', [EventController::class, 'subscribeStore'])->middleware(['permission:فعالیت ها']);
    Route::delete('/{subscribe}/delete', [EventController::class, 'subscribeDelete'])->middleware(['permission:فعالیت ها']);
});

///////////////////////////////////////// counseling
Route::get('/counseling',  [\App\Http\Controllers\Admin\TicketController::class, 'counselingIndex'])->middleware(['permission:درخواست ها']);
Route::delete('/counseling/{counseling}/delete',  [\App\Http\Controllers\Admin\TicketController::class, 'counselingRemove'])->middleware(['permission:درخواست ها']);
Route::post('/counseling/{counseling}/edit',  [\App\Http\Controllers\Admin\TicketController::class, 'counselingEdit'])->middleware(['permission:درخواست ها']);

//// story
Route::group(['prefix' => 'story'] , function () {
    Route::get('/', [StoryController::class, 'index'])->middleware(['permission:فعالیت ها']);
    Route::get('/create', [StoryController::class, 'create'])->middleware(['permission:فعالیت ها']);
    Route::post('/create', [StoryController::class, 'store'])->middleware(['permission:فعالیت ها']);
    Route::get('/{story}/edit', [StoryController::class, 'edit'])->middleware(['permission:فعالیت ها']);
    Route::put('/{story}/edit', [StoryController::class, 'update'])->middleware(['permission:فعالیت ها']);
    Route::delete('/{story}/delete', [StoryController::class, 'delete'])->middleware(['permission:فعالیت ها']);
});

Route::group(['prefix' => 'checkout'] , function (){
    Route::get('/',  [CheckoutController::class, 'index'])->middleware(['permission:تسویه حساب']);
    Route::post('/',  [CheckoutController::class, 'store'])->middleware(['permission:تسویه حساب']);
    Route::get('/{checkout}/edit',  [CheckoutController::class, 'edit'])->middleware(['permission:تسویه حساب']);
    Route::put('/{checkout}/edit',  [CheckoutController::class, 'update'])->middleware(['permission:تسویه حساب']);
    Route::delete('/{checkout}/delete',  [CheckoutController::class, 'delete'])->middleware(['permission:تسویه حساب']);
});
