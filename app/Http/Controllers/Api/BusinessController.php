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
        // Read data from storage folder and insert to database
        $json = file_get_contents(storage_path('data.json'));
        $objects = json_decode($json, true);
        foreach($objects as $object){
            $data = [
                'name' => $object['business_title'],
                'location' => $object['business_location'],
                'region' => $object['business_region'],
                'number' => $object['business_number'],
                'website' => $object['business_website'],
                'logo' => $object['business_logo']
            ];
            $validator = Validator::make($data, [
                'name' => 'required|max:255|unique:businesses',
                'location' => 'required|max:255',
                'region' => 'required|max:255',
                'number' => 'required',
                'website' => '',
                'logo' => ''
            ]);
    
            if ($validator->fails()) {
                return response(['error' => $validator->errors()->first()]);
            }
            $business = Business::create($data);
        }
        return response(['message' => 'All businesses already inserted into database.'], 200);
        
        // Get data from request
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255|unique:businesses',
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
        
        // Todo: I dont like the error message if item is not found, custom message?

        // unset multiple fields
        $remove = array('id', 'created_at', 'updated_at');
        foreach($remove as $key){
            unset($business[$key]);
        }
        return response(['business' => new BusinessResource($business)]);
    }

    public function update(Request $request, Business $business)
    {
        //
    }


    public function destroy(Business $business)
    {
        $business->delete();
        return response(['message' => 'Deleted']);
    }
}
