<?php

use Illuminate\Support\Facades\Route;
//==================Admin=============
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\OderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdminProfileController;



//=========Frontend===============
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;

// Admin routes
Route::group(['prefix'=>'admin'],function(){

	Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');

	// Order Routes
	Route::get('load_order',[OderController::class,'datatable'])->name('admin.load_order');
	Route::get('order_list',[OderController::class,'index'])->name('admin.order_list');
	Route::get('order_detail/{id}',[OderController::class,'order_detail'])->name('admin.order_detail');
	Route::get('order_invoice/{id}',[OderController::class,'invoice'])->name('admin.order_invoice');
	Route::post('status_change',[OderController::class,'status_change'])->name('admin.order_status_change');

	// Profile Routes
	Route::get('password_form',[AdminProfileController::class,'password_form'])->name('admin.password_form');
	Route::post('change_password',[AdminProfileController::class,'change_password'])->name('admin.change_password');
	Route::get('profile_form',[AdminProfileController::class,'profile_form'])->name('admin.profile_form');
	Route::post('change_profile',[AdminProfileController::class,'change_profile'])->name('admin.change_profile');

	//===Report route===
	Route::get('generate_report',[ReportController::class,'custom_report'])->name('admin.custom_report');
	Route::post('generate_report',[ReportController::class,'generate_report'])->name('admin.generate_report');
	Route::get('daily_report',[ReportController::class,'daily_report'])->name('admin.daily_report');
	Route::get('weekly_report',[ReportController::class,'weekly_report'])->name('admin.weekly_report');
	Route::get('monthly_report',[ReportController::class,'monthly_report'])->name('admin.monthly_report');


	// Category Routes
	Route::get('load_category',[CategoryController::class,'datatable'])->name('admin.load_category');
	Route::get('category_list',[CategoryController::class,'index'])->name('admin.category_list');
	Route::get('category_create',[CategoryController::class,'create'])->name('admin.category_create');
	Route::post('category_store',[CategoryController::class,'store'])->name('admin.category_store');
	Route::get('category_edit/{id}',[CategoryController::class,'edit'])->name('admin.category_edit');
	Route::post('category_update',[CategoryController::class,'update'])->name('admin.category_update');
	Route::post('category_delete',[CategoryController::class,'delete'])->name('admin.category_delete');


	// Sub Category Routes
	Route::get('load_subcategory',[SubCategoryController::class,'datatable'])->name('admin.load_subcategory');
	Route::get('subcategory_list',[SubCategoryController::class,'index'])->name('admin.subcategory_list');
	Route::get('subcategory_create',[SubCategoryController::class,'create'])->name('admin.subcategory_create');
	Route::post('subcategory_store',[SubCategoryController::class,'store'])->name('admin.subcategory_store');
	Route::get('subcategory_edit/{id}',[SubCategoryController::class,'edit'])->name('admin.subcategory_edit');
	Route::post('subcategory_update',[SubCategoryController::class,'update'])->name('admin.subcategory_update');
	Route::post('get_cat_wise_subcate',[SubCategoryController::class,'get_sub_cat'])->name('get_cat_wise_subcate');
	Route::post('subcategory_delete',[SubCategoryController::class,'delete'])->name('admin.subcategory_delete');
	Route::post('find_sub_cat',[SubCategoryController::class,'cat_wise_sub_cat'])->name('find_sub_category');


	// Child Category Routes
	Route::get('load_childcategory',[ChildCategoryController::class,'datatable'])->name('admin.load_childcategory');
	Route::get('childcategory_list',[ChildCategoryController::class,'index'])->name('admin.childcategory_list');
	Route::get('childcategory_create',[ChildCategoryController::class,'create'])->name('admin.childcategory_create');
	Route::post('childcategory_store',[ChildCategoryController::class,'store'])->name('admin.childcategory_store');
	Route::get('childcategory_edit/{id}',[ChildCategoryController::class,'edit'])->name('admin.childcategory_edit');
	Route::post('childcategory_update',[ChildCategoryController::class,'update'])->name('admin.childcategory_update');
	Route::post('childcategory_delete',[ChildCategoryController::class,'delete'])->name('admin.childcategory_delete');
	Route::post('find_child_category',[ChildCategoryController::class,'sub_wise_child_cat'])->name('find_child_category');

	// brands Routes
	Route::get('load_brand',[BrandController::class,'datatable'])->name('admin.load_brand');
	Route::get('brand_list',[BrandController::class,'index'])->name('admin.brand_list');
	Route::get('brand_create',[BrandController::class,'create'])->name('admin.brand_create');
	Route::post('brand_store',[BrandController::class,'store'])->name('admin.brand_store');
	Route::get('brand_edit/{id}',[BrandController::class,'edit'])->name('admin.brand_edit');
	Route::post('brand_update',[BrandController::class,'update'])->name('admin.brand_update');
	Route::post('brand_delete',[BrandController::class,'delete'])->name('admin.brand_delete');



	// Product Routes
	Route::get('load_product',[ProductController::class,'datatable'])->name('admin.load_product');
	Route::get('product_list',[ProductController::class,'index'])->name('admin.product_list');
	Route::get('product_create',[ProductController::class,'create'])->name('admin.product_create');
	Route::post('product_store',[ProductController::class,'store'])->name('admin.product_store');
	Route::get('product_edit/{id}',[ProductController::class,'edit'])->name('admin.product_edit');
	Route::post('product_update',[ProductController::class,'update'])->name('admin.product_update');
	
	Route::post('product_delete',[ProductController::class,'delete'])->name('admin.product_delete');

	Route::post('update_product_status',[ProductController::class,'update_product_status'])->name('admin.update_product_status');
	Route::post('show_product_status',[ProductController::class,'show_product_status'])
	->name('admin.show_product_status');


  // Color Routes
	Route::get('load_color',[ColorController::class,'datatable'])->name('admin.load_color');
	Route::get('color_list',[ColorController::class,'index'])->name('admin.color_list');
	Route::get('color_create',[ColorController::class,'create'])->name('admin.color_create');
	Route::post('color_store',[ColorController::class,'store'])->name('admin.color_store');
	Route::get('color_edit/{id}',[ColorController::class,'edit'])->name('admin.color_edit');
	Route::post('color_update',[ColorController::class,'update'])->name('admin.color_update');
	Route::post('color_delete',[ColorController::class,'delete'])->name('admin.color_delete');


	  // Size Routes
	Route::get('load_size',[SizeController::class,'datatable'])->name('admin.load_size');
	Route::get('size_list',[SizeController::class,'index'])->name('admin.size_list');
	Route::get('size_create',[SizeController::class,'create'])->name('admin.size_create');
	Route::post('size_store',[SizeController::class,'store'])->name('admin.size_store');
	Route::get('size_edit/{id}',[SizeController::class,'edit'])->name('admin.size_edit');
	Route::post('size_update',[SizeController::class,'update'])->name('admin.size_update');
	Route::post('size_delete',[SizeController::class,'delete'])->name('admin.size_delete');

	 //Product Gallery
	Route::get('gallery_list/{id}',[GalleryController::class,'index'])->name('admin.gallery_list');
	Route::post('gallery_store',[GalleryController::class,'store'])->name('admin.gallery_store');
	Route::get('gallery_edit/{id}',[GalleryController::class,'edit'])->name('admin.gallery_edit');
	Route::post('gallery_update',[GalleryController::class,'update'])->name('admin.gallery_update');
	Route::post('gallery_delete',[GalleryController::class,'delete'])->name('admin.gallery_delete');

	//Product Stock
	Route::get('stock_list/{id}',[StockController::class,'index'])->name('admin.stock_list');
	Route::post('stock_store',[StockController::class,'store'])->name('admin.stock_store');
	Route::get('stock_edit/{id}',[StockController::class,'edit'])->name('admin.stock_edit');
	Route::post('stock_update',[StockController::class,'update'])->name('admin.stock_update');
	Route::post('stock_delete',[StockController::class,'delete'])->name('admin.stock_delete');


	//Payment routes
	Route::get('load_payment',[PaymentController::class,'datatable'])->name('admin.load_payment');
	Route::get('payment_list',[PaymentController::class,'index'])->name('admin.payment_list');
	Route::get('payment_create',[PaymentController::class,'create'])->name('admin.payment_create');
	Route::post('payment_store',[PaymentController::class,'store'])->name('admin.payment_store');
	Route::get('payment_edit/{id}',[PaymentController::class,'edit'])->name('admin.payment_edit');
	Route::post('payment_update',[PaymentController::class,'update'])->name('admin.payment_update');
	Route::post('payment_delete',[PaymentController::class,'delete'])->name('admin.payment_delete');



	// slider Routes
	Route::get('load_slider',[SliderController::class,'datatable'])->name('admin.load_slider');
	Route::get('slider_list',[SliderController::class,'index'])->name('admin.slider_list');
	Route::get('slider_create',[SliderController::class,'create'])->name('admin.slider_create');
	Route::post('slider_store',[SliderController::class,'store'])->name('admin.slider_store');
	Route::get('slider_edit/{id}',[SliderController::class,'edit'])->name('admin.slider_edit');
	Route::post('slider_update',[SliderController::class,'update'])->name('admin.slider_update');
	Route::post('slider_delete',[SliderController::class,'delete'])->name('admin.slider_delete');


	// Authenticate Routes
	Route::get('login',[LoginController::class,'showLoginForm'])->name('admin.login');
	Route::post('login',[LoginController::class,'login'])->name('admin.login');
	Route::post("admin_logout",[LoginController::class,'logout'])->name('admin.logout');
});



