<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class SettingController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index($type)

    {

        // کلیدهای تنظیمات

        $settingsKeys = [

            'logo',

            'fav_icon',

            'title',

            'meta_keywords',

            'robot_index',

            'meta_description',

            'footer_logo',

            'start_market',

            'end_market',

            'email',

            'admin_avatar',

            'side_bar_color',

            'top_bar_color',

            'alert_description',

            'alert_bg_color',

            'alert_text_color',

            'alert_font_size',

            'alert_height',

            'alert_active',

            'about_arma',

            'facebook',

            'twitter',

            'linkedin',

            'copy_right',

            'logo_dark' // افزودن کلید logo_dark
        ];



        // دریافت تنظیمات
        $settings = Setting::whereIn('key', $settingsKeys)->pluck('value', 'key')->toArray();
        $logo_dark = $settings['logo_dark'] ?? null; // مقداردهی به logo_dark
        // نمایش view با تنظیمات
        return view('admin.setting.index', compact('settings', 'type','logo_dark'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $settings = Setting::all();
        return view('setting::edit', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $result = $this->updateRepo($request);
        return redirect()->back()->with($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($setting)
    {

        $result = $this->deleteRepo($setting);
        session()->flash($result[0], $result[1]);
        return \response()->json($result);
    }

    public function ChangeLineSpeed(Request $request)
    {
        $value = $request->value;
        $line = $request->line;
        if ($line == 1) {
            $title = 'start_market';
        } else {
            $title = 'end_market';
        }
        $setting = Setting::where('key', $title)->first();
        $setting->update([
            'value' => $value,
        ]);
        return \response()->json([1, 'ok']);
    }

    public function updateRepo($request)
    {
        try {
            // آرایه‌ای برای ورودی‌های قابل دریافت
            $fileFields = ['logo', 'fav_icon', 'footer_logo', 'admin_avatar','logo_dark'];
            $data = [];

            // بارگذاری فایل‌ها
            foreach ($fileFields as $field) {
                $data[$field] = $this->fileUploaderRepo($request, $field);
            }

            // سایر ورودی‌ها
            $fields = [
                'title', 'meta_keywords', 'robot_index', 'meta_description',
                'start_market', 'end_market', 'email', 'top_bar_color',
                'side_bar_color', 'alert_description', 'alert_bg_color',
                'alert_text_color', 'alert_font_size', 'alert_height',
                'facebook', 'twitter', 'linkedin', 'about_arma',
                'copy_right'
            ];

            foreach ($fields as $field) {
                $data[$field] = $request->$field;
            }

            // تنظیم مقدار active در صورت وجود
            $data['alert_active'] = $request->has('alert_active') ? 1 : 0;

            // آپدیت یا ایجاد تنظیمات
            foreach ($data as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            return ['success' => 'Items updated successfully'];
        } catch (\Exception $exception) {
            return ['failed' => $exception->getMessage()];
        }
    }


    public function deleteRepo($setting)
    {
        try {
            $setting = Setting::where("value", $setting)->firstOrFail();
            $setting->update(['value' => null]);
            return [0 => 'success', 1 => 'Items deleted successfully'];
        } catch (\Exception $exception) {
            return [0 => 'failed', 1 => $exception->getMessage()];
        }
    }

    private function fileUploaderRepo($request, $file_name)
    {
        if ($request->has($file_name)) {
            $env = env('UPLOAD_SETTING');
            $fileNameImage = generateFileName($request->$file_name->getClientOriginalName());
            $request->$file_name->move(public_path($env), $fileNameImage);
        } else {
            $fileNameImage = Setting::where('key', $file_name)->pluck('value')->first();
        }
        return $fileNameImage;
    }

    public function form_contact_index()
    {
        $contacts = ContactForm::paginate(25);

        return view('admin.contact.index', compact('contacts'));
    }

    public function form_contact_show(ContactForm $contact)
    {


        return view('admin.contact.show', compact('contact'));
    }

}
