<?php

namespace App\Http\Controllers;

use App\Models\Beneficiaries;
use Illuminate\Http\Request;

class BeneficiariesController extends Controller
{
    public function index()
    {
        $data = Beneficiaries::all(); // Replace YourModel with the actual model name

    return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        
        $type = new Beneficiaries();
        $type->full_name = $request->input('full_name');
        $type->mother_name = $request->input('mother_name');
        $type->age = $request->input('age');
        $type->gender = $request->input('gender');
        $type->phone_number = $request->input('phone_number');
        $type->address = $request->input('address');
        $type->needy_type = $request->input('needy_type');
        $type->charity_id = $request->input('charity_id');
        $type->overview = $request->input('overview');
        $type->status = $request->input('status');

        $type->save();

        return response()->json(['message' => 'Data inserted successfully', 'data' => $type], 201);
    }
}
