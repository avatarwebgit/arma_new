<?php


use App\Http\Controllers\Admin\CKEditorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\Header1Controller;
use App\Http\Controllers\Admin\Header2Controller;
use App\Http\Controllers\Admin\HeaderCategoryController;
use App\Http\Controllers\Admin\MarketController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BidderController;
use App\Http\Controllers\Home\UserController as UserHomeController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\Home\MarketHomeController;
use App\Http\Controllers\Home\ProfileController;
use App\Http\Controllers\Payment;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\Seller\SellerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;


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

// 'verified_phone'  middleware
Route::group(['middleware' => ['auth', 'xss', 'verified', '2fa']], function () {

});

Route::resource('role', '\App\Http\Controllers\Admin\RoleController');
Route::post('/role-permission/{id}', [
    'as' => 'roles_permit',
    'uses' => '\App\Http\Controllers\Admin\RoleController@assignPermission',
]);

/////////////////////////////////web
Route::get('/', [IndexController::class, 'index'])->name('home.index');
Route::post('/Market_Table_Index_Status', [IndexController::class, 'Market_Table_Index_Status'])->name('home.Market_Table_Index_Status');
Route::get('/home', [IndexController::class, 'home'])->name('home');
Route::get('/redirect-user', [IndexController::class, 'redirectUser'])->name('profile');
Route::post('/startBroadCast', [IndexController::class, 'startBroadCast'])->name('startBroadCast');
Route::post('/MarketTableIndex', [IndexController::class, 'MarketTableIndex'])->name('home.MarketTableIndex');
Route::post('/GetMarket', [MarketHomeController::class, 'GetMarket'])->name('home.GetMarket');
Route::get('/bid/{market}', [MarketHomeController::class, 'bid'])->name('home.bid')->middleware('auth');
Route::post('/bid_market/', [MarketHomeController::class, 'bid_market'])->name('home.bid_market');
Route::post('/remove_bid/', [MarketHomeController::class, 'remove_bid'])->name('home.remove_bid');
Route::post('/refreshMarketTable', [MarketHomeController::class, 'refreshMarketTable'])->name('home.refreshMarketTable');
Route::post('/refreshMarket', [MarketHomeController::class, 'refreshMarket'])->name('home.refreshMarket');
Route::post('/refreshBidTable', [MarketHomeController::class, 'refreshBidTable'])->name('home.refreshBidTable');
Route::post('/refreshSellerTable', [MarketHomeController::class, 'refreshSellerTable'])->name('home.refreshSellerTable');
Route::post('/change_market_status', [MarketHomeController::class, 'change_market_status'])->name('home.change_market_status');
Route::post('/seller_change_offer', [MarketHomeController::class, 'seller_change_offer'])->name('home.seller_change_offer');
Route::post('/get_market_bit_result', [MarketHomeController::class, 'get_market_bit_result'])->name('home.get_market_bit_result');
Route::post('/get_market_info', [MarketHomeController::class, 'get_market_info'])->name('home.get_market_info');
Route::get('/menu/{menus}', [IndexController::class, 'menus'])->name('home.menus');
Route::post('check_market_status_for_continue', [MarketHomeController::class, 'check_market_status_for_continue'])->name('home.check_market_status_for_continue');
//
Route::get('/create_countries', [IndexController::class, 'create_countries'])->name('home.create_countries');
Route::get('/create_currencies', [IndexController::class, 'create_currencies'])->name('home.create_currencies');
Route::get('/create_units', [IndexController::class, 'create_units'])->name('home.create_units');
Route::get('/tolerance_wight_by', [IndexController::class, 'tolerance_wight_by'])->name('home.tolerance_wight_by');
Route::get('/create_packing', [IndexController::class, 'create_packing'])->name('home.create_packing');
Route::get('/shipping_term', [IndexController::class, 'shipping_term'])->name('home.shipping_term');

Route::get('/quality_quantity_inspector', [IndexController::class, 'quality_quantity_inspector'])->name('home.quality_quantity_inspector');
Route::get('/InspectionPlace', [IndexController::class, 'InspectionPlace'])->name('home.InspectionPlace');
Route::get('/Platforms', [IndexController::class, 'Platforms'])->name('home.Platforms');

