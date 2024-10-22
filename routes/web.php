<?php


use App\Http\Controllers\Admin\CKEditorController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\Header1Controller;
use App\Http\Controllers\Admin\Header2Controller;
use App\Http\Controllers\Admin\HeaderCategoryController;
use App\Http\Controllers\Admin\MarketController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BidderController;
use App\Http\Controllers\Controller;
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
Route::get('/search', [IndexController::class, 'search'])->name('home.search');
Route::post('/Market_Table_Index_Status', [IndexController::class, 'Market_Table_Index_Status'])->name('home.Market_Table_Index_Status');
Route::get('/home', [IndexController::class, 'home'])->name('home');
Route::get('/redirect-user', [IndexController::class, 'redirectUser'])->name('profile');
Route::post('/startBroadCast', [IndexController::class, 'startBroadCast'])->name('startBroadCast');
Route::post('/MarketTableIndex', [IndexController::class, 'MarketTableIndex'])->name('home.MarketTableIndex');
Route::post('/GetMarket', [MarketHomeController::class, 'GetMarket'])->name('home.GetMarket');
Route::get('/bid/{market}', [MarketHomeController::class, 'bid'])->name('home.bid')->middleware('auth');
Route::post('/ShowBidPage', [MarketHomeController::class, 'ShowBidPage'])->name('home.ShowBidPage');
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
Route::get('/create_user_status', [IndexController::class, 'create_user_status'])->name('home.create_user_status');
Route::get('/shipping_term', [IndexController::class, 'shipping_term'])->name('home.shipping_term');

Route::get('/quality_quantity_inspector', [IndexController::class, 'quality_quantity_inspector'])->name('home.quality_quantity_inspector');
Route::get('/InspectionPlace', [IndexController::class, 'InspectionPlace'])->name('home.InspectionPlace');
Route::get('/Platforms', [IndexController::class, 'Platforms'])->name('home.Platforms');
Route::get('/header_category', [IndexController::class, 'header_category'])->name('home.header_category');
Route::get('/header_currency', [IndexController::class, 'header_currency'])->name('home.header_currency');
Route::get('/Container_Type', [IndexController::class, 'Container_Type'])->name('home.Container_Type');
Route::get('/ContractType', [IndexController::class, 'ContractType'])->name('home.ContractType');
Route::get('/Flexi_tank', [IndexController::class, 'Flexi_tank'])->name('home.Flexi_tank');
Route::get('/THC_Included', [IndexController::class, 'THC_Included'])->name('home.THC_Included');
Route::get('/TargetMarket', [IndexController::class, 'TargetMarket'])->name('home.TargetMarket');
Route::get('/Destination', [IndexController::class, 'Destination'])->name('home.Destination');
Route::get('/market_status_update', [IndexController::class, 'market_status_update'])->name('home.market_status_update');
Route::get('/Create_User_Activation_Status', [IndexController::class, 'Create_User_Activation_Status'])->name('home.Create_User_Activation_Status');

