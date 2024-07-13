<?php

namespace App\Providers;

use App\Models\Commodity;
use App\Models\CompanyFunction;
use App\Models\Country;
use App\Models\Header1;
use App\Models\Header2;
use App\Models\HeaderCategory;
use App\Models\HeaderCategoryLine1;
use App\Models\MarketSetting;
use App\Models\Salutation;
use App\Models\Setting;
use App\Models\Type;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        Paginator::useBootstrap();
        $header1 = Header1::OrderBy('priority', 'asc')->get();
        $header2 = Header2::orderBy('priority', 'asc')->get();
        $logo = Setting::where('key', 'logo')->pluck('value')->first();
        $fav_icon = Setting::where('key', 'fav_icon')->pluck('value')->first();
        $title = Setting::where('key', 'title')->pluck('value')->first();
        $meta_keywords = Setting::where('key', 'meta_keywords')->pluck('value')->first();
        $robot_index = Setting::where('key', 'robot_index')->pluck('value')->first();
        $meta_description = Setting::where('key', 'meta_description')->pluck('value')->first();
        $footer_logo = Setting::where('key', 'footer_logo')->pluck('value')->first();
        $start_market = Setting::where('key', 'start_market')->pluck('value')->first();
        $end_market = Setting::where('key', 'end_market')->pluck('value')->first();
        $admin_avatar = Setting::where('key', 'admin_avatar')->pluck('value')->first();
        $side_bar_color = Setting::where('key', 'side_bar_color')->pluck('value')->first();
        $top_bar_color = Setting::where('key', 'top_bar_color')->pluck('value')->first();
        $alert_description = Setting::where('key', 'alert_description')->pluck('value')->first();
        $alert_bg_color = Setting::where('key', 'alert_bg_color')->pluck('value')->first();
        $alert_text_color = Setting::where('key', 'alert_text_color')->pluck('value')->first();
        $alert_font_size = Setting::where('key', 'alert_font_size')->pluck('value')->first();
        $alert_height = Setting::where('key', 'alert_height')->pluck('value')->first();
        $alert_active = Setting::where('key', 'alert_active')->pluck('value')->first();
        $about_arma = Setting::where('key', 'about_arma')->pluck('value')->first();
        $facebook = Setting::where('key', 'facebook')->pluck('value')->first();
        $twitter = Setting::where('key', 'twitter')->pluck('value')->first();
        $linkedin = Setting::where('key', 'linkedin')->pluck('value')->first();
        $ready_to_duration = MarketSetting::where('key', 'ready_to_duration')->pluck('value')->first();
        $open_duration = MarketSetting::where('key', 'open_duration')->pluck('value')->first();
        $q_1 = MarketSetting::where('key', 'q_1')->pluck('value')->first();
        $q_2 = MarketSetting::where('key', 'q_2')->pluck('value')->first();
        $q_3 = MarketSetting::where('key', 'q_3')->pluck('value')->first();
        $copy_right = Setting::where('key', 'copy_right')->pluck('value')->first();
        $header2_categories = HeaderCategory::orderBy('priority', 'asc')->where('status',1)->get();
<<<<<<< HEAD
        $header1_categories = HeaderCategoryLine1::orderBy('priority', 'asc')->get();
=======
        $header1_categories = HeaderCategoryLine1::orderBy('priority', 'asc')->where('status',1)->get();

        $types = Type::where('id', '!=', 1)->get();
        $commodities = Commodity::all();
        $countries = Country::OrderBy('countryName','asc')->get();
        $companyFunction = CompanyFunction::all();
        $salutation= Salutation::all();
>>>>>>> 9beb35a09b7da1751c6c9085eef4a59f6d008e57
        view()->share(
            compact(
                'header1',
                'header2',
                'logo',
                'footer_logo',
                'fav_icon',
                'title',
                'meta_keywords',
                'robot_index',
                'meta_description',
                'start_market',
                'admin_avatar',
                'end_market',
                'side_bar_color',
                'top_bar_color',
                'alert_description',
                'alert_bg_color',
                'alert_text_color',
                'alert_font_size',
                'alert_height',
                'alert_active',
                'ready_to_duration',
                'open_duration',
                'q_1',
                'q_2',
                'q_3',
                'about_arma',
                'facebook',
                'twitter',
                'linkedin',
                'copy_right',
                'header2_categories',
                'header1_categories',
                'types',
                'commodities',
                'countries',
                'companyFunction',
                'salutation'
            ));
    }
}
