<?php

namespace App\Http\Controllers\Api;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::all();
    }

    public function store(Request $request)
    {
        //
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
