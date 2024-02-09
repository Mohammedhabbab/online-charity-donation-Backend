<?php

namespace App\Http\Controllers;

use App\Models\Archives;
use App\Models\Services;
use App\Models\Needs;
use App\Models\Users;
use App\Models\Hero_section;
use App\Models\Beneficiaries;
use App\Models\Complaints;
use App\Models\Dividable_donations;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    //
    function register_Services(Request $request)
    {
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
    public function index()
    {
        $data = Services::all(); // Replace YourModel with the actual model name

        return response()->json($data, 200);
    }
    function delete_Services($id)
    {

        $user = Services::find($id);
        $result = $user->delete();
        if ($result) {
            return ["result" => "record has been deleted" . $id];
        } else {
            return ["result" => "delete has failed"];
        }
    }
    public function update_Services(Request $request, $id)
    {
        $record = Services::find($id);

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
    public function index1()
    {
        $data = Hero_section::all(); // Replace YourModel with the actual model name

        return response()->json($data, 200);
    }
    function delete_Hero_section($id)
    {

        $user = Hero_section::find($id);
        $result = $user->delete();
        if ($result) {
            return ["result" => "record has been deleted" . $id];
        } else {
            return ["result" => "delete has failed"];
        }
    }
    public function update_Hero_section(Request $request, $id)
    {
        $record = Hero_section::find($id);

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
        
        $data = Beneficiaries::orderByDesc('priority')->get();
        //$data = Beneficiaries::orderByDesc('priority')->get();
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

    public function getUserCount()
    {
        $userCount = Users::where('type_of_user', 'user')->count();

        return response()->json(['user_count' => $userCount]);
    }

    public function getCharityCount()
    {
        $charityCount = Users::where('type_of_user', 'charity')->count();

        return response()->json(['charity_count' => $charityCount]);
    }

    public function getServiceCount()
    {
        $serviceCount = Services::count();

        return response()->json(['service_count' => $serviceCount]);
    }

    public function getBeneficiaryCount()
    {
        $beneficiaryCount = Beneficiaries::count();

        return response()->json(['beneficiary_count' => $beneficiaryCount]);
    }

    public function getNeedsCount()
    {
        $needsCount = Needs::count();

        return response()->json(['needs_count' => $needsCount]);
    }

    public function getComplainCount()
    {
        $complainsCount = Complaints::count();

        return response()->json(['complains_count' => $complainsCount]);
    }

    public function getHeroCount()
    {
        $heroCount = Hero_section::count();

        return response()->json(['hero_count' => $heroCount]);
    }

    public function getArchiveCount()
    {
        $archiveCount = Archives::count();

        return response()->json(['archive_count' => $archiveCount]);
    }
    public function get_all_Charities()
    {

        $data = Users::where('type_of_user', 'charity')->get(); // Replace YourModel with the actual model name

        return response()->json($data, 200);
    }
    public function get_all_Users()
    {
        $data = Users::where('type_of_user', 'user')->get(); // Replace YourModel with the actual model name

        return response()->json($data, 200);
    }

    public function delete_Users($id)
    {

        $user = Users::find($id);

        $result = $user->delete();
        if ($result) {
            return ["result" => "record has been deleted" . $id];
        } else {
            return ["result" => "delete has failed"];
        }
    }

    function get_all_Donations()
    {
        $data = Archives::all(); // Replace YourModel with the actual model name

        $result=$user->delete();
        if($result){
        return ["result"=>"record has been deleted".$id];
        }
        else{
            return ["result"=>"delete has failed"];
        }
    }    


        return response()->json($data, 200);
    }



    public function update_status(Request $request, $id)
    {
        try {
            $record = Users::find($id);

            if (!$record) {
                return response()->json(['error' => 'Record not found'], 404);
            }

            // Toggle the status from 0 to 1 or from 1 to 0
            $record->status = $record->status == 0 ? 1 : 0;

            $record->save();

            return response()->json(['message' => 'Status updated successfully', 'data' => $record], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update status'], 500);
        }
    }




}
