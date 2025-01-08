<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FormsDataTable;
use App\Facades\UtilityFacades;
use App\Events\SellerLinkedToMarket;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleFormRequest;
use App\Mail\FormSubmitEmail;
use App\Mail\Thanksmail;
use App\Models\AssignFormRole;
use App\Models\AssignFormsRoles;
use App\Models\AssignFormsUsers;
use App\Models\AssignFormUser;
use App\Models\CargoInsurance;
use App\Models\CompanyType;
use App\Models\ContactForm;
use App\Models\ContainerType;
use App\Models\ContractType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\FlexiTankType;
use App\Models\Form;
use App\Models\FormComments;
use App\Models\FormCommentsReply;
use App\Models\FormValue;
use App\Models\Incoterms;
use App\Models\IncotermsVersion;
use App\Models\InspectionPlace;
use App\Models\Market;
use App\Models\MarketPermission;
use App\Models\Packing;
use App\Models\PaymentTerm;
use App\Models\PlatFom;
use App\Models\PriceType;
use App\Models\QualityQuantityInspector;
use App\Models\SalesOfferForm;
use App\Models\SalesOfferFormCopy;
use App\Models\ShippingTerm;
use App\Models\TargetMarket;
use App\Models\THCIncluded;
use App\Models\ToleranceWeightBy;
use App\Models\Units;
use App\Models\User;
use App\Models\UserForm;
use App\Rules\CommaSeparatedEmails;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Spatie\Permission\Models\Role;
use function App\Http\Controllers\public_path;


