<?php

namespace App\Http\Controllers;
use App\Models\Beneficiaries;
use App\Models\Dividable_donations;
use App\Models\Needs;
use App\Models\Academic_fields;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class CharitesController extends Controller
{
    
    //
    

    public function register_Beneficiaries(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'full_name' => 'required|regex:/^[\pL\s-]+$/u|string',
            'mother_name' => 'required|regex:/^[\pL\s-]+$/u|string',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:male,female', // Adjust the possible gender values
            'phone_number' => 'required|numeric',
            'address' => 'required|string',
            'needy_type' => 'required|alpha|string',
            'monthly_need' => 'nullable|string',
            'name_of_school' => 'nullable|string',
            'Educational_level' => 'nullable|string',
            'charity_id' => 'required|integer|min:1',
            'overview' => 'required|alpha|string',
            'status' => 'required|integer|in:0,1', // Adjust the possible status values
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'غلط', 'errors' => $validator->errors()], 400);
        }
    
        $data = $req->all();
        $user = new Beneficiaries();
        $user->full_name = $data['full_name'];
        $user->mother_name = $data['mother_name'];
        $user->age = $data['age'];
        $user->gender = $data['gender'];
        $user->phone_number = $data['phone_number'];
        $user->address = $data['address'];
        $user->needy_type = $data['needy_type'];
        $user->monthly_need = $data['monthly_need'];
        $user->name_of_school = $data['name_of_school'];
        $user->Educational_level = $data['Educational_level'];
        $user->charity_id = $data['charity_id'];
        $user->overview = $data['overview'];
        $user->status = $data['status'];
    
        $user->save();
    
        return response()->json(['message' => 'success'], 200);
    }
    

    function delete_Beneficiaries($id){

        $user = Beneficiaries::find($id);
        $result=$user->delete();
        if($result){
        return ["result"=>"record has been deleted".$id];
    }
    else{
        return ["result"=>"delete has failed"];
    }
  
    }
    public function update_Beneficiaries(Request $request,$id)
    {
        $record = Beneficiaries ::find($id);

        // Get all data from the request
        $data = $request->all();

        // Update each field dynamically
        foreach ($data as $key => $value) {
            $record->$key = $value;
        }

        $record->save();

        return response()->json(['message' => 'Record updated successfully', 'data' => $record], 200);
    }

    function get_beneficiaries_for_charity($charity_id,$needy_type)
    {
        $beneficiaries = Beneficiaries::where('charity_id', $charity_id)
            ->where('needy_type', $needy_type)
            ->get();
    
        return response()->json(['beneficiaries' => $beneficiaries], 200);
    }

    function get_sponsored_beneficiaries_for_charity($charity_id,$needy_type)
    {
        $beneficiaries = Beneficiaries::where('charity_id', $charity_id)
        ->where('needy_type', $needy_type)
            ->where('status', 1)
            ->get();
    
        return response()->json(['beneficiaries' => $beneficiaries], 200);
    }

    function get_notsponsored_beneficiaries_for_charity($charity_id,$needy_type)
    {
        $beneficiaries = Beneficiaries::where('charity_id', $charity_id)
        ->where('needy_type', $needy_type)
            ->where('status', 0)
            ->get();
    
        return response()->json(['beneficiaries' => $beneficiaries], 200);
    }

    public function getNeedyCountByCharity($charityId)
    {
        $services = Services::pluck('title'); // Assuming 'type' is the column representing the service type

        $counts = [];

        foreach ($services as $serviceType) {
            $needyCount = Beneficiaries::where('charity_id', $charityId)
                ->whereHas('service', function ($query) use ($serviceType) {
                    $query->where('title', $serviceType);
                })
                ->count();

                if ($needyCount > 0) {
                    $counts[] = [ $serviceType];
                }
        }

        return response()->json(['needy_counts' => $counts]);
    }

    public function getNeedsCountByCharity($charityId)
    {
        $services = Services::pluck('title'); // Assuming 'type' is the column representing the service type

        $counts = [];

        foreach ($services as $serviceType) {
            $needyCount = Needs::where('charity_id', $charityId)
                ->whereHas('service', function ($query) use ($serviceType) {
                    $query->where('title', $serviceType);
                })
                ->count();

                if ($needyCount > 0) {
                    $counts[] = [ $serviceType];
                }
        }

        return response()->json(['needs_counts' => $counts]);
    }
        
    ////////////////////////////////////////////////////////////////
    public function register_Dividable_donations(Request $request)
{
    $validator = Validator::make($request->all(), [
        'type' => 'required|regex:/^[\pL\s-]+$/u|string',
        'total_cost' => 'required|numeric|min:0',
        'amount_paid' => 'required|numeric|min:0',
        'charity_id' => 'required|integer|min:1',
        'priority' => 'required|regex:/^[\pL\s-]+$/u|string',
        'overview' => 'required|regex:/^[\pL\s-]+$/u|string',
        'expriation_date' => 'required|date',
        'status' => 'required|integer|in:0,1',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => '  غلط في الادخال يرجى اعادة الادخال بطريقة صحيحة   '], 400);
    }

    $type = new Dividable_donations();
    $type->type = $request->input('type');
    $type->total_cost = $request->input('total_cost');
    $type->amount_paid = $request->input('amount_paid');
    $type->charity_id = $request->input('charity_id');
    $type->priority = $request->input('priority');
    $type->overview = $request->input('overview');
    $type->expriation_date = $request->input('expriation_date');
    $type->status = $request->input('status');
    $type->save();

    return response()->json(['message' => 'success'], 200);
}

    
    function delete_Dividable_donations($id){

        $user = Dividable_donations::find($id);
        $result=$user->delete();
        if($result){
        return ["result"=>"record has been deleted".$id];
    }
    else{
        return ["result"=>"delete has failed"];
    }
  
    }
    public function update_Dividable_donations(Request $request,$id)
    {
        $record = Dividable_donations ::find($id);

        // Get all data from the request
        $data = $request->all();

        // Update each field dynamically
        foreach ($data as $key => $value) {
            $record->$key = $value;
        }

        $record->save();

        return response()->json(['message' => 'Record updated successfully', 'data' => $record], 200);
    }

    function get_Dividable_donations_for_charity($charity_id,$type)
    {
        $dividable = Dividable_donations::where('charity_id', $charity_id)
            ->where('type', $type)
            ->get();
    
        return response()->json(['Dividable_donations' => $dividable], 200);
    }

    function get_sponsored_Dividable_donations_for_charity($charity_id,$type)
    {
        $dividable = Dividable_donations::where('charity_id', $charity_id)
        ->where('type', $type)
            ->where('status', 1)
            ->get();
    
        return response()->json(['Dividable_donations' => $dividable], 200);
    }

    function fcharnotsponsored_Dividable_donations_for_charity($charity_id,$type)
    {
        $dividable = Dividable_donations::where('charity_id', $charity_id)
        ->where('type', $type)
            ->where('status', 0)
            ->get();
    
        return response()->json(['Dividable_donations' => $dividable], 200);
    }

    ////////////////////////////////////////////////////
    public function register_Needs(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name_of_proudct' => 'required|regex:/^[\pL\s-]+$/u|string',
        'type_of_proudct' => 'required|regex:/^[\pL\s-]+$/u|string',
        'needs_type' => 'required|regex:/^[\pL\s-]+$/u|string',
        'charity_id' => 'required|integer|min:1',
        'total_count' => 'required|integer|min:0',
        'available_count' => 'required|integer|min:0',
        'price_per_item' => 'required|integer|min:0',
        'total_amount' => 'required|integer|min:0',
        'overview' => 'required|regex:/^[\pL\s-]+$/u|string',
        'status' => 'required|integer|in:0,1',
        'image' => 'sometimes',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => ' غلط في الادخال يرجى اعادة الادخال بطريقة صحيحة', 'errors' => $validator->errors()], 400);
    }

    $needs = new Needs();
    $needs->name_of_proudct = $request->input('name_of_proudct');
    $needs->type_of_proudct = $request->input('type_of_proudct');
    $needs->needs_type = $request->input('needs_type');
    $needs->charity_id = $request->input('charity_id');
    $needs->total_count = $request->input('total_count');
    $needs->available_count = $request->input('available_count');
    $needs->price_per_item = $request->input('price_per_item');
    $needs->total_amount = $request->input('total_amount');
    $needs->overview = $request->input('overview');
    $needs->status = $request->input('status');

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);

        $needs->image = 'http://localhost:8000/uploads/' . $imageName;
    }

    $needs->save();

    return response()->json(['message' => 'Data inserted successfully'], 201);
}

    function delete_Needs($id){

        $user = Needs::find($id);
        $result=$user->delete();
        if($result){
        return ["result"=>"record has been deleted".$id];
    }
    else{
        return ["result"=>"delete has failed"];
    }
  
    }
    public function update_Needs(Request $request,$id)
    {
        $record = Needs ::find($id);

        // Get all data from the request
        $data = $request->all();

        // Update each field dynamically
        foreach ($data as $key => $value) {
            $record->$key = $value;
        }

        $record->save();

        return response()->json(['message' => 'Record updated successfully', 'data' => $record], 200);
    }
     


    function get_needs_for_charity($charity_id,$type_of_proudct)
    {
        $beneficiaries = Needs::where('charity_id', $charity_id)
            ->where('type_of_proudct', $type_of_proudct)
            ->get();
    
        return response()->json(['beneficiaries' => $beneficiaries], 200);
    }
    ///////////////////////////////
    public function register_Academic_fields(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_fields_name' => 'required|regex:/^[\pL\s-]+$/u|string',
            'years_to_finish' => 'required|string',
            'price_per_year' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => ' غلط في الادخال يرجى اعادة الادخال بطريقة صحيحة', 'errors' => $validator->errors()], 400);
        
        }
        $data = $request->all();
        $type = new Academic_fields();
        $type->academic_fields_name = $data['academic_fields_name'];
        $type->years_to_finish = $data['years_to_finish'];
        $type->price_per_year = $data['price_per_year'];
        $type->save();

        return response()->json("success", 200);


    }
    function delete_Academic_fields($id){

        $user = Academic_fields::find($id);
        $result=$user->delete();
        if($result){
        return ["result"=>"record has been deleted".$id];
    }
    else{
        return ["result"=>"delete has failed"];
    }
  
    }
    public function update_Academic_fields(Request $request,$id)
    {
        $record = Academic_fields ::find($id);

        // Get all data from the request
        $data = $request->all();

        // Update each field dynamically
        foreach ($data as $key => $value) {
            $record->$key = $value;
        }

        $record->save();

        return response()->json(['message' => 'Record updated successfully', 'data' => $record], 200);
    }

    //////////////////

    public function getNeedyAndNeedsCountByCharity($charityId)
{
    $services = Services::pluck('title'); // Assuming 'title' is the column representing the service title

    $counts = [];

    foreach ($services as $serviceType) {
        $needyCount = Beneficiaries::where('charity_id', $charityId)
            ->whereHas('service', function ($query) use ($serviceType) {
                $query->where('title', $serviceType);
            })
            ->count();

        $needsCount = Needs::where('charity_id', $charityId)
            ->whereHas('service', function ($query) use ($serviceType) {
                $query->where('title', $serviceType);
            })
            ->count();

        if ($needyCount > 0 || $needsCount > 0) {
            $counts[$serviceType] = ['needy_count' => $needyCount, 'needs_count' => $needsCount];
        }
    }

    return response()->json(['counts' => $counts]);
}
/////--------------------------/////


