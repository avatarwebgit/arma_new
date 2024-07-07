<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\AdminChangeStatusUserJob;
use App\Models\Commodity;
use App\Models\CompanyFunction;
use App\Models\Country;
use App\Models\MailMessages;
use App\Models\Permission;
use App\Models\Refund;
use App\Models\RefundStatus;
use App\Models\Role;
use App\Models\Salutation;
use App\Models\Transaction;
use App\Models\Type;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($type)
    {

        if ($type == 'all') {
            $users = User::latest()->paginate(100);
        } else {
            $users = User::where('active_status', $type)->paginate(100);
        }
        $user_status = UserStatus::where('id', $type)->pluck('title')->first();
        return view('admin.users.list', compact('users', 'type', 'user_status'));
    }

    public function remove(Request $request)
    {
        try {
            $item = User::findOrFail($request->id);
            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';
            session()->flash('success', $message);
            $type = 1;
        } catch (\Exception $exception) {
            session()->flash('failed', $exception->getMessage());
            $type = 0;
        }
        $alert = view('admin.sections.alert')->render();
        return response()->json([$type, $alert]);
    }

    public function edit($type, User $user)
    {
        $userStatus = UserStatus::whereIn('id', [0, 1, 2])->get();
        $user_status = UserStatus::where('id', $type)->pluck('title')->first();
        $messages = MailMessages::whereIn('id', [3, 4])->get();
        $userTypes = Type::all();
        $roles = Role::all();
        $permissions = Permission::all();
        $types = Type::where('id', '!=', 1)->get();
        $commodities = Commodity::all();
        $countries = Country::OrderBy('countryName', 'asc')->get();
        $companyFunction = CompanyFunction::all();
        $salutation = Salutation::all();
        return view('admin.users.edit', compact(
            'user',
            'type',
            'userStatus',
            'messages',
            'user_status',
            'userTypes',
            'permissions',
            'roles',
            'types',
            'commodities',
            'countries',
            'companyFunction',
            'salutation'
        ));
    }

    public function update_role(User $user, Request $request)
    {
        try {
            $user->syncRoles($request->role);
            $permissions = $request->except(['_token', 'role', 'can_bid']);
            $user->syncPermissions($permissions);
            if ($request->has('can_bid')) {
                $can_bid = 1;
            } else {
                $can_bid = 0;
            }
            $user->update(['can_bid' => $can_bid]);
            $message = 'The Item Has Been Updated Successfully';
            session()->flash('success', $message);
        } catch (\Exception $exception) {
            session()->flash('failed', $exception->getMessage());
        }
        return redirect()->back();
    }


    public function update(Request $request, $type, User $user)
    {

        $pre_active_status = $user->active_status;
        $active_status = $request->active_status;
        try {
            $user->update($request->all());
            if ($pre_active_status == 0) {
                if ($active_status == 1) {
                    $mail = MailMessages::where('id', 4)->first();
                    $title = $mail->title;
                    $text = $mail->text;
                    $password = $this->randomPassword();
                    $text = str_replace('{username}', $user->email, $text);
                    $text = str_replace('{password}', $password, $text);
                    $user->update(['password' => $password]);
                }
                if ($active_status == 2) {
                    $mail = MailMessages::where('id', 3)->first();
                    $title = $mail->title;
                    $text = $mail->text;
                }
                dispatch(new AdminChangeStatusUserJob($user, $title, $text, $request->note, $user->email));
            }
            $message = 'The Item Has Been Updated Successfully';
            session()->flash('success', $message);
        } catch (\Exception $exception) {
            session()->flash('failed', $exception->getMessage());
        }
        return redirect()->back();
    }

    public
    function reset_password(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required'
        ]);
        try {
            $new_password = $request->new_password;
            $user->update([
                'password' => Hash::make($new_password)
            ]);
            $message = 'New Password Generated Successfully';
            session()->flash('success', $message);
        } catch (\Exception $exception) {
            session()->flash('failed', $exception->getMessage());
        }
        return redirect()->back();
    }

    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@$%^&*()!#$%^&*()';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 20; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function sendMessage(Request $request, User $user)
    {
        try {
            $title = $request->title;
            $text = $request->message;
            dispatch(new AdminChangeStatusUserJob($user, $title, $text, '', $user->email));
            $message = 'Message Was Sent Successfully';
            session()->flash('success', $message);
        } catch (\Exception $exception) {
            session()->flash('failed', $exception->getMessage());
        }
        return redirect()->back();
    }

    public function refund_request()
    {
        $items = Refund::latest()->get();
        $status = RefundStatus::all();
        return view('admin.refund_request', compact('items', 'status'));
    }

    public function UpdateRefundStatus(Request $request)
    {
        try {
            $id = $request->id;
            $refund = Refund::where('id', $id)->first();

            $newStatus = $request->newStatus;
            $refund->update([
                'status' => $newStatus,
            ]);
            $create_wallet = $request->create_wallet;
            if ($create_wallet == 1) {
                $amount = $refund->amount;
                $user_id = $refund->user_id;
                $type = 0;
                $description = 'Decreased wallet for Refund ID:' . $id;
                Transaction::create([
                    'user_id' => $user_id,
                    'type' => $type,
                    'amount' => $amount,
                    'status' => 1,
                    'description' => $description,
                ]);
            }
            return response()->json([1, 'ok']);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }

    }

    public function get_user_information(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        $types = Type::where('id', '!=', 1)->get();
        $commodities = Commodity::all();
        $countries = Country::OrderBy('countryName', 'asc')->get();
        $companyFunction = CompanyFunction::all();
        $salutation = Salutation::all();
        $html = view('admin.sections.registration_field', compact('user', 'types', 'commodities', 'countries', 'companyFunction', 'salutation'))->render();
        return response()->json([1, $html]);
    }

    public function change_status(Request $request)
    {
        $user_id = $request->user_id;
        $new_status = $request->new_status;
        $user = User::where('id', $user_id)->first();
        $reject_reason = $user->reject_reason;
        if ($new_status == 3) {
            $reject_reason = $request->reason;
        }

        $user->update([
            'active_status' => $new_status,
            'reject_reason' => $reject_reason,
        ]);
        return response()->json([1, 'ok']);
    }

}
