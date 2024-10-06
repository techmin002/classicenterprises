<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Entities\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $data['blogs'] = Blog::all();
        if($data['blogs']->count() >= 1)
        {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'blogs Founds',
                'data' => $data['blogs']
            ]);
        }else{
            return response()->json([
                'code' => 204,
                'status' => 'error',
                'message' => 'blogs not found',
            ]);
        }
    }
}
