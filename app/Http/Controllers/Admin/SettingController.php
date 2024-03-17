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
    public function index()
    {
        $logo = Setting::where('key', 'logo')->pluck('value')->first();
        $fav_icon = Setting::where('key', 'fav_icon')->pluck('value')->first();
        $title = Setting::where('key', 'title')->pluck('value')->first();
        $meta_keywords = Setting::where('key', 'meta_keywords')->pluck('value')->first();
        $robot_index = Setting::where('key', 'robot_index')->pluck('value')->first();
        $meta_description = Setting::where('key', 'meta_description')->pluck('value')->first();
        $footer_logo = Setting::where('key', 'footer_logo')->pluck('value')->first();
        $start_market = Setting::where('key', 'start_market')->pluck('value')->first();
        $end_market = Setting::where('key', 'end_market')->pluck('value')->first();
        $email = Setting::where('key', 'email')->pluck('value')->first();
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
        return view('admin.setting.index', compact('logo',
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
        ));
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
    public function updateRepo($request)
    {
        try {
            $logo = $this->fileUploaderRepo($request, 'logo');
            $fav_icon = $this->fileUploaderRepo($request, 'fav_icon');
            $footer_logo = $this->fileUploaderRepo($request, 'footer_logo');
            $admin_avatar = $this->fileUploaderRepo($request, 'admin_avatar');
            $title = $request->title;
            $meta_keywords = $request->meta_keywords;
            $robot_index = $request->robot_index;
            $meta_description = $request->meta_description;
            $start_market = $request->start_market;
            $end_market = $request->end_market;
            $email = $request->email;
            $top_bar_color = $request->top_bar_color;
            $side_bar_color = $request->side_bar_color;
            $alert_description =$request->alert_description;
            $alert_bg_color = $request->alert_bg_color;
            $alert_text_color = $request->alert_text_color;
            $alert_font_size =$request->alert_font_size;
            $alert_height = $request->alert_height;
            $facebook = $request->facebook;
            $twitter = $request->twitter;
            $linkedin = $request->linkedin;
            $about_arma = $request->about_arma;
            $alert_active=$request->has('alert_active')?1:0;
            $array = [
                'logo' => $logo,
                'fav_icon' => $fav_icon,
                'footer_logo' => $footer_logo,
                'title' => $title,
                'meta_keywords' => $meta_keywords,
                'robot_index' => $robot_index,
                'email' => $email,
                'meta_description' => $meta_description,
                'start_market' => $start_market,
                'end_market' => $end_market,
                'admin_avatar' => $admin_avatar,
                'top_bar_color' => $top_bar_color,
                'side_bar_color' => $side_bar_color,
                'alert_description' => $alert_description,
                'alert_bg_color' => $alert_bg_color,
                'alert_text_color' => $alert_text_color,
                'alert_font_size' => $alert_font_size,
                'alert_height' => $alert_height,
                'alert_active' => $alert_active,
                'linkedin' => $linkedin,
                'twitter' => $twitter,
                'facebook' => $facebook,
                'about_arma' => $about_arma,
            ];
            foreach ($array as $key => $value) {
                $key_exists=Setting::where("key", $key)->exists();
                if (!$key_exists){
                    Setting::create([
                        'key' => $key,
                    ]);
                }
                Setting::where("key", $key)->update(["value"=> $value]);
            }
            return ['success'=>'Items updated successfully'];
        }catch (\Exception $exception){
            return ['failed'=>$exception->getMessage()];
        }

    }
    public function deleteRepo($setting){
        try {
            $setting=Setting::where("value", $setting)->firstOrFail();
            $setting->update(['value'=>null]);
            return [0=>'success',1=>'Items deleted successfully'];
        }catch (\Exception $exception){
            return [0=>'failed',1=>$exception->getMessage()];
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

        return view('admin.contact.index',compact('contacts'));
    }

    public function form_contact_show(ContactForm $contact)
    {



        return view('admin.contact.show',compact('contact'));
    }

}
