<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Carrier;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Gallery;
use App\Models\Land;
use App\Models\News;
use App\Models\Page;
use App\Models\Pay;
use App\Models\PayMeta;
use App\Models\Product;
use App\Models\Story;
use App\Models\Tag;
use App\Models\User;
use App\Models\Widget;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/profile';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Route::bind('CategorySlug', function ($value) {
            return Category::where('slug', $value)->where('type',0)->firstOrFail();
        });
        Route::bind('BrandSlug', function ($value) {
            return Brand::where('slug', $value)->firstOrFail();
        });
        Route::bind('SellerSlug', function ($value) {
            return User::where('slug', $value)->where('seller','!=',0)->whereHas('document', function ($qs) {
                $qs->where('status',2);
            })->firstOrFail();
        });
        Route::bind('ProductSlug', function ($value) {
            return Product::where('slug', $value)->where(function ($query) {
                $query->where('status' , 1)
                    ->orWhere('user_id', auth()->user()?auth()->user()->id:0);
            })->firstOrFail();
        });
        Route::bind('BlogSlug', function ($value) {
            return News::where('slug', $value)->where(function ($query) {
                $query->where('status' , 1)
                    ->orWhere('user_id', auth()->user()?auth()->user()->id:0);
            })->firstOrFail();
        });
        Route::bind('ProductID', function ($value) {
            return Product::where('id', $value)->where(function ($query) {
                $query->where('status' , 1)
                    ->orWhere('user_id', auth()->user()?auth()->user()->id:0);
            })->firstOrFail();
        });
        Route::bind('MyProduct', function ($value) {
            return Product::where('id', $value)->where('user_id', auth()->id())->firstOrFail();
        });
        Route::bind('PageSlug', function ($value) {
            return Page::where('slug', $value)->firstOrFail();
        });
        Route::bind('SellerPay', function ($value) {
            return Pay::whereHas('myPayMeta')->where('property', $value)->firstOrFail();
        });
        Route::bind('PayId', function ($value) {
            return Pay::where('user_id',auth()->id())->where('property', $value)->firstOrFail();
        });
        Route::bind('MyCarrier', function ($value) {
            return Carrier::where('user_id',auth()->id())->where('id', $value)->firstOrFail();
        });
        Route::bind('MyStory', function ($value) {
            return Story::where('user_id',auth()->id())->where('id', $value)->firstOrFail();
        });
        Route::bind('MyStory', function ($value) {
            return Story::where('user_id',auth()->id())->where('id', $value)->firstOrFail();
        });
        Route::bind('MyTank', function ($value) {
            return Story::where('user_id',auth()->id())->where('id', $value)->firstOrFail();
        });
        Route::bind('MyGallery', function ($value) {
            return Gallery::where('user_id',auth()->id())->where('id', $value)->firstOrFail();
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::prefix('admin')->middleware('web')
                ->group(base_path('routes/web.php'));
            Route::prefix('seller')->middleware(['web','CheckSeller'])
                ->group(base_path('routes/seller.php'));
            Route::prefix('/')->middleware('web')
                ->group(base_path('routes/home.php'));
        });
    }
}
