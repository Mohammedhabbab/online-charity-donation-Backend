<?php

namespace App\Http\Controllers;

use App\Models\Complaints;
use Illuminate\Http\Request;

class ComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Complaints::all();
        return response()->json($contacts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $us = new Complaints();

        $us->name =$data['name'];
        $us->email =$data['email'];
        $us->problem =$data['problem'];
        $us->message =$data['message'];
        $us->save();
        //$contact = Complaints::create($request->all());

        return response()->json("complaine added ", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaints $complaints)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaints $complaints)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaints $complaints)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaints $complaints)
    {
        //
    }
}
