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
use App\Models\UserActivationStatus;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    public function index($type)
    {
        $permission_groups = Permission::where('group', '!=', '0')->orderBy('priority', 'asc')->get()->groupby('group');
        $user_status = UserStatus::where('id', $type)->pluck('title')->first();
        $activation_status = UserActivationStatus::all();
        $countries = Country::OrderBy('countryName', 'asc')->get();

        if ($type == 'seller' or $type == 'buyer' or $type == 'Members' or $type == 'Representatives' or $type == 'Brokers') {
            $users = User::where('active_status', 2)->where('active', 1)->orderBy('updated_at', 'desc')->get();
            $ids = [];
            foreach ($users as $user) {
                if ($user->hasRole($type)) {
                    $ids[] = $user->id;
                }
            }
            $users = User::whereIn('id', $ids)->orderBy('created_at', 'desc')->paginate(100);
        } else {
            $users = User::where('active_status', $type)->orderBy('created_at', 'desc')->paginate(100);
            $user_ids = [];

            if ($type == 2) {
                $users = User::where('active_status', $type)->orderBy('created_at', 'desc')->get();

                foreach ($users as $key => $user) {
                    $role_count = $user->Roles()->count();
                    if ($role_count > 0) {
                        $users->forget($key);
                        continue;
                    }
                    $user_ids[] = $user->id;
                }
                $users = User::WhereIn('id', $user_ids)->orderBy('created_at', 'desc')->paginate(100);
            }
        }

        return view('admin.users.list', compact('users', 'type', 'user_status', 'activation_status', 'permission_groups', 'countries'));
    }

    public function users_status($status)
    {
        $users = User::where('active_status', 2)->where('active', $status)->orderBy('updated_at', 'desc')->paginate(100);
        $type = 4;
        $permission_groups = Permission::where('group', '!=', '0')->orderBy('priority', 'asc')->get()->groupby('group');
        $user_status = UserStatus::where('id', $type)->pluck('title')->first();
        $activation_status = UserActivationStatus::all();
        if ($status == 2) {
            $type = 'suspended';
        }
        if ($status == 3) {
            $type = 'blocked';
        }
        return view('admin.users.list', compact('users', 'type', 'user_status', 'activation_status', 'permission_groups'));
    }

    function edit_modal(Request $request)
    {
        try {
            $user = User::where('id', $request->user_id)->first();
            $user_permissions = $user->permissions;
            $email = explode('@', $user->email);
            $email_name = $email[0];
            $countries = Country::OrderBy('countryName', 'asc')->get();
            $permission_groups = Permission::where('group', '!=', '0')->orderBy('priority', 'asc')->get()->groupby('group');
            $html = view('admin.sections.edit_member_modal', compact('user', 'countries', 'permission_groups', 'email_name', 'user_permissions'))->render();
            return response()->json([1, $html]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }

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

    public function update_role(Request $request)
    {
        try {
            $user = User::where('id', $request->user_id)->first();
            if ($request->role == 1) {
                $role = 'admin';
            }
            if ($request->role == 2) {
                $role = 'seller';
                $initial = 'S';
            }
            if ($request->role == 3) {
                $role = 'buyer';
                $initial = 'B';
            }
            if ($request->role == 6) {
                $role = 'Brokers';
                $initial = 'B';
            }
            $USER_ID = $this->User_ID_Creator($initial, $user->id);
            $user->syncRoles($role);
//            $permissions = $request->except(['_token', 'role']);
//            $user->syncPermissions($permissions);
//            if ($request->has('can_bid')) {
//                $can_bid = 1;
//            } else {
//                $can_bid = 0;
//            }
            $password = Hash::make($request->password);
            $created_by = \auth()->id();
            $user->update([
                'user_id' => $USER_ID,
                'password' => $password,
                'created_by' => $created_by,
            ]);
            $message = 'The Item Updated Successfully';
            session()->flash('success', $message);
            return response()->json([1, 'ok']);
        } catch (\Exception $exception) {
            session()->flash('failed', $exception->getMessage());
            return response()->json([0, 'ok']);
        }

    }

    public function member_save(Request $request)
    {
        try {
            DB::beginTransaction();
            $email = $request->email;
            $company_country = $request->company_country;
            $email = $email . '@armaitimex.com';
            $password = Hash::make($request->new_password);
            $role = $request->role;
            $initial = mb_substr($role, 0, 1);
            $initial = strtoupper($initial);

            $user = User::create([
                'email' => $email,
                'password' => $password,
                'company_country' => $company_country,
                'active_status' => 2,
            ]);
            $user_id = $this->User_ID_Creator($initial, $user->id);
            $created_by = \auth()->id();
            $user->update([
                'user_id' => $user_id,
                'created_by' => $created_by,
            ]);
            $user->syncRoles($role);
            $permissions = $request->except(['_token', 'role', 'email', 'new_password', 'company_country']);
            $user->syncPermissions($permissions);
            $message = $role . ' Created successfully';
            DB::commit();
            session()->flash('success', $message);
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            session()->flash('error', $exception->getMessage());
            return redirect()->back();
        }

    }

    public function member_update(User $user, Request $request)
    {

        try {
            $email = $request->email_edit;
            $company_country = $request->company_country_edit;
            $email = $email . '@armaitimex.com';
            $role = $request->role;
            $initial = mb_substr($role, 0, 1);
            $initial = strtoupper($initial);

            $user->update([
                'email' => $email,
                'company_country' => $company_country,
                'active_status' => 2,
            ]);
            $user_id = $this->User_ID_Creator($initial, $user->id);
            $user->update([
                'user_id' => $user_id,
            ]);
            if ($request->new_password == null) {
                $password = Hash::make($request->new_password);
                $user->update([
                    'password' => $password,
                ]);
            }
            $user->syncRoles($role);
            $permissions = $request->except(['_token', '_method', 'role', 'email_edit', 'new_password', 'company_country_edit']);
            $user->syncPermissions($permissions);
            $message = $role . ' Updated successfully';
            DB::commit();
            session()->flash('success', $message);
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            session()->flash('error', $exception->getMessage());
            return redirect()->back();
        }

    }

    public function check_email_exist(Request $request)
    {
        $email = $request->email;
        $email = $email . '@armaitimex.com';
        $user_exists = User::where('email', $email)->first();
        if ($request->has('user_id')) {
            if ($user_exists->id == $request->user_id) {
                return 0;
            } else {
                return 1;
            }
        } else {
            if ($user_exists) {
                return 1;
            } else {
                return 0;
            }
        }

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

    function change_active_status(Request $request)
    {
        $user_id = $request->user_id;
        $status = $request->status;
        $reject_reason = $request->reject_reason;
        $user = User::where('id', $user_id)->first();
        $user->update([
            'active' => $status,
            'reject_reason' => $reject_reason,
        ]);
        return response()->json([1, 'ok']);
    }

    public function User_ID_Creator($initial, $user_id)
    {
        $number = 1000 + $user_id;
        $ID = 'Armx-' . $initial . $number;
        return $ID;
    }

}