Route::name('admin.')->middleware('admin')->prefix('/admin-panel/management/')->group(function () {
    //dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::middleware('permission:header-setting')->group(function () {
        Route::get('setting/header1', [Header1Controller::class, 'index'])->name('header1.index');
        Route::get('setting/header1/create', [Header1Controller::class, 'create'])->name('header1.create');
        Route::post('setting/header1/store', [Header1Controller::class, 'store'])->name('header1.store');
        Route::get('setting/header1/edit/{id}', [Header1Controller::class, 'edit'])->name('header1.edit');
        Route::put('setting/header1/update/{item}', [Header1Controller::class, 'update'])->name('header1.update');
        Route::post('setting/header1/remove/{id}', [Header1Controller::class, 'remove'])->name('header1.remove');
        //header2
        Route::get('setting/header2', [Header2Controller::class, 'index'])->name('header2.index');
        Route::get('setting/header2/create', [Header2Controller::class, 'create'])->name('header2.create');
        Route::post('setting/header2/store', [Header2Controller::class, 'store'])->name('header2.store');
        Route::get('setting/header2/edit/{id}', [Header2Controller::class, 'edit'])->name('header2.edit');
        Route::put('setting/header2/update/{id}', [Header2Controller::class, 'update'])->name('header2.update');
        Route::post('setting/header2/remove/{id}', [Header2Controller::class, 'remove'])->name('header2.remove');
    });
    Route::get('/admin/contact/form', [SettingController::class, 'form_contact_index'])->name('contact.index');
    Route::get('/admin/contact/form/show/{contact}', [SettingController::class, 'form_contact_show'])->name('contact.show');
    //blog

    Route::get('blogs/index', [BlogController::class, 'index'])->name('blog.index');
    Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('blog/edit/{blog}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('blog/update/{blog}', [BlogController::class, 'update'])->name('blog.update');
    Route::post('blog/remove', [BlogController::class, 'remove'])->name('blog.remove');


    Route::get('category/index', [BlogCategoryController::class, 'index'])->name('blog.category.index');
    Route::get('category/create', [BlogCategoryController::class, 'create'])->name('blog.category.create');
    Route::post('category/store', [BlogCategoryController::class, 'store'])->name('blog.category.store');
    Route::get('category/edit/{category}', [BlogCategoryController::class, 'edit'])->name('blog.category.edit');
    Route::put('category/update/{category}', [BlogCategoryController::class, 'update'])->name('blog.category.update');
    Route::post('category/remove', [BlogCategoryController::class, 'remove'])->name('blog.category.remove');

    //settings
    Route::resource('setting', SettingController::class)->except('update', 'destroy')->names('settings');
    Route::put('/admin/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/admin/settings/delete/{setting}', [SettingController::class, 'destroy'])->name('settings.destroy');

    //menus
    Route::get('menus/index', [MenuController::class, 'index'])->name('menus.index');
    Route::get('menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('menu/edit/{menu}', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('menu/update/{menu}', [MenuController::class, 'update'])->name('menu.update');
    Route::post('menu/remove', [MenuController::class, 'remove'])->name('menu.remove');
    //pages
    Route::get('pages/index', [PageController::class, 'index'])->name('pages.index');
    Route::get('page/create', [PageController::class, 'create'])->name('page.create');
    Route::post('page/store', [PageController::class, 'store'])->name('page.store');
    Route::get('page/edit/{page}', [PageController::class, 'edit'])->name('page.edit');
    Route::put('page/update/{page}', [PageController::class, 'update'])->name('page.update');
    Route::post('page/remove', [PageController::class, 'remove'])->name('page.remove');
    //header_category
    Route::get('header_categories/index', [HeaderCategoryController::class, 'index'])->name('header_categories.index');
    Route::get('header_category/create', [HeaderCategoryController::class, 'create'])->name('header_category.create');
    Route::post('header_category/store', [HeaderCategoryController::class, 'store'])->name('header_category.store');
    Route::get('header_category/edit/{category}', [HeaderCategoryController::class, 'edit'])->name('header_category.edit');
    Route::put('header_category/update/{category}', [HeaderCategoryController::class, 'update'])->name('header_category.update');
    Route::post('header_category/remove', [HeaderCategoryController::class, 'remove'])->name('header_category.remove');


    //Config
    Route::middleware('permission:user')->group(function () {
        //users
        Route::get('users/{type}/index', [UserController::class, 'index'])->name('users.index');
        Route::post('users/remove', [UserController::class, 'remove'])->name('user.remove');
        Route::get('users/{type}/{user}/mails', [UserController::class, 'mails'])->name('user.mails');
        Route::get('users/{type}/{user}/mail/{mail}', [UserController::class, 'mail'])->name('user.mail');
        Route::post('users/sendMessage/mail/{user}', [UserController::class, 'sendMessage'])->name('user.sendMessage');
        Route::post('users/update_role/{user}', [UserController::class, 'update_role'])->name('user.update_role');
        //permission
        Route::resource('permission', '\App\Http\Controllers\Admin\PermissionController');
        Route::delete('permission', [PermissionController::class, 'delete'])->name('permission.delete');
        //roles
        Route::resource('roles', '\App\Http\Controllers\Admin\RoleController');
        Route::delete('role', [RoleController::class, 'delete'])->name('role.delete');
        //wallet
        Route::get('/wallet/{user}/index', [WalletController::class, 'index'])->name('user.wallet');
        Route::post('/wallet_change', [WalletController::class, 'wallet_change'])->name('user.wallet.change');
    });
    Route::post('users/reset_password/{user}', [UserController::class, 'reset_password'])->middleware('permission:user|user-edit')->name('user.reset_password');
    Route::get('users/{type}/{user}', [UserController::class, 'edit'])->middleware('permission:user|user-edit')->name('user.edit');
    Route::put('users/{type}/{user}', [UserController::class, 'update'])->middleware(['permission:user|user-edit'])->name('user.update');
    Route::middleware('permission:form')->group(function () {
        //form
        Route::resource('forms', FormController::class);
        Route::get('design/{id}', [FormController::class, 'design'])->name('forms.design');
        Route::put('/forms/design/{id}', [FormController::class, 'designUpdate'])->name('forms.design.update');
        Route::get('/forms/survey/{id}', [FormController::class, 'publicFill'])->name('forms.survey');
        Route::get('/forms/qr/{id}', [FormController::class, 'qrCode'])->name('forms.survey.qr');
        Route::post('/form-duplicate', [FormController::class, 'duplicate'])->name('forms.duplicate')->middleware('permission:form-duplicate');
        Route::post('ckeditors/upload', [FormController::class, 'ckupload'])->name('ckeditors.upload');
        Route::post('dropzone/upload/{id}', [FormController::class, 'dropzone'])->name('dropzone.upload');
        Route::post('ckeditor/upload', [FormController::class, 'upload'])->name('ckeditor.upload');
        Route::get('form-status/{id}', [FormController::class, 'formStatus'])->name('form.status');
        Route::post('forms/destroy/{form}', [FormController::class, 'destroy'])->name('forms.destroy')->middleware('permission:form-delete');
    });
    //messages
    Route::middleware('permission:message')->group(function () {
        Route::get('messages/emails/index', [MessagesController::class, 'emails'])->name('emails.index');
        Route::get('messages/emails/{id}/edit', [MessagesController::class, 'email_edit'])->name('email.edit');
        Route::put('messages/emails/{mail}/update', [MessagesController::class, 'email_update'])->name('email.update');
        Route::get('messages/alerts/index', [MessagesController::class, 'alerts'])->name('alerts.index');
        Route::get('messages/alerts/{alert}/edit', [MessagesController::class, 'alert_edit'])->name('alert.edit');
        Route::put('messages/alerts/{alert}/update', [MessagesController::class, 'alert_update'])->name('alert.update');
    });
    //Markets
    Route::get('markets', [MarketController::class, 'index'])->name('markets.index');
    Route::get('markets/folder/{date}', [MarketController::class, 'folder'])->name('markets.folder');
    Route::get('market/create', [MarketController::class, 'create'])->name('market.create');
    Route::post('market/store', [MarketController::class, 'store'])->name('market.store');
    Route::get('market/{market}/edit', [MarketController::class, 'edit'])->name('market.edit');
    Route::post('market/remove', [MarketController::class, 'remove'])->name('market.remove');
    Route::post('market/copy', [MarketController::class, 'copy'])->name('market.copy');
    Route::put('market/{market}/update', [MarketController::class, 'update'])->name('market.update');
    Route::put('market/form_update/{market}', [MarketController::class, 'form_update'])->name('market.form.update');
    Route::get('market/sale_form/{page_type?}/{item?}', [MarketController::class, 'sales_form'])->name('market.sale_form');
    Route::get('market/settings', [MarketController::class, 'settings'])->name('markets.settings');
    Route::post('market/settings/update', [MarketController::class, 'settings_update'])->name('markets.settings.update');
    Route::post('market/sales_form/update_or_store/{item?}', [MarketController::class, 'sales_form_update_or_store'])->name('market.sale_form.update_or_store');
    Route::post('market/getMarket', [MarketController::class, 'getMarket'])->name('getMarket');
    Route::post('market/FolderMarketRemove/{date}', [MarketController::class, 'FolderMarketRemove'])->name('market.folder.remove');
    Route::get('/sales_form/index/{status}', [FormController::class, 'sales_form_index'])->name('sales_form.index');
    Route::post('/sales_form/remove', [FormController::class, 'sales_form_remove'])->name('sales_form.remove');
    Route::post('/Final_Submit', [FormController::class, 'Final_Submit'])->name('Final_Submit');
});

