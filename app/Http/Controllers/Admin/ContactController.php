<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactAddress;
use App\Models\ContactHelp;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function save_address(Request $request)
    {
        $request->validate([
            'title_modal' => 'required',
        ]);
        try {
            $data = [
                'title_modal' => $request->title_modal,
                'address_modal' => $request->address_modal,
                'tel_1_modal' => $request->tel_1_modal,
                'tel_2_modal' => $request->tel_2_modal,
                'tel_3_modal' => $request->tel_3_modal,
                'email_modal' => $request->email_modal,
                'email_2_modal' => $request->email_2_modal,
            ];

            if ($request->address_modal_id !== null) {
                $contact_address = ContactAddress::where('id', $request->address_modal_id)->first();
                $contact_address->update($data);
                $message = 'Item Is Updated Successfully!';
            } else {
                $message = 'Item Is Created Successfully!';
                ContactAddress::create($data);
            }
            return response()->json([1, $message]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }

    }

    public function delete_address(Request $request)
    {
        try {
            $contact_address = ContactAddress::where('id', $request->address_id)->first();
            $contact_address->delete();
            return response()->json([1, 'ok']);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json([0, $e->getMessage()]);
        }
    }

    public function save_help_support(Request $request)
    {
        try {
            $data = [
                'title_help_modal' => $request->title_help_modal,
                'description_help_modal' => $request->description_help_modal,
                'link_help_modal' => $request->link_help_modal,
            ];

            if ($request->address_modal_id !== null) {
                $contact_help = ContactHelp::where('id', $request->address_modal_id)->first();
                $contact_help->update($data);
                $message = 'Item Is Updated Successfully!';
            } else {
                $message = 'Item Is Created Successfully!';
                ContactHelp::create($data);
            }
            return response()->json([1, $message]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }

    }

    public function delete_help_support(Request $request)
    {
        try {
            $item = ContactHelp::where('id', $request->id)->first();
            $item->delete();
            return response()->json([1, 'ok']);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }
    }
}
