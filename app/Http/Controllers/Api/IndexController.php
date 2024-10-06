<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Modules\Setting\Entities\CompanyProfile;
use Modules\Slider\Entities\Slider;

class IndexController extends Controller
{
    public function slider()
    {
        $data['sliders'] = Slider::get();
        $data['root_image_url'] =url('upload/images/sliders/');
        if(!empty($data['sliders']))
        {
            return response()->json([
                'code' => '200',
                'status' => 'success',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'code' => '204',
                'status' => 'error',
                'message' => 'Sliders are not available'
            ]);
        }
    }
    public function about()
    {
        $data['about'] = CompanyProfile::first();
        $data['root_image_url'] =url('/upload/images/settings/');
        if(!empty($data['about']))
        {
            return response()->json([
                'code' => '200',
                'status' => 'success',
                'data' => $data
            ]);
        }
        else{
                return response()->json([
                    'code' => '204',
                    'status' => 'error',
                    'message' => 'Data is not available'
                ]);
            }
    }
    public function contactUs(Request $request)
    {
        $validation = Validator::make($request->all(),[ 
            'name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'message' => 'required'
        ]);
    
        if($validation->fails()){
            return response()->json([
                'code' => '204',
                'status' => 'error',
                'message' => 'Something went wrong. There is some data missing. Please try again'
            ]); 
    
        } else{
        $contact =Contact::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'contact' => $request['contact'],
            'message' => $request['message'],
            'service_id' => $request['service_id']
        ]);
        Mail::to($request['email'])->send(new \App\Mail\ContactUs($contact));
        return response()->json([
            'code' => '200',
            'status' => 'success',
            'data' => $contact,
            'message' => 'Contact Created Successfully'
        ]);
    }
    }
}
