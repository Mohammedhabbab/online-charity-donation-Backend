<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function insertcompanedata(Request $request)
    {
        // Assuming you have 'name' and 'email' fields in your table
        $data = $request->all();
        $comp = new Company();
        
        $comp->logo = $data['logo'];
        $comp->name=$data['name'];
        $comp->email=$data['email'];
        $comp->total_donations=$data['total_donations'];
        $comp->phone_number=$data['phone_number'];
        $comp->save();
        //$insertedData = Donation_types::create($data); // Replace YourModel with the actual model name

        return response()->json(['message' => 'Data inserted successfully'], 201);
    }
}