/////////////////////////////////////////

public function getProductsByType($needs_type)
{
    $products = Needs::where('needs_type', $needs_type)->get();

    if ($products->isEmpty()) {
        return response()->json(['error' => 'Products not found.'], 404);
    }

    $response = [];

    foreach ($products as $product) {
        $remaining_count = $product->total_count - $product->available_count;
        
        // Calculate remaining amount based on the formula
        $remaining_amount = ($product->total_amount / $product->total_count) * $remaining_count;

        $response[] = [
            'name_of_proudct' => $product->name_of_proudct,
            'type_of_proudct' => $product->type_of_proudct,
            'total_count' => $product->total_count,
            'available_count' => $product->available_count,
            'total_amount' => $product->total_amount,
            'remaining_count' => $remaining_count,
            'remaining_amount' => $remaining_amount,
        ];
    }

    return response()->json($response);
}



public function getProductsByTypeAndCharity($needs_type, $charity_id)
{
    $products = Needs::where('needs_type', $needs_type)
        ->where('charity_id', $charity_id)
        ->get();

    if ($products->isEmpty()) {
        return response()->json(['error' => 'Products not found.'], 404);
    }

    $response = [];

    foreach ($products as $product) {
        $remaining_count = $product->total_count - $product->available_count;

        // Calculate remaining amount based on the formula
        $remaining_amount = ($product->total_amount / $product->total_count) * $remaining_count;

        $response[] = [
            'name_of_product' => $product->name_of_product,
            'type_of_product' => $product->type_of_product,
            'total_count' => $product->total_count,
            'available_count' => $product->available_count,
            'total_amount' => $product->total_amount,
            'remaining_count' => $remaining_count,
            'remaining_amount' => $remaining_amount,
        ];
    }

    return response()->json($response);
}

   
}



