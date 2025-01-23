<?php

use App\Http\Controllers\Home\ArchiveController;
use App\Http\Controllers\Home\AuthController;
use App\Http\Controllers\Home\BecomeController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\ChargeController;
use App\Http\Controllers\Home\CommentController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\Home\ProfileController;
use App\Http\Controllers\Home\ShopController;
use App\Http\Controllers\Home\SingleController;
use App\Http\Controllers\Home\SitemapController;
use App\Http\Controllers\Home\TicketController;
use App\Http\Controllers\Home\ViewController;
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

Route::get('/', [IndexController::class , 'index']);
Route::post('/search', [IndexController::class , 'search']);
Route::get('/page/{PageSlug}', [IndexController::class , 'page']);
Route::get('/faq', [IndexController::class , 'faq']);
Route::post('/send-sub', [IndexController::class , 'sendSub']);
Route::post('/view', [ViewController::class , 'view']);
Route::get('/sitemap', [SitemapController::class , 'index']);
Route::get('/vendor/{SellerSlug}', [SingleController::class , 'sellerVendor']);

/////// single
Route::get('/product/{ProductSlug}', [SingleController::class , 'product']);
Route::get('/productID/{ProductID}', [SingleController::class , 'product']);
Route::get('/@{SellerSlug}', [SingleController::class , 'seller']);
Route::get('/change/@{SellerSlug}', [SingleController::class , 'sellerChange']);
Route::post('/like', [SingleController::class , 'like']);
Route::post('/send-report', [SingleController::class , 'sendReport']);
Route::post('/send-comment', [CommentController::class , 'sendComment']);
Route::post('/close-chat', [TicketController::class , 'closeChat']);
Route::post('/get-online-ticket', [TicketController::class , 'onlineTicket']);
Route::post('/send-ticket', [TicketController::class , 'sendTicket']);

////////// auth
Route::get('/login', [AuthController::class , 'login'])->name('login');
Route::get('/register', [AuthController::class , 'login'])->name('register');
Route::post('/check-auth', [AuthController::class , 'checkAuth']);
Route::post('/check-code', [AuthController::class , 'checkCode']);
Route::post('/add-user', [AuthController::class , 'addUser']);
Route::post('/enter-auth', [AuthController::class , 'enterAuth']);
Route::post('/change-password', [AuthController::class , 'changePassword']);
Route::post('/check-pass-code', [AuthController::class , 'checkPassCode']);
Route::post('/change-user-password', [AuthController::class , 'changeUserPassword']);
Route::post('/send-login-code', [AuthController::class , 'sendCode']);
Route::post('/check-code-login', [AuthController::class , 'checkCode2']);

////// archive
Route::get('/mother-category/{CategorySlug}', [ArchiveController::class , 'mother']);
Route::get('/category/{CategorySlug}', [ArchiveController::class , 'category']);
Route::get('/change/category/{CategorySlug}', [ArchiveController::class , 'categoryChange']);
Route::get('/brand/{BrandSlug}', [ArchiveController::class , 'brand']);
Route::get('/change/brand/{BrandSlug}', [ArchiveController::class , 'brandChange']);
Route::get('/search', [ArchiveController::class , 'search']);
Route::get('/change/search', [ArchiveController::class , 'searchChange']);
Route::get('/discovery', [ArchiveController::class , 'discovery']);
Route::get('/change/discovery', [ArchiveController::class , 'changeDiscovery']);
Route::get('/vendors', [ArchiveController::class , 'shops']);
Route::post('/change/vendors', [ArchiveController::class , 'changeShops']);

/////// blog
Route::get('/blog', [ArchiveController::class , 'blogs']);
Route::get('/blog/category/{BlogCategory}', [ArchiveController::class , 'blogCategory']);
Route::get('/blog/{BlogSlug}', [SingleController::class , 'blog']);

