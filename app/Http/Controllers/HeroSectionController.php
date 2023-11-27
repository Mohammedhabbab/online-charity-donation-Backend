<?php

namespace App\Http\Controllers;

use App\Models\Hero_section;
use Illuminate\Http\Request;

class HeroSectionController  extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Hero_section::all(); // Replace YourModel with the actual model name

    return response()->json($data, 200);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
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
    public function show(Hero_section $Hero_section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hero_section $Hero_section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hero_section $Hero_section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hero_section $Hero_section)
    {
        //
    }

}