//SaleForm
Route::get('/sale_form/{page_type?}/{item?}', [FormController::class, 'sales_form'])->name('sale_form');
Route::post('/sales_form/update_or_store/{item?}', [FormController::class, 'sales_form_update_or_store'])->name('sale_form.update_or_store');
Route::post('/sales_form_change_status/', [FormController::class, 'change_status'])->name('sale_form.change_status');
Route::get('sales_offer/show/{id}', [FormController::class, 'sales_form_show'])->name('sale_form.show');
//seller
Route::name('seller.')->prefix('/seller/')->middleware('seller')->group(function () {
    Route::get('dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::put('update/profile/{user}', [SellerController::class, 'updateProfile'])->name('update.profile');
    Route::put('update/password', [SellerController::class, 'updatePassword'])->name('update.password');
    Route::get('profile', [SellerController::class, 'profile'])->name('profile');
    Route::get('wallet', [SellerController::class, 'wallet'])->name('wallet');
    Route::get('requests', [SellerController::class, 'requests'])->name('requests');
});
Route::name('bidder.')->prefix('/bidder/')->middleware('bidder')->group(function () {
    Route::get('dashboard', [BidderController::class, 'dashboard'])->name('dashboard');
    Route::put('update/profile/{user}', [BidderController::class, 'updateProfile'])->name('update.profile');
    Route::put('update/password', [BidderController::class, 'updatePassword'])->name('update.password');
    Route::get('profile', [BidderController::class, 'profile'])->name('profile');
    Route::get('wallet', [BidderController::class, 'wallet'])->name('wallet');
    Route::get('requests', [BidderController::class, 'requests'])->name('requests');
});
Route::name('profile.')->prefix('/profile/')->group(function () {
    Route::get('index', [ProfileController::class, 'index'])->name('index');
});
Route::post('ckeditor/image_upload', [CKEditorController::class, 'upload'])->name('upload');
Route::post('join/news', [IndexController::class, 'join_news'])->name('join.news');
Route::get('blogs', [IndexController::class, 'blogs'])->name('home.blogs.index');
Route::get('blog/show/{blog}', [IndexController::class, 'blog_show'])->name('home.blog.show');
Route::get('StartCheck', [IndexController::class, 'StartCheck'])->name('home.StartCheck');
Route::get('today_market_status', [IndexController::class, 'today_market_status'])->name('home.today_market_status');
Route::get('today_market_difference', [IndexController::class, 'today_market_difference'])->name('home.today_market_difference');
Route::post('/form/send-request/contact', [FormController::class, 'form_contact'])->name('form.contact');
Route::get('/logout', function () {
    \auth()->logout();
    return redirect()->route('home.index');
});


Route::get('check_market/{id}', [IndexController::class, 'check_market'])->name('home.check_market');

//PayPal
Route::post('/pay_bid_deposit',[Payment::class,'pay_bid_deposit'])->name('pay_bid_deposit');
Route::post('/paypal-payment',[PaypalController::class,'payment'])->name('payment.paypal');
Route::get('/paypal/verify/{user}/{amount}',[PaypalController::class,'verify'])->name('paypal.verify');
Route::get('/paypal/cancel',[PaypalController::class,'cancel'])->name('paypal.cancel');