/*
|--------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------
|
*/

Auth::routes();

Route::get('/',[HomeController::class, 'index'])->name('front.index');
Route::get('/product_detail/{id}',[HomeController::class, 'product_detail'])->name('product.detail');
Route::get('/category_wise_product/{id}',[HomeController::class, 'category_product'])
->name('product.category_product');
Route::get('/subcategory_wise_product/{id}',[HomeController::class, 'subcategory_product'])
->name('product.subcategory_product');
Route::get('/childcategory_wise_product/{id}',[HomeController::class, 'childcategory_product'])->name('product.childcategory_product');
Route::get('/brand_wise_product/{id}',[HomeController::class, 'brand_wise_product'])->name('product.brand_wise_product');
Route::post('/find_color',[HomeController::class, 'find_color'])->name('find_color');
Route::post('/available_quantity',[HomeController::class, 'available_quantity'])->name('available_quantity');
Route::post('/search',[HomeController::class, 'search'])->name('product.search');
Route::get('/shop',[HomeController::class, 'product_shop'])->name('product.shop');
Route::match(array('post','get'),'/search',[HomeController::class, 'search'])->name('product.search');


// cart routes
Route::post('/add_to_cart',[CartController::class, 'add_to_cart'])->name('add_to_cart');
Route::get('/cart_view',[CartController::class, 'cart'])->name('view.cart');
Route::post('/cart_delete',[CartController::class, 'cart_delete'])->name('cart.delete');
Route::post('/cart_update',[CartController::class, 'cart_update'])->name('cart.update');
Route::get('/checkout',[CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/submit_checkout',[CheckoutController::class, 'submit_checkout'])->name('submit.checkout');
Route::get('/success_checkout',[CheckoutController::class, 'success_checkout'])->name('success.checkout');
// Wishlist route
Route::post('/add_to_wishlist',[WishlistController::class, 'add_wishlist'])->name('add_to_wishlist');
Route::get('/wishlist',[WishlistController::class, 'wishlist'])->name('wishlist');
Route::post('/wishlist_delete',[WishlistController::class, 'delete'])->name('wishlist.delete');

