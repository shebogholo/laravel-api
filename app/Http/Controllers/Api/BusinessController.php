<?php

namespace App\Http\Controllers\Api;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::all();
        return response(['businesses' =>  BusinessResource::collection($businesses)], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'location' => 'required|max:255',
            'region' => 'required|max:255',
            'number' => 'required',
            'website' => '',
            'logo' => ''
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        // return $data;

        $business = Business::create($data);
        return response(['business' => new BusinessResource($business), 'message' => 'Created successfully'], 200);
    }

    public function show(Business $business)
    {
        //
    }

    public function update(Request $request, Business $business)
    {
        //
    }


    public function destroy(Business $business)
    {
        //
    }
}
