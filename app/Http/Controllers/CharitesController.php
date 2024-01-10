<?php

namespace App\Http\Controllers;
use App\Models\Beneficiaries;
use App\Models\Dividable_donations;
use App\Models\Needs;
use App\Models\Academic_fields;
use App\Models\Services;
use Illuminate\Http\Request;

class CharitesController extends Controller
{
    
    //
    function register_Beneficiaries(Request $req){
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
        $user->name_of_school= $data['name_of_school'];
        $user->Educational_level = $data['Educational_level'];
        $user->charity_id = $data['charity_id'];
        $user->overview = $data['overview'];
        $user->status = $data['status'];

        $user->save();

        return response()->json("success", 200);
    
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
        $data = $request->all();
        $type = new Dividable_donations();
        $type->type = $data['type'];
        $type->total_cost = $data['total_cost'];
        $type->amount_paid = $data['amount_paid'];
        $type->charity_id = $data['charity_id'];
        $type->priority = $data['priority'];
        $type->overview = $data['overview'];
        $type->expriation_date = $data['expriation_date'];
        $type->status = $data['status'];
        $type->save();

        return response()->json("success", 200);
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

    function get_notsponsored_Dividable_donations_for_charity($charity_id,$type)
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
        $needs= new Needs();
        $needs->name_of_proudct=$request->input('name_of_proudct');
        $needs->type_of_proudct=$request->input('type_of_proudct');
        $needs->needs_type_id=$request->input('needs_type_id');
        $needs->charity_id=$request->input('charity_id');
        $needs->total_count=$request->input('total_count');
        $needs->available_count=$request->input('available_count');
        $needs->price_per_item=$request->input('price_per_item');  
        $needs->total_amount=$request->input('total_amount');
        $needs->overview=$request->input('overview');
        $needs->satatus= $request->input('status');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

         
            $data['image'] = 'http://localhost:8000/uploads/' . $imageName;
        }
        $needs->image = $data['image'];
        $needs->save();
        // return redirect()->back()->with('status','needs image added sucss');
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

}
