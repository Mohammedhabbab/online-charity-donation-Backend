<?php

namespace App\Http\Controllers;

use App\Models\Donation_types;
use Illuminate\Http\Request;

class Donation_typeController extends Controller
{
    public function inserttype(Request $request)
    {
        // Assuming you have 'name' and 'email' fields in your table
        $data = $request->all();
        $type = new Donation_types();
        
        $type->title = $data['title'];
        $type->description=$data['description'];
        $type->save();
        //$insertedData = Donation_types::create($data); // Replace YourModel with the actual model name

        return response()->json(['message' => 'Data inserted successfully','data' => $type], 201);
    }
    public function getAllData()
    {
    $data = Donation_types::all(); // Replace YourModel with the actual model name

    return response()->json($data, 200);
    }

    
}
