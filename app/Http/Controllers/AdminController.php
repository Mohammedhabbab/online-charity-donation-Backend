<?php

namespace App\Http\Controllers;
use App\Models\Services;
use App\Models\Needs;
use App\Models\Hero_section;
use App\Models\Beneficiaries;
use App\Models\Dividable_donations;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    function register_Services(Request $request){
        $data = $request->all();
        $user = new Services();
        $user->title = $data['title'];
        $user->description = $data['description'];
        $user->url = $data['url'];
        $user->shape = $data['shape'];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

         
            $data['image'] = 'http://localhost:8000/uploads/' . $imageName;
        }
        $user->image = $data['image'];
        $user->save();
        return response()->json("success", 200);
    
    }
    function delete_Services($id){

        $user = Services::find($id);
        $result=$user->delete();
        if($result){
        return ["result"=>"record has been deleted".$id];
    }
    else{
        return ["result"=>"delete has failed"];
    }
  
    }
    public function update_Services(Request $request)
    {
        $record = Services ::find($request->id);

        // Get all data from the request
        $data = $request->all();

        // Update each field dynamically
        foreach ($data as $key => $value) {
            $record->$key = $value;
        }

        $record->save();

        return response()->json(['message' => 'Record updated successfully', 'data' => $record], 200);
    }

    public function register_Hero_section(Request $request)
    {
        $data = $request->all();


        //image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

         
            $data['image'] = 'http://localhost:8000/uploads/' . $imageName;
        }
        //asset
        if ($request->hasFile('asset')) {
            $asset = $request->file('asset');
            $assetName = time() . '.' . $asset->getClientOriginalExtension();
            $asset->move(public_path('uploads'), $assetName);

            
            $data['asset'] = 'http://localhost:8000/uploads/' . $assetName;
        }

       
        $type = new Hero_section();
        $type->image = $data['image'];
        $type->asset = $data['asset'];
        $type->save();

        return response()->json(['message' => 'Data inserted successfully', 'data' => $type], 201);
    }
    function delete_Hero_section($id){

        $user = Hero_section::find($id);
        $result=$user->delete();
        if($result){
        return ["result"=>"record has been deleted".$id];
    }
    else{
        return ["result"=>"delete has failed"];
    }
  
    }
    public function update_Hero_section(Request $request)
    {
        $record = Hero_section ::find($request->id);

        // Get all data from the request
        $data = $request->all();

        // Update each field dynamically
        foreach ($data as $key => $value) {
            $record->$key = $value;
        }

        $record->save();

        return response()->json(['message' => 'Record updated successfully', 'data' => $record], 200);
    }

    public function get_all_Beneficiaries()
    {
        $data = Beneficiaries::all(); // Replace YourModel with the actual model name

    return response()->json($data, 200);
    }

    public function get_all_dividable_donations()
    {
        $data = Dividable_donations::all(); // Replace YourModel with the actual model name

    return response()->json($data, 200);
    }

    public function get_needs()
    {
        $data = Needs::all(); // Replace YourModel with the actual model name

    return response()->json($data, 200);
    }
}