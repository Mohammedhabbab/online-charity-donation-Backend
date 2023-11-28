<?php

namespace App\Http\Controllers;

use App\Models\Dividable_donations;
use Illuminate\Http\Request;

class DividableDonationController  extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Dividable_donations::all(); // Replace YourModel with the actual model name

        return response()->json($data, 200);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $type = new Dividable_donations();
        $type->name = $data['name'];
        
        $type->total_cost = $data['total_cost'];
        $type->amount_paid = $data['amount_paid'];
        $type->charity_id = $data['charity_id'];
        $type->priority = $data['priority'];
        $type->overview = $data['overview'];
        $type->expriation_date = $data['expriation_date'];
        $type->save();

        return response()->json(['message' => 'Data inserted successfully', 'data' => $type], 201);
    }
    public function show(Dividable_donations $Dividable_donations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dividable_donations $Dividable_donations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $record = Dividable_donations::find($request->id);

        // Get all data from the request
        $data = $request->all();

        // Update each field dynamically
        foreach ($data as $key => $value) {
            $record->$key = $value;
        }

        $record->save();

        return response()->json(['message' => 'Record updated successfully', 'data' => $record], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dividable_donations $Dividable_donations)
    {
        //
    }
}