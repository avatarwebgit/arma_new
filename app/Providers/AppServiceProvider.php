<?php

namespace App\Providers;

use App\Models\Commodity;
use App\Models\CompanyFunction;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Header1;
use App\Models\Header2;
use App\Models\HeaderCategory;
use App\Models\HeaderCategoryLine1;
use App\Models\MarketSetting;
use App\Models\PlatFom;
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

        $header1 = Header1::orderBy('priority', 'asc')->get();
        $header2 = Header2::orderBy('priority', 'asc')->get();
        $header2_categories = HeaderCategory::orderBy('priority', 'asc')->where('status', 1)->get();
        $header1_categories = HeaderCategoryLine1::orderBy('priority', 'asc')->where('status', 1)->get();

        $settingsKeys = [
            'logo', 'logo_dark','fav_icon', 'title', 'meta_keywords', 'robot_index',
            'meta_description', 'footer_logo', 'start_market', 'end_market',
            'admin_avatar', 'top_bar_color', 'alert_description',
            'alert_bg_color', 'alert_text_color', 'alert_font_size',
            'alert_height', 'alert_active', 'about_arma', 'facebook',
            'twitter', 'linkedin', 'copy_right','contact_us_banner','our_address','our_number','our_email'
        ];

        $settings = Setting::whereIn('key', $settingsKeys)->pluck('value', 'key');

        // بررسی و ساخت مقادیر جدید اگر وجود نداشته باشند

        foreach ($settingsKeys as $key) {

            if (!$settings->has($key)) {

                // اگر کلید وجود نداشت، آن را بسازید

                Setting::create([

                    'key' => $key,

                    'value' => null, // مقدار پیش‌فرض یا سفارشی خود را اینجا قرار دهید

                ]);

            }

        }

        $marketKeys = ['ready_to_duration', 'open_duration', 'q_1', 'q_2', 'q_3'];
        $marketSettings = MarketSetting::whereIn('key', $marketKeys)->pluck('value', 'key');

        $types = Type::where('id', '!=', 1)->get();
        $platforms = PlatFom::all();
        $commodities = Commodity::all();
        $countries = Country::orderBy('countryName', 'asc')->get();
        $companyFunction = CompanyFunction::all();
        $salutation = Salutation::all();
        $currencies = Currency::all();

        // Combine settings
        $combinedSettings = array_merge($settings->toArray(), $marketSettings->toArray());


        view()->share(
            array_merge($combinedSettings, compact(
                'header1',
                'header2',
                'header2_categories',
                'header1_categories',
                'types',
                'commodities',
                'countries',
                'companyFunction',
                'salutation',
                'platforms',
                'currencies'
            ))
        );
    }

}
