<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewUserRegisteredForAdminJob;
use App\Jobs\SendNewUserRegisteredForUserJob;
use App\Mail\NewUserRegisteredAdminMail;
use App\Models\Commodity;
use App\Models\CompanyFunction;
use App\Models\Country;
use App\Models\Message;
use App\Models\Role;
use App\Models\Salutation;
use App\Models\Setting;
use App\Models\Type;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\EmailValidate;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    public function showRegistrationForm()
    {
        $types = Role::all();
        $commodities = Commodity::all();
        $countries = Country::OrderBy('countryName', 'asc')->get();
        $companyFunction = CompanyFunction::all();
        $salutation = Salutation::all();
        return view('auth.register', compact('types', 'commodities', 'countries', 'companyFunction', 'salutation'));

    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        $modal_message = Message::where('type', 'UserRegistered')->first();
        return response()->json([1, $modal_message]);
        //email
        //send email with job
//        $admin = Setting::where('key', 'email')->pluck('value')->first();
//        dispatch(new SendNewUserRegisteredForAdminJob($admin));
//        dispatch(new SendNewUserRegisteredForUserJob($user->email));
        if ($response = $this->registered($request, $user)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());

    }

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {

        return Validator::make($data, [
            'company_name' => ['required', 'string', 'max:255'],
            'user_type' => ['required', 'string'],
            'company_country' => ['required', 'string', 'max:255'],
            'company_address' => ['required', 'string', 'max:255'],
            'company_phone' => ['required','numeric'],
            'company_website' => ['nullable', 'string', 'max:255'],
            'company_email' => ['required', 'email', 'max:255', 'unique:users', function ($attribute, $value, $fail) {
                if (
                    str_contains($value, '@onedrive')
                    or str_contains($value, '@googlemail')
                    or str_contains($value, '@youtube')
                    or str_contains($value, '@outlook')
                    or str_contains($value, '@yahoo')
                    or str_contains($value, '@ymail')
                    or str_contains($value, '@hotmail')
                    or str_contains($value, '@gmail')
                    or str_contains($value, '@rocketmail')
                    or str_contains($value, '@pm')
                    or str_contains($value, '@protonmail')
                    or str_contains($value, '@yandex')
                    or str_contains($value, '@zoho')
                    or str_contains($value, '@zohomail')

                ) {
                    $fail('Please enter Company :attribute.',);
                }
            }],
//            'company_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'commodity' => ['required', 'string', 'max:255'],
            'full_name' => ['required', 'string'],
            'salutation' => ['nullable', 'string'],
            'function_in_company' => ['required', 'string'],
            'email' => ['required', 'email'],
            'platform' => ['required', 'string'],
            'mobile_no' => ['required', 'numeric'],

//            'company_post_zip_code' => ['required', 'string', 'max:255'],
//            'company_city' => ['nullable', 'string', 'max:255'],
//            'company_state' => ['nullable', 'string', 'max:255'],
//            'company_title' => ['required', 'string'],
//            'skype' => ['nullable'],
//            'whatsapp' => ['nullable'],

            'accept_term' => ['required'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'company_name' => $data['company_name'],
            'user_type' => $data['user_type'],
            'company_country' => $data['company_country'],
            'company_address' => $data['company_address'],
            'company_phone' => $data['company_phone'],
            'company_website' => $data['company_website'],
            'company_email' => $data['company_email'],
            'commodity' => $data['commodity'],
            'full_name' => $data['full_name'],
            'salutation' => $data['salutation'],
            'function_in_company' => $data['function_in_company'],
            'email' => $data['email'],
            'platform' => $data['platform'],
            'mobile_no' => $data['mobile_no'],

//            'company_post_zip_code' => $data['company_post_zip_code'],
//            'company_city' => $data['company_city'],
//            'company_state' => $data['company_state'],
//            'company_title' => $data['company_title'],
//            'skype' => $data['skype'],
//            'whatsapp' => $data['whatsapp'],
        ]);
    }
}