//Admin Panel Route
Route::name('admin.')->middleware('check.session')->prefix('/admin-panel/management/')->group(function () {
    //dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //users-list
    Route::get('users/zero/{type}/index/', [UserController::class, 'index'])->middleware('permission:Users-Inbox')->name('users.zero.index');
    Route::get('users/first/{type}/index/', [UserController::class, 'index'])->middleware('permission:Users-Registering')->name('users.first.index');
    Route::get('users/second/{type}/index/', [UserController::class, 'index'])->middleware('permission:Users-Confirmed')->name('users.second.index');
    Route::get('users/third/{type}/index/', [UserController::class, 'index'])->middleware('permission:Users-Rejected')->name('users.third.index');
    Route::get('users/seller/{type}/index/', [UserController::class, 'index'])->middleware('permission:Users-Sellers')->name('users.seller.index');
    Route::get('users/buyer/{type}/index/', [UserController::class, 'index'])->middleware('permission:Users-Buyers')->name('users.buyer.index');
    Route::get('users/members/{type}/index/', [UserController::class, 'index'])->middleware('permission:Users-Members')->name('users.members.index');
    Route::get('users/Representatives/{type}/index/', [UserController::class, 'index'])->middleware('permission:Users-Representatives')->name('users.Representatives.index');
    Route::get('users/brokers/{type}/index/', [UserController::class, 'index'])->middleware('permission:Users-Brokers')->name('users.brokers.index');
    Route::get('users/status/{status}', [UserController::class, 'users_status'])->name('users.status');
    Route::post('users/edit_modal', [UserController::class, 'edit_modal'])->name('user.edit_modal');

    //inquiries-list
    Route::get('/sales_form/first/index/{status}', [FormController::class, 'sales_form_index'])->middleware('permission:Users-Inbox')->name('sales_form.first.index');
    Route::get('/sales_form/second/index/{status}', [FormController::class, 'sales_form_index'])->middleware('permission:Inquires-Cash-Pending')->name('sales_form.second.index');
    Route::get('/sales_form/third/index/{status}', [FormController::class, 'sales_form_index'])->middleware('permission:Inquires-Data-Pending')->name('sales_form.third.index');
    Route::get('/sales_form/forth/index/{status}', [FormController::class, 'sales_form_index'])->middleware('permission:Inquires-Rejected-Inquiries')->name('sales_form.forth.index');
    Route::get('/sales_form/sixth/index/{status}', [FormController::class, 'sales_form_index'])->middleware('permission:Inquires-Preparation')->name('sales_form.sixth.index');
    Route::get('/sales_form/fifth/index/{status}', [FormController::class, 'sales_form_index'])->middleware('permission:Inquires-Approved')->name('sales_form.fifth.index');
    Route::get('/sales_form/index/{status}', [FormController::class, 'sales_form_index'])->name('sales_form.index');

    //currencies
    Route::get('settings/currencies/index', [CurrencyController::class, 'index'])->middleware('permission:Settings-Currency')->name('currencies.index');
    Route::get('settings/currency/create', [CurrencyController::class, 'create'])->middleware('permission:Settings-Currency')->name('currency.create');
    Route::post('settings/currency/store', [CurrencyController::class, 'store'])->middleware('permission:Settings-Currency')->name('currency.store');
    Route::get('settings/currency/edit/{currency}', [CurrencyController::class, 'edit'])->middleware('permission:Settings-Currency')->name('currency.edit');
    Route::put('settings/currency/update/{currency}', [CurrencyController::class, 'update'])->middleware('permission:Settings-Currency')->name('currency.update');
    Route::post('settings/currency/remove/{id}', [CurrencyController::class, 'remove'])->middleware('permission:Settings-Currency')->name('currency.remove');
    //countries
    Route::get('settings/countries/index', [CountryController::class, 'index'])->name('countries.index');
    Route::get('settings/country/create', [CountryController::class, 'create'])->name('country.create');
    Route::post('settings/country/store', [CountryController::class, 'store'])->name('country.store');
    Route::get('settings/country/edit/{country}', [CountryController::class, 'edit'])->name('country.edit');
    Route::put('settings/country/update/{country}', [CountryController::class, 'update'])->name('country.update');
    Route::post('settings/country/remove/{id}', [CountryController::class, 'remove'])->name('country.remove');
    //package
    Route::get('settings/packages/index', [PackageController::class, 'index'])->name('packages.index');
    Route::get('settings/package/create', [PackageController::class, 'create'])->name('package.create');
    Route::post('settings/package/store', [PackageController::class, 'store'])->name('package.store');
    Route::get('settings/package/edit/{package}', [PackageController::class, 'edit'])->name('package.edit');
    Route::put('settings/package/update/{package}', [PackageController::class, 'update'])->name('package.update');
    Route::post('settings/package/remove/{id}', [PackageController::class, 'remove'])->name('package.remove');


    Route::get('setting/header1', [Header1Controller::class, 'index'])->middleware('permission:Line-1')->name('header1.index');
    Route::get('setting/header1/create/{cat}', [Header1Controller::class, 'create'])->middleware('permission:Line-1')->name('header1.create');
    Route::post('setting/header1/store', [Header1Controller::class, 'store'])->middleware('permission:Line-1')->name('header1.store');
    Route::get('setting/header1/edit/{id}', [Header1Controller::class, 'edit'])->middleware('permission:Line-1')->name('header1.edit');
    Route::put('setting/header1/update/{item}', [Header1Controller::class, 'update'])->middleware('permission:Line-1')->name('header1.update');
    Route::post('setting/header1/remove/{id}', [Header1Controller::class, 'remove'])->middleware('permission:Line-1')->name('header1.remove');
    Route::post('setting/header1/change_status', [Header1Controller::class, 'change_status'])->middleware('permission:Line-1')->name('header1.change_status');
    Route::get('setting/header1/headers/{id}', [Header1Controller::class, 'headers'])->middleware('permission:Line-1')->name('header1.category.headers.list');
    Route::get('setting/header1/cat/create', [Header1Controller::class, 'headers_create'])->middleware('permission:Line-1')->name('header1.category.headers.create');
    Route::post('setting/header1/cat/store', [Header1Controller::class, 'headers_store'])->middleware('permission:Line-1')->name('header1.category.headers.store');
    Route::get('setting/header1/cat/{id}', [Header1Controller::class, 'headers_edit'])->middleware('permission:Line-1')->name('header1.category.headers.edit');
    Route::put('setting/header1/cat/{id}', [Header1Controller::class, 'headers_update'])->middleware('permission:Line-1')->name('header1.category.headers.update');
    Route::post('setting/header1/cat/remove/{id}', [Header1Controller::class, 'headers_remove'])->middleware('permission:Line-1')->name('header1.category.headers.remove');
    Route::post('setting/header1/category/change_status', [Header1Controller::class, 'category_change_status'])->middleware('permission:Line-1')->name('header1.category.change_status');

    //header2
    Route::get('setting/header2', [Header2Controller::class, 'index'])->middleware('permission:Line-2')->name('header2.index');
    Route::get('setting/header2/create', [Header2Controller::class, 'create'])->middleware('permission:Line-2')->name('header2.create');
    Route::post('setting/header2/store', [Header2Controller::class, 'store'])->middleware('permission:Line-2')->name('header2.store');
    Route::get('setting/header2/edit/{id}', [Header2Controller::class, 'edit'])->middleware('permission:Line-2')->name('header2.edit');
    Route::put('setting/header2/update/{id}', [Header2Controller::class, 'update'])->middleware('permission:Line-2')->name('header2.update');
    Route::post('setting/header2/remove/{id}', [Header2Controller::class, 'remove'])->middleware('permission:Line-2')->name('header2.remove');
    Route::post('setting/header2/change_status', [Header2Controller::class, 'change_status'])->middleware('permission:Line-2')->name('header2.change_status');
    Route::get('setting/header2/headers/{id}', [Header2Controller::class, 'headers'])->middleware('permission:Line-2')->name('header2.category.headers.list');
    Route::get('setting/header2/cat/create', [Header2Controller::class, 'headers_create'])->middleware('permission:Line-2')->name('header2.category.headers.create');
    Route::post('setting/header2/cat/store', [Header2Controller::class, 'headers_store'])->middleware('permission:Line-2')->name('header2.category.headers.store');
    Route::get('setting/header2/cat/{id}', [Header2Controller::class, 'headers_edit'])->middleware('permission:Line-2')->name('header2.category.headers.edit');
    Route::put('setting/header2/cat/{id}', [Header2Controller::class, 'headers_update'])->middleware('permission:Line-2')->name('header2.category.headers.update');
    Route::post('setting/header2/cat/remove/{id}', [Header2Controller::class, 'headers_remove'])->middleware('permission:Line-2')->name('header2.category.headers.remove');
    Route::post('setting/header2/category/change_status', [Header2Controller::class, 'category_change_status'])->middleware('permission:Line-2')->name('header2.category.change_status');

    Route::get('/admin/contact/form', [SettingController::class, 'form_contact_index'])->middleware('permission:Contact-Message')->name('contact.index');
    Route::get('/admin/contact/form/show/{contact}', [SettingController::class, 'form_contact_show'])->middleware('permission:Contact-Message')->name('contact.show');
    //blog
    Route::get('blogs/index', [BlogController::class, 'index'])->middleware('permission:Blog')->name('blog.index');
    Route::get('blog/create', [BlogController::class, 'create'])->middleware('permission:Blog')->name('blog.create');
    Route::post('blog/store', [BlogController::class, 'store'])->middleware('permission:Blog')->name('blog.store');
    Route::get('blog/edit/{blog}', [BlogController::class, 'edit'])->middleware('permission:Blog')->name('blog.edit');
    Route::put('blog/update/{blog}', [BlogController::class, 'update'])->middleware('permission:Blog')->name('blog.update');
    Route::post('blog/remove', [BlogController::class, 'remove'])->middleware('permission:Blog')->name('blog.remove');
    Route::get('category/index', [BlogCategoryController::class, 'index'])->middleware('permission:Blog')->name('blog.category.index');
    Route::get('category/create', [BlogCategoryController::class, 'create'])->middleware('permission:Blog')->name('blog.category.create');
    Route::post('category/store', [BlogCategoryController::class, 'store'])->middleware('permission:Blog')->name('blog.category.store');
    Route::get('category/edit/{category}', [BlogCategoryController::class, 'edit'])->middleware('permission:Blog')->name('blog.category.edit');
    Route::put('category/update/{category}', [BlogCategoryController::class, 'update'])->middleware('permission:Blog')->name('blog.category.update');
    Route::post('category/remove', [BlogCategoryController::class, 'remove'])->middleware('permission:Blog')->name('blog.category.remove');

    //settings

    Route::resource('setting', SettingController::class)->except('update', 'destroy','index')->middleware('permission:Settings-Setting')->names('settings');
    Route::get('/admin/settings/index/{type}', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/admin/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/admin/settings/delete/{setting}', [SettingController::class, 'destroy'])->name('settings.destroy');
    Route::post('/admin/settings/ChangeLineSpeed', [SettingController::class, 'ChangeLineSpeed'])->name('ChangeLineSpeed');

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
    //Refund
    Route::get('refund_request', [UserController::class, 'refund_request'])->name('refund_request');
    Route::post('UpdateRefundStatus', [UserController::class, 'UpdateRefundStatus'])->name('UpdateRefundStatus');
    Route::post('get_user_information', [UserController::class, 'get_user_information'])->name('get_user_information');
    Route::post('change_status', [UserController::class, 'change_status'])->name('change_status');
    Route::post('change_active_status', [UserController::class, 'change_active_status'])->name('user.change_active_status');


    //Config

    Route::get('users/{type}/index', [UserController::class, 'index'])->name('users.index');
    Route::post('users/remove', [UserController::class, 'remove'])->name('user.remove');
    Route::get('users/{type}/{user}/mails', [UserController::class, 'mails'])->name('user.mails');
    Route::get('users/{type}/{user}/mail/{mail}', [UserController::class, 'mail'])->name('user.mail');
    Route::post('users/sendMessage/mail/{user}', [UserController::class, 'sendMessage'])->name('user.sendMessage');
    Route::post('users/update_role', [UserController::class, 'update_role'])->name('user.update_role');
    Route::post('member_save', [UserController::class, 'member_save'])->name('user.member.save');
    Route::put('member_update/{user}', [UserController::class, 'member_update'])->name('user.member.update');
    Route::post('check_email_exist', [UserController::class, 'check_email_exist'])->name('user.check_email_exist');
    //permission
    Route::resource('permission', '\App\Http\Controllers\Admin\PermissionController');
    Route::delete('permission', [PermissionController::class, 'delete'])->name('permission.delete');
    //roles
    Route::resource('roles', '\App\Http\Controllers\Admin\RoleController');
    Route::delete('role', [RoleController::class, 'delete'])->name('role.delete');
    //wallet
    Route::get('/wallet/{user}/index', [WalletController::class, 'index'])->name('user.wallet');
    Route::post('/wallet_change', [WalletController::class, 'wallet_change'])->name('user.wallet.change');

    Route::post('users/reset_password/{user}', [UserController::class, 'reset_password'])->name('user.reset_password');
    Route::get('users/{user}/edit/{type?}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('user.update');

    //form
    Route::resource('forms', FormController::class);
    Route::get('design/{id}', [FormController::class, 'design'])->name('forms.design');
    Route::put('/forms/design/{id}', [FormController::class, 'designUpdate'])->name('forms.design.update');
    Route::get('/forms/survey/{id}', [FormController::class, 'publicFill'])->name('forms.survey');
    Route::get('/forms/qr/{id}', [FormController::class, 'qrCode'])->name('forms.survey.qr');
    Route::post('/form-duplicate', [FormController::class, 'duplicate'])->name('forms.duplicate');
    Route::post('ckeditors/upload', [FormController::class, 'ckupload'])->name('ckeditors.upload');
    Route::post('dropzone/upload/{id}', [FormController::class, 'dropzone'])->name('dropzone.upload');
    Route::post('ckeditor/upload', [FormController::class, 'upload'])->name('ckeditor.upload');
    Route::get('form-status/{id}', [FormController::class, 'formStatus'])->name('form.status');
    Route::post('forms/destroy/{form}', [FormController::class, 'destroy'])->name('forms.destroy');

    //messages
    Route::get('messages/emails/index', [MessagesController::class, 'emails'])->middleware('permission:Message')->name('emails.index');
    Route::get('messages/emails/{id}/edit', [MessagesController::class, 'email_edit'])->middleware('permission:Message')->name('email.edit');
    Route::put('messages/emails/{mail}/update', [MessagesController::class, 'email_update'])->middleware('permission:Message')->name('email.update');
    Route::get('messages/alerts/index', [MessagesController::class, 'alerts'])->middleware('permission:Message')->name('alerts.index');
    Route::get('messages/alerts/{alert}/edit', [MessagesController::class, 'alert_edit'])->middleware('permission:Message')->name('alert.edit');
    Route::put('messages/alerts/{alert}/update', [MessagesController::class, 'alert_update'])->middleware('permission:Message')->name('alert.update');

    //Markets
    Route::get('markets', [MarketController::class, 'index'])->middleware('permission:Market-Markets')->name('markets.index');
    Route::get('markets/folder/{date}', [MarketController::class, 'folder'])->name('markets.folder');
    Route::get('market/create/{market_data}', [MarketController::class, 'create'])->middleware('permission:Market-Create-Market')->name('market.create');
    Route::post('market/store', [MarketController::class, 'store'])->name('market.store');
    Route::get('market/{market}/edit', [MarketController::class, 'edit'])->name('market.edit');
    Route::post('market/remove', [MarketController::class, 'remove'])->name('market.remove');
    Route::post('market/copy', [MarketController::class, 'copy'])->name('market.copy');
    Route::put('market/{market}/update', [MarketController::class, 'update'])->name('market.update');
    Route::put('market/form_update/{market}', [MarketController::class, 'form_update'])->name('market.form.update');
    Route::get('market/sale_form/{page_type?}/{item?}', [MarketController::class, 'sales_form'])->name('market.sale_form');
    Route::get('market/settings', [MarketController::class, 'settings'])->middleware('permission:Market-Setting')->name('markets.settings');
    Route::post('market/settings/update', [MarketController::class, 'settings_update'])->name('markets.settings.update');
    Route::post('market/sales_form/update_or_store/{item?}', [MarketController::class, 'sales_form_update_or_store'])->name('market.sale_form.update_or_store');
    Route::post('market/getMarket', [MarketController::class, 'getMarket'])->name('getMarket');
    Route::post('market/FolderMarketRemove/{date}', [MarketController::class, 'FolderMarketRemove'])->name('market.folder.remove');

    Route::post('/sales_form/remove', [FormController::class, 'sales_form_remove'])->name('sales_form.remove');
    Route::post('/sales_form/copy', [FormController::class, 'sales_form_copy'])->name('sales_form.copy');

});

Route::post('admin-panel/management/Final_Submit', [FormController::class, 'Final_Submit'])->name('admin.Final_Submit');

//SaleForm
Route::get('/sale_form_list/{type}', [FormController::class, 'sale_form_list'])->name('sale_form_list');
Route::get('/sale_forms/{status}', [FormController::class, 'sale_forms'])->name('sale_forms');
Route::get('/sale_form/{page_type?}/{item?}', [FormController::class, 'sales_form'])->name('sale_form');
Route::get('/sale_form_preparation/{item?}/{folder?}', [FormController::class, 'sales_form_preparation'])->name('sale_form.preparation');
Route::post('/preparation_store/{form_id}', [FormController::class, 'sales_form_preparation_store'])->name('sale_form.preparation_store');
Route::post('/sales_form_preparation_remove_file', [FormController::class, 'sales_form_preparation_remove_file'])->name('sale_form.preparation.remove_file');
Route::post('/sales_form/update_or_store/{item?}/{is_preparation?}', [FormController::class, 'sales_form_update_or_store'])->name('sale_form.update_or_store');
Route::post('/sales_form_change_status/', [FormController::class, 'change_status'])->name('sale_form.change_status');
Route::get('/sale_form_permission/{item}', [FormController::class, 'sale_form_permission'])->name('sale_form.permission');
Route::post('/sale_form_permission_store_roles', [FormController::class, 'sale_form_permission_store_roles'])->name('sale_form.store_roles');
Route::post('users/user_permission', [FormController::class, 'user_permission'])->name('sale_form.user_permission.search');
Route::post('/sale_form_permission_store_ids', [FormController::class, 'sale_form_permission_store_ids'])->name('sale_form.store_ids');
Route::post('/marketPermission/remove/{user}/{market}', [FormController::class, 'marketPermissionRemove'])->name('marketPermission.remove');
Route::post('/UpdateCashPending/', [FormController::class, 'UpdateCashPending'])->name('sale_form.UpdateCashPending');
Route::get('sales_offer/show/{id}', [FormController::class, 'sales_form_show'])->name('sale_form.show');
Route::get('sales_offer/edit/{id}', [FormController::class, 'sales_form_edit'])->name('sale_form.edit');
//seller
Route::name('seller.')->middleware('check.session')->prefix('/seller/')->middleware(['seller', 'prevent.concurrent.login'])->group(function () {
    Route::get('dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::put('update/profile/{user}', [SellerController::class, 'updateProfile'])->name('update.profile');
    Route::put('update/password', [SellerController::class, 'updatePassword'])->name('update.password');
    Route::get('profile', [SellerController::class, 'profile'])->name('profile');
    Route::get('wallet', [SellerController::class, 'wallet'])->name('wallet');
    Route::get('requests', [SellerController::class, 'requests'])->name('requests');
    Route::get('refund_request', [SellerController::class, 'refund_request'])->middleware('permission:Bid-Deposit-Refund-Request')->name('refund_request');
});
Route::name('bidder.')->middleware('check.session')->prefix('/bidder/')->middleware(['bidder', 'prevent.concurrent.login'])->group(function () {
    Route::get('dashboard', [BidderController::class, 'dashboard'])->name('dashboard');
    Route::put('update/profile/{user}', [BidderController::class, 'updateProfile'])->name('update.profile');
    Route::put('update/password', [BidderController::class, 'updatePassword'])->name('update.password');
    Route::get('profile', [BidderController::class, 'profile'])->name('profile');
    Route::get('wallet', [BidderController::class, 'wallet'])->name('wallet');
    Route::get('requests', [BidderController::class, 'requests'])->name('requests');
    Route::get('refund_request', [BidderController::class, 'refund_request'])->name('refund_request');
});
Route::name('profile.')->prefix('/profile/')->group(function () {
    Route::get('index', [ProfileController::class, 'index'])->name('index');
});
Route::post('ckeditor/image_upload', [CKEditorController::class, 'upload'])->name('upload');
Route::post('join/news', [IndexController::class, 'join_news'])->name('join.news');
Route::get('blogs', [IndexController::class, 'blogs'])->name('home.blogs.index');
Route::get('blog/show/{blog}', [IndexController::class, 'blog_show'])->name('home.blog.show');
Route::get('StartCheck', [IndexController::class, 'StartCheck'])->name('home.StartCheck');
Route::get('SessionCheck', [IndexController::class, 'SessionCheck'])->name('home.SessionCheck');
Route::get('today_market_status', [IndexController::class, 'today_market_status'])->name('home.today_market_status');
Route::get('today_market_difference', [IndexController::class, 'today_market_difference'])->name('home.today_market_difference');
Route::post('market_more_info', [IndexController::class, 'market_more_info'])->name('home.market_more_info');
Route::get('ResetSystem', [IndexController::class, 'ResetSystem'])->name('home.ResetSystem');
Route::get('CreateAdmin', [IndexController::class, 'CreateAdmin'])->name('home.CreateAdmin');
Route::get('CreateType', [IndexController::class, 'CreateType'])->name('home.CreateType');
Route::get('CreateUserIds', [IndexController::class, 'CreateUserIds'])->name('home.CreateUserIds');
Route::get('CreateAllCommodity', [IndexController::class, 'CreateAllCommodity'])->name('home.CreateAllCommodity');
Route::get('CreateLogoDark', [IndexController::class, 'CreateLogoDark'])->name('home.CreateLogoDark');
Route::post('/form/send-request/contact', [FormController::class, 'form_contact'])->name('form.contact');
Route::get('/logout', function () {
    \auth()->logout();
    return redirect()->route('home.index');
});

Route::get('/login', function () {
    return redirect()->route('home.index');
})->name('login');
Route::get('/register', function () {
    return redirect()->route('home.index');
})->name('register');


Route::get('check_market/{id}', [IndexController::class, 'check_market'])->name('home.check_market');

//PayPal
Route::post('/pay_bid_deposit', [Payment::class, 'pay_bid_deposit'])->name('pay_bid_deposit');
Route::post('/paypal-payment', [PaypalController::class, 'payment'])->name('payment.paypal');
Route::get('/paypal/verify/{user}/{amount}', [PaypalController::class, 'verify'])->name('paypal.verify');
Route::get('/paypal/cancel', [PaypalController::class, 'cancel'])->name('paypal.cancel');
Route::post('/refund', [Controller::class, 'refund'])->name('refund');
Route::get('/loogout/{username}', function ($username) {
    $user = \App\Models\User::where('email', '=', $username)->first();
    $session=\App\Models\SessionModel::where('user_id', '=', $user->id)->first();
    $session->delete();
    dd('ok');
});
Route::get('/change_name/{username}/{full_name}', function ($username,$full_name) {
    $user = \App\Models\User::where('email', '=', $username)->first();
    $user->update([
        'full_name' => $full_name
    ]);
    dd('ok');
});


