<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    // Define class-level private variables
    private $clientId;
    private $appSecret;
    private $baseURL;

    // Constructor initializes the environment variables
    public function __construct()
    {
        $this->clientId = env('PAYPAL_CLIENT_ID', '');  // Get PayPal client ID from .env
        $this->appSecret = env('PAYPAL_APP_SECRET', '');  // Get PayPal app secret from .env
//        $this->baseURL = env('PAYPAL_MODE') === 'sandbox'
//            ? 'https://api-m.sandbox.paypal.com'
//            : 'https://api-m.paypal.com';  // Determine if we are using PayPal sandbox or production

        $this->baseURL ='https://api-m.paypal.com';
    }

    // Function to display the PayPal payment form (Blade view)

    // Function to initiate a new PayPal order
//    public function createOrder(User $user, Request $request)
//    {
//        $src = null;
//        if (session()->has('url_next')) {
//            $src = session()->get('url_next');
//        }
//        $price = getPriceFromCredit(Settings::first()->amount,$request->credit) ;
//        $accessToken = $this->generateAccessToken();  // Get access token for PayPal API authentication
//        $url = "{$this->baseURL}/v2/checkout/orders";  // Endpoint URL for creating an order
//        // Initialize cURL session
//        $ch = curl_init($url);
//
//        // Set cURL options
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, [
//            'Content-Type: application/json',
//            'Authorization: Bearer ' . $accessToken
//        ]);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
//            'intent' => 'CAPTURE',
//
//            'purchase_units' => [
//                [
//                    'amount' => [
//                        'currency_code' => 'USD',
//                        'value' => $price
//                    ]
//                ]
//            ],
//            "payment_source"=> [
//        "paypal"=>[
//            "experience_context"=> [
//                "payment_method_preference"=> "IMMEDIATE_PAYMENT_REQUIRED",
//        "brand_name"=> "PRONTO",
//        "locale"=> "en-US",
//        "landing_page"=> "LOGIN",
//
//        "user_action"=> "PAY_NOW",
//        "return_url"=> route('student.confrim-paypal-order',['user'=>$user->id,'amount'=>$price]),
//        "cancel_url"=> route('student.paypal.cancel')
//     ]
//    ]
//                ]
//        ]));
//
//        // Execute cURL session and close it
//        $response = curl_exec($ch);
//        curl_close($ch);
//
//
//
//
//
//
//
//
//
//        // Decode the JSON response
//        $order = json_decode($response, true);
//
//
//
//        // Loop through the order links to find the "approve" link
//
//        foreach ($order['links'] as $link) {
//
//            if ($link['rel'] == 'payer-action') {
//
//                // Return the approve link
//                return response()->json(['url' => $link['href']]);
//            }
//        }
//
//        // If "approve" link is not found, return an error
//        return response()->json(['error' => 'Approve link not found'], 500);
//    }
//    public function confrimOrder(Request $request,User $user,$price)
//    {
//
//
//
//
//
//
//
//
//
//        $accessToken = $this->generateAccessToken();  // Get access token for PayPal API authentication
//        $url = "{$this->baseURL}/v2/checkout/orders/{$request->token}/confirm-payment-source";  // Endpoint URL for creating an order
//
//
//
//
//
//        // Initialize cURL session
//        $ch = curl_init($url);
//
//        // Set cURL options
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, [
//            'Content-Type: application/json',
//            'Authorization: Bearer ' . $accessToken
//        ]);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
//
//            "payment_source"=> [
//                "paypal"=>[
//                    "name"=>[
//        "given_name"=> $user->first_name,
//        "surname"=>  $user->last_name,
//      ],
//                    'email'=>$user->email,
//                    "experience_context"=> [
//                        "payment_method_preference"=> "IMMEDIATE_PAYMENT_REQUIRED",
//                        "brand_name"=> "PRONTO",
//                        "locale"=> "en-US",
//                        "landing_page"=> "LOGIN",
//                        "user_action"=> "PAY_NOW",
//                        "return_url"=> route('student.paypal.verify',['user'=>$user->id,'amount'=>$price]),
//                        "cancel_url"=> route('student.paypal.cancel')
//                    ]
//                ]
//            ]
//        ]));
//
//        // Execute cURL session and close it
//        $response = curl_exec($ch);
//        curl_close($ch);
//
//
//
//
//
//
//
//
//
//        // Decode the JSON response
//        $order = json_decode($response, true);
//
//
//
//        // Loop through the order links to find the "approve" link
//
//        foreach ($order['links'] as $link) {
//
//            if ($link['rel'] == 'payer-action') {
//
//                // Return the approve link
//                return redirect()->to($link['href']);
//            }
//        }
//
//        // If "approve" link is not found, return an error
//        return response()->json(['error' => 'Approve link not found'], 500);
//    }

    // Function to get the access token for PayPal API authentication
    private function generateAccessToken()
    {
        // Encode client ID and app secret for basic authentication
        $auth = base64_encode($this->clientId . ':' . $this->appSecret);

        // Endpoint URL for getting the access token
        $url = "{$this->baseURL}/v1/oauth2/token";

        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $auth
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');

        // Execute cURL session and close it
        $response = curl_exec($ch);
        curl_close($ch);


        // Decode the JSON response
        $data = json_decode($response, true);


        // Return the access token
        return $data['access_token'];
    }



    public function payment(Request $request)
    {
        dd($request->all());
        $src = null;
        if (session()->has('url_next')) {
            $src = session()->get('url_next');
        }
        $price = getPriceFromCredit(Settings::first()->amount,$request->credit) ;

        $accessToken = $this->generateAccessToken();  // Get access token for PayPal API authentication

        $url = "{$this->baseURL}/v1/payments/payment";  // Endpoint URL for creating an order
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'intent' => 'sale',
            "payer"=> [
                "payment_method"=>"paypal"
            ],

            'transactions' => [
                [
                    'amount' => [
                        'currency' => 'USD',
                        'total' => $price
                    ]
                ]
            ],
            'redirect_urls'=>[
                "return_url"=> route('student.paypal.verify',['user'=>$user->id,'amount'=>$price]),
                "cancel_url"=> route('student.paypal.cancel')
            ]
        ]));

        // Execute cURL session and close it
        $response = curl_exec($ch);
        curl_close($ch);
        // Decode the JSON response
        $response = json_decode($response, true);





        // Loop through the order links to find the "approve" link

        foreach ($response['links'] as $link) {

            if ($link['rel'] == 'approval_url') {

                // Return the approve link
                return response()->json(['url' => $link['href']]);
            }
        }
    }
    public function cancel(Request $request)
    {

        alert()->error('Cancelled');
        return redirect()->back();
    }


    public function verify(Request $request,User $user,$amount)
    {
        $accessToken = $this->generateAccessToken();  // Get access token for PayPal API authentication

        $url = "{$this->baseURL}/v1/payments/payment/{$request->paymentId}/execute";  // Endpoint URL for creating an order


        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'payer_id' => $request->PayerID
        ]));

        // Execute cURL session and close it
        $response = curl_exec($ch);
        curl_close($ch);
        // Decode the JSON response
        $response = json_decode($response, true);


        if($response['state'] =='approved'){
            try {
                $transaction =[
                    'user_id' => $user->id,
                    'amount'=>$amount,
                    'type_id'=>1,
                    'token' => $request->token,
                    'PayerID' => $request->PayerID,
                    'increase'=>1,

                ];
                $credit = convertPriceToCredit(Settings::first()->amount,$amount);

                $user->increase($credit,$transaction);

                alert()->success('Your account has been charged successfully');


                return redirect()->to(session('url_previous'));




            }catch (\Exception $e) {
                Log::error($e->getMessage().'Line:'.$e->getLine());
                alert()->error('Error For Verifying');
                return redirect()->back();
            }
        }
    }
}