class FormController extends Controller
{
    public function formStatus($id)
    {
        if (\Auth::user()->can('manage-form')) {
            $forms = Form::find($id);
            if ($forms->is_active == 1) {
                $forms->is_active = 0;
                $forms->save();
                return redirect()->back()->with('success', 'Form deactiveted successfully.');
            } else {
                $forms->is_active = 1;
                $forms->save();
                return redirect()->back()->with('success', 'Form Activeted Successfully.');
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function sale_form_list($type)
    {
        if ($type == 'Save') {
            $is_save = 1;
        }
        if ($type == 'Draft') {
            $is_save = 2;
        }
        $forms = SalesOfferForm::where('user_id', \auth()->id())->where('is_save', $is_save)->paginate(20);
        return view('admin.sales_form.sales_form_index', compact('forms', 'is_save', 'type'));
    }

    public function sale_forms($status)
    {
        $items = SalesOfferForm::where('status', $status)->where('form_id', '!=', null)->where('user_id', \auth()->id())->orderBy('created_at', 'desc')->paginate(100);
        return view('admin.sales_form.list', compact('items', 'status'));
    }

    public function sales_form($page_type = 'Create', $item = 'null')
    {
        $role = \auth()->user()->Roles()->first()->name;
//        session()->forget('form_id_exists');
        $sale_form_exist = 0;
        $previous_form_id = false;
        $route = route('sale_form.update_or_store');
        $form = [];
        if (isset($_GET['previous_form'])) {
            $sale_form_exist = 1;
            $form = SalesOfferForm::where('id', $_GET['previous_form'])->first();
        } else {
            $form_exist = SalesOfferForm::where('user_id', \auth()->id())->where('is_complete', 0)->where('is_save', 1)->exists();
            if ($form_exist) {
                $sale_form_exist = 1;
                $form = SalesOfferForm::where('user_id', \auth()->id())->where('is_complete', 0)->where('is_save', 1)->latest()->first();
            } else {

                $form_exist = SalesOfferForm::where('user_id', \auth()->id())->where('is_complete', 1)->first();
                if ($form_exist) {
                    $sale_form_exist = 0;
                    $form = SalesOfferForm::where('user_id', \auth()->id())->where('is_complete', 1)->latest()->first();
                    $previous_form_id = $form->id;
                    $form = [];
                }
            }
        }
        if ($page_type === 'Create') {
            $sale_form_exist = 0;
            $previous_form_id = false;
            $form = [];
        }
        if ($page_type === 'Edit') {
            $previous_form_id = false;
            $sale_form_exist = 1;
            $route = route('sale_form.update_or_store', ['item' => $item]);
            $form = SalesOfferForm::where('id', $item)->first();
        }
        if ($page_type === 'Save') {
            $previous_form_id = false;
            $sale_form_exist = 1;
            $route = route('sale_form.update_or_store', ['item' => $item]);
            $form = SalesOfferForm::where('user_id', \auth()->id())->where('is_complete', 0)->where('is_save', 1)->latest()->first();
            if (!$form) {
                dd('no form exists');
            } else {
                $item = $form->id;
                $route = route('sale_form.update_or_store', ['item' => $item]);
            }
        }
        if ($page_type === 'Draft') {
            $previous_form_id = false;
            $sale_form_exist = 1;
            $route = route('sale_form.update_or_store', ['item' => $item]);
            $form = SalesOfferForm::where('user_id', \auth()->id())->where('is_complete', 0)->where('is_save', 2)->latest()->first();
            if (!$form) {
                dd('no form exists');
            }
        }
        $company_types = CompanyType::all();
        $unites = Units::all();
        $currencies = Currency::all();
        $tolerance_weight_by = ToleranceWeightBy::all();
        $Incoterms = Incoterms::all();
        $incoterms_version = IncotermsVersion::all();
        $countries = Country::OrderBy('countryName', 'asc')->get();
        $priceTypes = PriceType::all();
        $paymentTerms = PaymentTerm::all();
        $packing = Packing::all();
        $shipping_terms = ShippingTerm::all();
        $container_types = ContainerType::all();
        $thcincluded = THCIncluded::all();
        $flexi_type_tank = FlexiTankType::all();
        $destination = Destination::all();
        $targetMarket = TargetMarket::all();
        $qualityQuantityInspector = QualityQuantityInspector::all();
        $InspectionPlace = InspectionPlace::all();
        $cargoInsurance = CargoInsurance::all();
        $contract_types = ContractType::all();
        $platforms = PlatFom::all();
        return view('admin.sales_form.create', compact(
            'sale_form_exist',
            'form',
            'route',
            'company_types',
            'unites',
            'currencies',
            'tolerance_weight_by',
            'Incoterms',
            'incoterms_version',
            'countries',
            'priceTypes',
            'paymentTerms',
            'packing',
            'container_types',
            'shipping_terms',
            'thcincluded',
            'flexi_type_tank',
            'destination',
            'targetMarket',
            'qualityQuantityInspector',
            'InspectionPlace',
            'cargoInsurance',
            'contract_types',
            'platforms',
            'item',
            'role',
            'previous_form_id'
        ));
    }

    public function sales_form_preparation($item, $folder = null)
    {
        $role = \auth()->user()->Roles()->first()->name;
        $previous_form_id = false;
        $sale_form_exist = 1;
        $route = route('sale_form.update_or_store', ['item' => $item, 'is_preparation' => 1]);
        $form = SalesOfferForm::where('id', $item)->first();
        $company_types = CompanyType::all();
        $unites = Units::all();
        $currencies = Currency::all();
        $tolerance_weight_by = ToleranceWeightBy::all();
        $Incoterms = Incoterms::all();
        $incoterms_version = IncotermsVersion::all();
        $countries = Country::OrderBy('countryName', 'asc')->get();
        $priceTypes = PriceType::all();
        $paymentTerms = PaymentTerm::all();
        $packing = Packing::all();
        $shipping_terms = ShippingTerm::all();
        $container_types = ContainerType::all();
        $thcincluded = THCIncluded::all();
        $flexi_type_tank = FlexiTankType::all();
        $destination = Destination::all();
        $targetMarket = TargetMarket::all();
        $qualityQuantityInspector = QualityQuantityInspector::all();
        $InspectionPlace = InspectionPlace::all();
        $cargoInsurance = CargoInsurance::all();
        $contract_types = ContractType::all();
        $platforms = PlatFom::all();
        return view('admin.sales_form_preparation', compact(
            'sale_form_exist',
            'form',
            'route',
            'company_types',
            'unites',
            'currencies',
            'tolerance_weight_by',
            'Incoterms',
            'incoterms_version',
            'countries',
            'priceTypes',
            'paymentTerms',
            'packing',
            'container_types',
            'shipping_terms',
            'thcincluded',
            'flexi_type_tank',
            'destination',
            'targetMarket',
            'qualityQuantityInspector',
            'InspectionPlace',
            'cargoInsurance',
            'contract_types',
            'platforms',
            'item',
            'role',
            'previous_form_id',
            'folder'
        ));
    }

    public function sales_form_preparation_store(Request $request, $form_id)
    {

        $form_type = $request->form_type;

        $request->validate([
            'term_conditions' => 'required|min:400',
        ]);


        $status = 5;
        if ($form_type == 'save') {
            $status = 6;
        }
        try {
            $term_conditions = $request->term_conditions;
            $files = ['specification_file', 'picture_packing_file', 'quality_inspection_report_file', 'safety_product_file', 'reach_certificate_file'];
            $env = env('SALE_OFFER_FORM');
            $sale_form = SalesOfferForm::where('id', $form_id)->first();
            if ($form_type == 'Edit') {
                $status = $sale_form->status;
            }

            $array = [
                'status' => $status,
                'created_by' => \auth()->id()
            ];
            foreach ($files as $file) {
                if ($request->has($file)) {
                    $path = \public_path($env . '/' . $sale_form[$file]);
                    if (isset($path) and !is_dir($path)) {
                        unlink($path);
                    }
                    $file_name = $this->Upload_files($env, $request[$file]);
                } else {
                    $file_name = $sale_form[$file];
                }
                $array[$file] = $file_name;
            }

            $array['term_conditions'] = $term_conditions;
            $sale_form->update($array);
            session()->flash('success', 'Your Information has been saved successfully');
            session()->flash('contact-tab', 'ok');
            if ($form_type == 'save') {
//                return redirect()->route('sale_form.preparation', ['item' => $sale_form->id]);
                return redirect()->back();
            } else {
                return redirect()->route('admin.sales_form.fifth.index', ['status' => 5]);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }


    }

    public function sales_form_preparation_remove_file(Request $request)
    {
        try {
            $env = env('SALE_OFFER_FORM');
            $form_id = $request->id;
            $file = $request->file_name;
            $sale_form = SalesOfferForm::where('id', $form_id)->first();
            $path = \public_path($env . '/' . $sale_form[$file]);
            if (isset($path) and !is_dir($path) and file_exists($path)) {
                unlink($path);
            }
            $sale_form->update([
                $file => null
            ]);
            session()->flash('contact-tab', 'ok');
            return response()->json([1, 'ok']);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function sales_form_update_or_store(Request $request, $item = null, $is_preparation = null)
    {
        $is_complete = 0;
        $rules = $this->rules($item, $request);
        $validator = Validator::make($request->all(), $rules);

        if ($request->is_save == 2) {
            $save = 0;
        } else {
            $save = $request->is_save;
        }
        if ($validator->passes()) {
            $is_complete = 1;
            $save = $request->is_save;
        }
//        if ($item != null) {
//            $pre_form = SalesOfferForm::where('id', $item)->first();
//            $save = $pre_form->is_save;
//        }


        $validate_items = $validator->valid();

        $validate_items = collect($validate_items);
        $env = env('SALE_OFFER_FORM');
        $files = ['specification_file', 'picture_packing_file', 'quality_inspection_report_file', 'safety_product_file', 'reach_certificate_file'];
        foreach ($files as $file) {
            if ($validate_items->has($file)) {
                if ($validate_items->has('form_id')) {
                    $path = public_path($env, $file);
                    unlink($path);
                }
                $file_name = $this->Upload_files($env, $validate_items[$file]);
            } else {
                if ($item != null) {
                    //is_update
                    $form = SalesOfferForm::where('id', $item)->first();
                    $file_name = $form[$file];
                } else {
                    $file_name = '';
                }

            }
            $validate_items[$file] = $file_name;
        }

        $has_loading = $validate_items->has('has_loading') ? 1 : 0;
        $accept_terms = $validate_items->has('accept_terms') ? 1 : 0;
        $user_id = \auth()->id();
        $validate_items['user_id'] = $user_id;
        $validate_items['has_loading'] = $has_loading;
        $validate_items['accept_terms'] = $accept_terms;
        $validate_items['is_complete'] = $is_complete;
        $validate_items['is_save'] = $save;
        $validate_items['status'] = 1;

        if ($item != null) {
            $sale_form = SalesOfferForm::where('id', $item)->first();
            $validate_items['user_id'] = $sale_form->user_id;
            if ($sale_form->unique_number == null) {
                $unique_number = 'Arma-' . $sale_form->id;
                $validate_items['unique_number'] = $unique_number;
            }
            if (count($validator->errors()) > 0) {
                $validate_items['is_save'] = $sale_form->is_save;
            }
            $sale_form->update($validate_items->except('_token')->all());
            if ($request->has('status')) {
                $sale_form->update([
                    'status' => 6
                ]);
            }
            if ($is_complete == 1) {
                session()->flash('need_submit', 1);
            }
            if ($save == 1) {
//                $user_forms = SalesOfferForm::where('user_id', $sale_form->user_id)->where('id', '!=', $sale_form->id)->get();
//                foreach ($user_forms as $user_form) {
//                    $user_form->update(['is_save' => 0]);
//                }
                session()->flash('success', 'Your Information has been saved successfully');
//                return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id]);
                return redirect()->route('sale_form_list', ['type' => 'Save']);
            }
            if (count($validator->errors()) > 0) {
//                return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id])->withErrors($validator->errors());
                return redirect()->back()->withErrors($validator->errors());
            }
            if ($save == 2) {
                session()->flash('success', 'Your Information has been Draft successfully');
                return redirect()->route('sale_form_list', ['type' => 'Draft']);
            }
            return redirect()->back()->with('success', 'updated successfully');

        } else {

            $sale_form = SalesOfferForm::create($validate_items->except('_token')->all());
            $sale_form_id = $sale_form->id;
            $unique_number = 'Arma-' . $sale_form_id;
            $sale_form->update(['unique_number', $unique_number]);

            if ($is_complete == 1) {
                session()->flash('need_submit', 1);
            }

            if ($save == 1) {
//                $user_forms = SalesOfferForm::where('user_id', $sale_form->user_id)->where('id', '!=', $sale_form->id)->get();
//                foreach ($user_forms as $user_form) {
//                    $user_form->update(['is_save' => 0]);
//                }
                session()->flash('success', 'Your Information has been saved successfully');

//                return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id]);
                return redirect()->route('sale_form_list', ['type' => 'Save']);
            }

            if (count($validator->errors()) > 0) {
                return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id])->withErrors($validator->errors());
            }

            if ($save == 2) {
                session()->flash('success', 'Your Information has been Draft successfully');
                return redirect()->route('sale_form_list', ['type' => 'Draft']);
            }
        }

        session()->flash('success', 'Your Information has been saved successfully');
        if ($is_preparation == null) {
            return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id]);
        }
        return redirect()->route('sale_form.preparation', ['item' => $sale_form->id]);

    }

    public function Upload_files($env, $file)
    {
        $fileNamePrimaryImage = generateFileName($file->getClientOriginalName());
        $file->move(\public_path($env), $fileNamePrimaryImage);
        return $fileNamePrimaryImage;
    }

    public function sales_form_index($status)
    {
        $items = SalesOfferForm::where('status', $status)->where('form_id', '!=', null)->where('used_in_market', 0)->orderBy('created_at', 'desc')->paginate(100);

//        $rows=$items[0]->toArray();

        return view('admin.sales_form.list', compact('items', 'status'));
    }

    public function sales_form_remove(Request $request)
    {
        $id = $request->id;
        $sales_form = SalesOfferForm::where('id', $id)->first();
        $sales_form->delete();
        $sales_form_copy = SalesOfferFormCopy::where('id', $id)->first();
        if ($sales_form_copy) {
            $sales_form_copy->delete();
        }

        session()->flash('success', 'Your Item Deleted Successfully');
        return response()->json([1]);
    }

    public function sales_form_copy(Request $request)
    {
        try {
            $form_id = $request->form_id;
            $form = SalesOfferForm::where('id', $form_id)->first();
            SalesOfferForm::create($form->toArray());
            return response()->json([1,'ok']);
        }catch (\Exception $e) {
            return response()->json([0,$e->getMessage()]);
        }

    }

    public function Final_Submit(Request $request)
    {
        try {
            $id = $request->id;
            $sales_form = SalesOfferForm::where('id', $id)->first();
            $form_id = 'Armx-So' . $sales_form->id;
            $sales_form->update([
                'status' => 1,
                'form_id' => $form_id,
            ]);
            $role = auth()->user()->Roles()->first()->name;
            if ($role == 'seller') {
                $rote = route('seller.requests');
            } else {
                $rote = route('admin.sales_form.first.index', ['status' => 1]);
            }
            return response()->json([1, $rote]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }

    }

    public function sales_form_show(SalesOfferForm $id)
    {
        $role = \auth()->user()->Roles()->first()->name;
        $sale_form_exist = 1;
        $form = $id;
        $route = route('sale_form.update_or_store');
        $company_types = CompanyType::all();
        $unites = Units::all();
        $currencies = Currency::all();
        $tolerance_weight_by = ToleranceWeightBy::all();
        $Incoterms = Incoterms::all();
        $incoterms_version = IncotermsVersion::all();
        $countries = Country::OrderBy('countryName', 'asc')->get();
        $priceTypes = PriceType::all();
        $paymentTerms = PaymentTerm::all();
        $packing = Packing::all();
        $shipping_terms = ShippingTerm::all();
        $container_types = ContainerType::all();
        $thcincluded = THCIncluded::all();
        $flexi_type_tank = FlexiTankType::all();
        $destination = Destination::all();
        $targetMarket = TargetMarket::all();
        $qualityQuantityInspector = QualityQuantityInspector::all();
        $InspectionPlace = InspectionPlace::all();
        $cargoInsurance = CargoInsurance::all();
        $contract_types = ContainerType::all();
        $item = null;
        $is_show = 1;
        $platforms = PlatFom::all();
        return view('admin.sales_form.create', compact(
            'sale_form_exist',
            'form',
            'route',
            'company_types',
            'unites',
            'currencies',
            'tolerance_weight_by',
            'Incoterms',
            'incoterms_version',
            'countries',
            'priceTypes',
            'paymentTerms',
            'packing',
            'container_types',
            'shipping_terms',
            'thcincluded',
            'flexi_type_tank',
            'destination',
            'targetMarket',
            'qualityQuantityInspector',
            'InspectionPlace',
            'cargoInsurance',
            'contract_types',
            'item',
            'is_show',
            'role',
            'platforms'
        ));
    }

    public function sales_form_edit(SalesOfferForm $id)
    {
        $role = \auth()->user()->Roles()->first()->name;
        $sale_form_exist = 1;
        $form = $id;
        $route = route('sale_form.update_or_store', ['item' => $form]);
        $company_types = CompanyType::all();
        $unites = Units::all();
        $currencies = Currency::all();
        $tolerance_weight_by = ToleranceWeightBy::all();
        $Incoterms = Incoterms::all();
        $incoterms_version = IncotermsVersion::all();
        $countries = Country::OrderBy('countryName', 'asc')->get();
        $priceTypes = PriceType::all();
        $paymentTerms = PaymentTerm::all();
        $packing = Packing::all();
        $shipping_terms = ShippingTerm::all();
        $container_types = ContainerType::all();
        $thcincluded = THCIncluded::all();
        $flexi_type_tank = FlexiTankType::all();
        $destination = Destination::all();
        $targetMarket = TargetMarket::all();
        $qualityQuantityInspector = QualityQuantityInspector::all();
        $InspectionPlace = InspectionPlace::all();
        $cargoInsurance = CargoInsurance::all();
        $contract_types = ContainerType::all();
        $item = null;
        $is_show = 0;
        $platforms = PlatFom::all();
        return view('admin.sales_form.create', compact(
            'sale_form_exist',
            'form',
            'route',
            'company_types',
            'unites',
            'currencies',
            'tolerance_weight_by',
            'Incoterms',
            'incoterms_version',
            'countries',
            'priceTypes',
            'paymentTerms',
            'packing',
            'container_types',
            'shipping_terms',
            'thcincluded',
            'flexi_type_tank',
            'destination',
            'targetMarket',
            'qualityQuantityInspector',
            'InspectionPlace',
            'cargoInsurance',
            'contract_types',
            'item',
            'is_show',
            'role',
            'platforms'
        ));
    }

    public function change_status(Request $request)
    {
        try {
            $new_status = $request->status_id;
            $has_deposit = $request->has_deposit;
            $deposit_value = $request->deposit_value;
            $currency = $request->currency;
            $message = $request->message;
            if ($new_status == 5) {
                if ($has_deposit == 0) {
                    $new_status = 6;
                } else {
                    $new_status = 2;
                    $message = 'You Need To Charge Your Wallet Up To :' . $deposit_value . '( ' . $currency . ' )';
                }
            }
            $form_id = $request->form_id;
            $sale_form = SalesOfferForm::where('id', $form_id)->first();
            $created_by = \auth()->id();
            $sale_form->update([
                'status' => $new_status,
                'has_deposit' => $has_deposit,
                'deposit_value' => $deposit_value,
                'data_pending_message' => $message,
                'cash_pending_currency' => $currency,
                'created_by' => $created_by,
            ]);
//            if ($new_status == 5) {
//                SalesOfferFormCopy::create($sale_form->toArray());
//            }
            $route = '';
            if ($new_status == 4) {
                $route = route('admin.sales_form.forth.index', ['status' => 4]);
            }
            if ($new_status == 3) {
                $route = route('admin.sales_form.third.index', ['status' => 3]);
            }
            if ($new_status == 6) {
                $route = route('admin.sales_form.sixth.index', ['status' => 6]);
            }
            if ($new_status == 2) {
                $route = route('admin.sales_form.second.index', ['status' => 2]);
            }
            session()->flash('success', 'Successfully Updated');
            return response()->json([1, 'success', $route], 200);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }
    }

    public function sale_form_permission($item)
    {
        $role_ids = [];
        $user_ids = [];
        $market_id = $item;
        $customOrder = ['buyer', 'Members', 'Brokers', 'Representatives', 'seller'];
        $roles = Role::where('name', '!=', 'admin')
            ->orderByRaw("FIELD(name, '" . implode("', '", $customOrder) . "') ASC")
            ->get();
        $market = Market::where('id', $market_id)->first();
        $market_permission = MarketPermission::where('market_id', $market_id)->first();
        if (!$market_permission) {
            $market_permission = MarketPermission::create([
                'market_id' => $market_id,
            ]);
        }
        if ($market_permission->user_ids != null) {
            $user_ids = unserialize($market_permission->user_ids);
        }

        if ($market_permission->role_ids != null) {
            if ($market_permission->role_ids == "[]") {
                $role_ids = [];
            } else {
                $role_ids = unserialize($market_permission->role_ids);
            }

        }
        $users = User::whereIn('id', $user_ids)->where('user_id', '!=', null)->get();
        $all_users = User::all();
        return view('admin.markets.permission',
            compact('market_id',
                'roles',
                'market_permission',
                'market',
                'users',
                'role_ids',
                'all_users'
            ));
    }

    function sale_form_permission_store_roles(Request $request)
    {
        try {
            $market_id = $request->market_id;
            $marketPermission = MarketPermission::where('market_id', $market_id)->first();
            $role_ids = $request->role_ids;
            $user_ids = [];
            if ($role_ids == null) {
                $role_ids = [];
            }
            foreach ($role_ids as $role) {
                $role = Role::where('id', $role)->first();
                $users = $role->users()->where('active', 1)->get();
                foreach ($users as $user) {
                    $user_ids[] = $user->id;
                }
            }

            if ($role_ids != null) {
                $role_ids = serialize($role_ids);
            }
//            if ($marketPermission->user_ids != null) {
//                $market_user_ids = unserialize($marketPermission->user_ids);
//                foreach ($market_user_ids as $market_user_id) {
//                    $user_ids[] = $market_user_id;
//                }
//            }
            $user_ids = array_unique($user_ids);
            $user_ids = serialize($user_ids);

            $marketPermission->update([
                'role_ids' => $role_ids,
                'user_ids' => $user_ids,
            ]);

            $users = User::whereIn('id', unserialize($user_ids))->where('active', 1)->get();
            $market = Market::where('id', $market_id)->first();
            $view_html = view('admin.markets.permission_users', compact('users', 'market', 'market_id'))->render();
            return response()->json([1, $view_html]);
        } catch (\Exception $exception) {
            return response()->json([0, $exception->getMessage()]);
        }
    }

    public function user_permission(Request $request)
    {
        $usersType = $request->user_type;
        $role = Role::find($usersType);

        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role not found'], 404);
        }

        // شروع جستجوی کاربران با نقش مشخص
        $query = $role->users()->where('active', 1);

        // اضافه کردن شروط به کوئری در صورت وجود
        if ($request->user_name) {
            $query->where('full_name', 'like', '%' . $request->user_name . '%');
        }

        if ($request->user_email) {
            $query->where('email', 'like', '%' . $request->user_email . '%');
        }

        if ($request->user_company) {
            $query->where('company_name', 'like', '%' . $request->user_company . '%');
        }

        // اجرای کوئری و دریافت نتایج
        $users = $query->get();

        return response()->json(['success' => true, 'data' => $users]);
    }


    function sale_form_permission_store_ids(Request $request)
    {

        try {
            $market_id = $request->market_id;
            $market = MarketPermission::where('market_id', $market_id)->first(); // استفاده از findOrFail به‌جای where و first
            $market_user_ids = $market->user_ids ? unserialize($market->user_ids) : [];
            // افزودن شناسه کاربر جدید و حذف تکراری‌ها
            $ids = $request->ids;
            foreach ($ids as $id) {
                $market_user_ids[] = $id; // فرض می‌کنیم user_id از درخواست وجود دارد
            }
            $unique_user_ids = array_unique($market_user_ids);
            // به‌روزرسانی شناسه‌های کاربران
            $market->user_ids = serialize($unique_user_ids);
            $market->save();
event(new SellerLinkedToMarket($market_id, $market->user_ids));

            return response()->json([1, 'ok']);
        } catch (\Exception $exception) {
            return response()->json([0, $exception->getMessage()]);
        }
    }


    function marketPermissionRemove($user, $market)
    {

        $marketPermission = MarketPermission::where('market_id', $market)->first();
        $user_ids = unserialize($marketPermission->user_ids);
        // Search
        $index = array_search($user, $user_ids);
        if ($index !== false) {
            // Remove from array
            unset($user_ids[$index]);
        }
        if (count($user_ids) == 0) {
            $user_ids = null;
        } else {
            $user_ids = serialize($user_ids);
        }
        $marketPermission->update([
            'user_ids' => $user_ids
        ]);
event(new SellerLinkedToMarket($market, $user_ids));
        return redirect()->back();
    }

    public function UpdateCashPending(Request $request)
    {
        try {
            $id = $request->id;
            $amount = $request->amount;
            $currency = $request->currency;
            $sale_form = SalesOfferForm::where('id', $id)->first();
            $message = 'You Need To Charge Your Wallet Up To :' . $amount . '( ' . $currency . ' )';
            $sale_form->update([
                'deposit_value' => $amount,
                'cash_pending_currency' => $currency,
                'data_pending_message' => $message,
            ]);
//            if ($new_status == 5) {
//                SalesOfferFormCopy::create($sale_form->toArray());
//            }
            session()->flash('success', 'Successfully Updated');
            return response()->json([1, 'success'], 200);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }
    }

    public function rules($item, $request)
    {
        $rules = [
            //company
            'company_name' => 'required',
            'company_type' => 'required',
            //unit and currency
            'unit' => 'required',
            'unit_other' => ['required_if:unit,other'],
            'currency' => 'required',
            'currency_other' => ['required_if:currency,other'],
            //contract type
            'contract_type' => 'required',
            'contract_type_other' => ['required_if:contract_type,other|required_if:contract_type,Contract'],
            //
            'commodity' => 'required',
            'type_grade' => 'nullable',
            'hs_code' => 'nullable',
            'cas_no' => 'nullable',
            'product_more_details' => 'nullable',
            'specification' => 'nullable',
            //file
            'quality_inspection_report' => 'required',
            //file
            'max_quantity' => 'required',
            'min_order' => 'required',
            'tolerance_weight' => 'nullable',
            'tolerance_weight_by' => 'nullable',
            'partial_shipment' => 'nullable',
            'partial_shipment_number' => ['required_if:partial_shipment,Yes'],
            'transshipment' => 'required',
            'transshipment_other' => ['required_if:transshipment,Yes'],

//            'increase_quantity' => 'nullable',
//            'increase_quantity_value' => ['required_if:increase_quantity,Yes'],

            'shipment_more_detail' => 'nullable',
            'incoterms' => 'required',
            'incoterms_other' => ['required_if:incoterms,other'],
            'incoterms_version' => 'nullable',
            'country' => 'required',
            'port_city' => 'required',
            'incoterms_more_detail' => 'nullable',
            //price
            'price_type' => 'required',
            'formulla' => ['required_if:price_type,Formulla'],
            'Operator' => ['required_if:price_type,Formulla'],
            'alpha' => ['required_if:price_type,Formulla'],
            'formulla_more_details' => ['nullable'],
            'base_price_notes' => ['nullable'],
            'price' => ['required_if:price_type,Fix'],
            'payment_count' => 'required',
            'payment_options' => ['required_if:payment_count,No'],
            'lc_term_and_conditions' => $request->has('lc') ? 'required' : 'nullable',
            'oa_term_and_conditions' => $request->has('oa') ? 'required' : 'nullable',
            'tt_term_and_conditions' => $request->has('tt') ? 'required' : 'nullable',
            'dp_term_and_conditions' => $request->has('dp') ? 'required' : 'nullable',
            'da_term_and_conditions' => $request->has('da') ? 'required' : 'nullable',
            'paypal_term_and_conditions' => $request->has('paypal') ? 'required' : 'nullable',
            'western_union_term_and_conditions' => $request->has('western_union') ? 'required' : 'nullable',
            'moneygram_term_and_conditions' => $request->has('moneygram') ? 'required' : 'nullable',
            'other_payment_term_and_conditions' => $request->has('other_payment') ? 'required' : 'nullable',
//            'payment_term' => 'required',
//            'payment_term_description' => 'required',
            'packing' => 'required',
            'packing_more_details' => 'nullable',
            'packing_other' => ['required_if:packing,other'],
            'marking_more_details' => 'nullable',
            'picture_packing' => 'nullable',
            //file
            'possible_buyers' => 'nullable',
            'cost_per_unit' => ['required_if:possible_buyers,Yes'],
            'origin_country' => 'required',
            'origin_port_city' => 'nullable',
            'origin_more_details' => 'nullable',
            //loading
            'has_loading' => 'nullable',
            'loading_type' => ['required_if:has_loading,1'],
            'loading_country' => ['required_unless:loading_type,null'],
            'loading_port_city' => ['required_unless:loading_type,null'],
//            'loading_from' => ['required_unless:loading_type,null'],
//            'loading_to' => ['required_unless:loading_type,null'],
            'loading_from' => ['required_if:period,null'],
            'loading_to' => ['required_if:period,null'],
            'period' => ['required_if:loading_to,null'],
            'bulk_loading_rate' => 'nullable|integer',
            'loading_bulk_shipping_term' => 'nullable',
            'loading_container_type' => 'nullable',
            'loading_container_thc_included' => 'nullable',
            'loading_flexi_tank_type' => ['required_if:loading_type,Flexi Tank'],
            'loading_flexi_tank_thc_included' => 'nullable',
            'loading_more_details' => 'nullable',
            //discharging
            'has_discharging' => 'nullable',
            'discharging_type' => ['required_if:has_discharging,1'],
            'discharging_country' => ['required_unless:discharging_type,null'],
            'discharging_port_city' => ['required_unless:discharging_type,null'],
//            'discharging_from' => ['required_unless:discharging_type,null'],
//            'discharging_to' => ['required_unless:discharging_type,null'],
            'bulk_discharging_rate' => 'nullable|integer',
            'discharging_bulk_shipping_term' => 'nullable',
            'discharging_container_type' => 'nullable',
            'discharging_container_thc_included' => 'nullable',
            'discharging_flexi_tank_type' => ['required_if:discharging_type,Flexi Tank'],
            'discharging_flexi_tank_thc_included' => 'nullable',
            'discharging_more_details' => 'nullable',
            //destination
            'destination' => 'required',
            'exclude_market' => ['required_unless:destination,Open'],
            'target_market' => 'nullable',
            //inspection
            'quality_quantity_inspection' => 'required',
            'inspection_place' => 'required',
            'inspection_more_detail' => 'nullable',
            //insurance
            'cargo_insurance' => 'nullable',
            'insurance_more_details' => 'nullable',
            //safety
            'safety_product' => 'required',
            //file
            //reach certificate
            'reach_certificate' => 'required',
            //file
            //documents
            'documents_count' => 'required',
            'documents_options' => ['required_if:documents_count,No'],
            'document_more_detail' => 'nullable',
            'term_conditions' => 'required|min:400',
            //contact person
            'contact_person_name' => 'required',
            'contact_person_job_title' => 'required',
            'contact_person_email' => 'required',
            'pre_code' => 'required|max:6',
            'contact_person_mobile_phone' => 'required',
            'platform' => 'required',
            //last part
            'last_more_detail' => 'nullable',
            'accept_terms' => 'required',
        ];

        if ($item != null) {
            //is_update
            $form = SalesOfferForm::where('id', $item)->first();
            $specification_file = $form['specification_file'];
            $quality_inspection_report_file = $form['quality_inspection_report_file'];
            $picture_packing_file = $form['picture_packing_file'];
            $safety_product_file = $form['safety_product_file'];
            $reach_certificate_file = $form['reach_certificate_file'];
            //
            if ($specification_file == null) {
                $rules += [
                    'specification_file' => ['required_if:specification,null'],
                ];
            } else {
                $rules += [
                    'specification_file' => 'nullable',
                ];
            }
            //
            if ($quality_inspection_report_file == null) {
                $rules += [
                    'quality_inspection_report_file' => 'required_if:quality_inspection_report,Yes',
                ];
            } else {
                $rules += [
                    'quality_inspection_report_file' => 'nullable',
                ];
            }
            //
            if ($picture_packing_file == null) {
                $rules += [
                    'picture_packing_file' => ['required_if:picture_packing,Yes'],
                ];
            } else {
                $rules += [
                    'picture_packing_file' => 'nullable',
                ];
            }
            //
            if ($safety_product_file == null) {
                $rules += [
                    'safety_product_file' => 'nullable',
                ];
            } else {
                $rules += [
                    'safety_product_file' => 'nullable',
                ];
            }
            //
            if ($reach_certificate_file == null) {
                $rules += [
                    'reach_certificate_file' => 'nullable',
                ];
            } else {
                $rules += [
                    'reach_certificate_file' => 'nullable',
                ];
            }


        } else {

            //is_create
            $rules += [
                'specification_file' => ['required_if:specification,null'],
                'quality_inspection_report_file' => ['required_if:quality_inspection_report,Yes'],
                'picture_packing_file' => ['required_if:picture_packing,Yes'],
                'safety_product_file' => ['required_if:safety_product,Yes'],
                'reach_certificate_file' => ['required_if:reach_certificate,Yes'],
            ];

        }
        return $rules;
    }


    public function form_contact(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'type' => 'required',
            'description' => 'required',
            'url' => 'nullable',
            'option_value' => 'nullable',
            'file' => 'nullable'
        ]);


        if ($request->has('file') and $request->file != null) {
            $env = env('UPLOAD_SETTING');
            $filename = generateFileName($request->file->getClientOriginalName());
            $request->file->move(public_path($env), $filename);
        } else {
            $filename = null;
        }
        ContactForm::create([
            'email' => $request->email,
            'type' => $request->type,
            'description' => $request->description,
            'url' => $request->url,
            'option_value' => $request->option_value,
            'file' => $filename
        ]);

        session()->flash('success', 'Your message has been sent');
        return redirect()->route('home.index');

    }
}