/////////// cart
Route::post('/get-cart', [CartController::class , 'getCart']);
Route::get('/cart', [CartController::class , 'index']);
Route::get('/cart/next', [CartController::class , 'next']);
Route::get('/checkout', [CartController::class , 'checkout'])->middleware(['web', 'auth']);
Route::post('/change-cart', [CartController::class , 'change']);
Route::post('/move/all', [CartController::class , 'moveAll']);
Route::post('/move-cart', [CartController::class , 'move']);
Route::delete('/delete-cart', [CartController::class , 'delete']);
Route::post('/add-cart', [CartController::class , 'addCart']);
Route::post('/add-address', [CartController::class , 'addAddress']);
Route::post('/check-discount-cart', [CartController::class , 'checkDiscount'])->middleware(['web', 'auth']);

////////// shop
Route::get('/shop', [ShopController::class , 'add_order']);
Route::match(['post','get'],'/order', [ShopController::class , 'order']);
Route::get('/wallet-shop', [ShopController::class , 'shopWallet']);

//////////////// seller
Route::get('/become-seller', [BecomeController::class , 'becomeSeller'])->middleware(['web', 'auth']);
Route::post('/become-seller', [BecomeController::class , 'level1'])->middleware(['web', 'auth']);
Route::post('/send-document', [BecomeController::class , 'sendDocument'])->middleware(['web', 'auth']);

///////////////////////////////////////////////////// user
Route::get('/logout',  [ProfileController::class, 'logout'])->middleware(['web', 'auth']);
Route::put('/change-user-info',  [ProfileController::class, 'ChangeUserInfo'])->middleware(['web', 'auth']);
Route::get('/profile',  [ProfileController::class, 'profile'])->middleware(['web', 'auth']);
Route::get('/profile/pay',  [ProfileController::class, 'pay'])->middleware(['web', 'auth']);
Route::get('/profile/like',  [ProfileController::class, 'like'])->middleware(['web', 'auth']);
Route::get('/profile/comment',  [ProfileController::class, 'comment'])->middleware(['web', 'auth']);
Route::get('/profile/ticket',  [ProfileController::class, 'ticket'])->middleware(['web', 'auth']);
Route::delete('/profile/ticket/{ticket}/delete',  [ProfileController::class, 'removeTicket'])->middleware(['web', 'auth']);
Route::get('/profile/personal-info',  [ProfileController::class, 'personalInfo'])->middleware(['web', 'auth']);
Route::post('/change-all-user-info',  [ProfileController::class, 'ChangeAllUserInfo'])->middleware(['web', 'auth']);
Route::post('/profile/check-code',  [ProfileController::class, 'checkCode'])->middleware(['web', 'auth']);
Route::post('/profile/check-email',  [ProfileController::class, 'checkEmail'])->middleware(['web', 'auth']);
Route::post('/profile/upload-profile',  [ProfileController::class, 'uploadProfile'])->middleware(['web', 'auth']);
Route::get('/show-pay/{PayId}',  [ProfileController::class, 'showPay'])->middleware(['web', 'auth']);
Route::get('/invoice/{PayId}',  [ProfileController::class, 'invoice'])->middleware(['web', 'auth']);

//////////////////// ticket
Route::post('/profile/ticket/get-ticket',  [TicketController::class, 'getChatTicket'])->middleware(['web', 'auth']);
Route::post('/profile/ticket/send-ticket',  [TicketController::class, 'sendTicket'])->middleware(['web', 'auth']);

//////////////////// charge
Route::get('/charge',  [ChargeController::class, 'index'])->middleware(['web', 'auth']);
Route::get('/charge/shop',  [ChargeController::class, 'addCharge'])->middleware(['web', 'auth']);
Route::match(['post','get'],'/charge/order',  [ChargeController::class, 'chargeOrder'])->middleware(['web', 'auth']);

///////////////////////////////////////// chat
Route::group(['prefix' => 'profile/chat'] , function () {
    Route::get('/', [TicketController::class, 'chat'])->middleware(['web', 'auth']);
    Route::post('/get-parent', [TicketController::class, 'getChatParent'])->middleware(['web', 'auth']);
    Route::post('/get-chat', [TicketController::class, 'getChatTicket'])->middleware(['web', 'auth']);
    Route::post('/send-chat', [TicketController::class, 'sendChat'])->middleware(['web', 'auth']);
    Route::post('/delete', [TicketController::class, 'deleteChat'])->middleware(['web', 'auth']);
});
