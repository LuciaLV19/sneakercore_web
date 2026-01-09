<?php

use App\Http\Controllers\Shop\ProfileController as ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Shop\ProductController as ProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Shop\CartController as CartController;
use App\Http\Controllers\Shop\OrderController as OrderController; 
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\DiscountController as AdminDiscountController;
use App\Http\Controllers\Shop\WishlistController as WishlistController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/new-arrivals', [ProductController::class, 'newArrivals'])->name('new-arrivals');
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ProductController::class, 'show'])->name('shop.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('discounts', AdminDiscountController::class);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('shipping', [AdminSettingsController::class, 'index'])->name('shipping.index');
    Route::put('shipping', [AdminSettingsController::class, 'update'])->name('shipping.update');
});
Route::middleware('auth')->post('checkout', [OrderController::class,'store'])->name('checkout.store');
Route::middleware('auth')->get('orders', [OrderController::class,'index'])->name('orders.index');

Route::get('cart', [CartController::class,'index'])->name('cart.index');
Route::post('cart/add/{product}', [CartController::class,'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

Route::patch('/profile/address', [ProfileController::class, 'updateAddress'])->name('profile.address.update');
Route::patch('/profile/set-default-address/{address}', [ProfileController::class, 'setDefaultAddress'])->name('profile.address.default');

Route::post('/product/{product}/simulated-alert', function (App\Models\Product $product) {
    if (!Auth::check()) {
        return redirect()->route('login')->with('info', 'You must log in to enable notifications.');
    }

    $email = Auth::user()->email;
    return back()->with('success', __("Alert activated! We will send an email to :email when we restock.", [
    'email' => $email,
    'product' => $product->name
    ]));
})->name('products.simulated-alert');

Route::get('/locale/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'es'])) {
        session(['locale' => $lang]);
    }
    return redirect()->back();
})->name('locale.switch');


require __DIR__.'/auth.php';
