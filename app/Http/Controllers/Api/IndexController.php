<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Modules\Branch\Entities\Branch;
use Modules\Faq\Entities\Faq;
use Modules\Product\Entities\Machinery;
use Modules\Setting\Entities\CompanyProfile;
use Modules\Slider\Entities\Slider;
use Modules\Testimonial\Entities\Testimonial;

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
            'contact_number' => 'required',
            'location' => 'required',
            'service_type' => 'required',
            'message' => 'required',
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
            'contact_number' => $request['contact_number'],
            'message' => $request['message'],
            'service_type' => $request['service_type'],
            'location' => $request['location'],
            'status' => 'pending'
        ]);
        // Mail::to($request['email'])->send(new \App\Mail\ContactUs($contact));
        return response()->json([
            'code' => '200',
            'status' => 'success',
            'data' => $contact,
            'message' => 'Contact Created Successfully'
        ]);
    }
    }
    public function testimonials()
    {
        $data['testimonials'] = Testimonial::where('status','on')->get();
        $data['root_image_url'] =url('/upload/images/testimonials/');
        if(!empty($data['testimonials']))
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
    public function faqs()
    {
        $data['faqs'] = Faq::where('status','on')->get();
        if(!empty($data['faqs']))
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
    public function branches()
    {
        $data['branches'] = Branch::where('status','on')->get();
        if(!empty($data['branches']))
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
    public function products()
    {
        $data['products'] = Machinery::where('status','on')->get();
        if(!empty($data['products']))
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
    public function productDetails($id)
{
    $product = Machinery::where('id', $id)
        ->where('status', 'on')
        ->first();

    if (!empty($product)) {
        // Decode the images JSON string into an array
        $product->images = !empty($product->images) ? json_decode($product->images, true) : [];

        return response()->json([
            'code' => '200',
            'status' => 'success',
            'data' => [
                'product' => $product
            ]
        ]);
    } else {
        return response()->json([
            'code' => '204',
            'status' => 'error',
            'message' => 'Data is not available'
        ]);
    }
}

}
