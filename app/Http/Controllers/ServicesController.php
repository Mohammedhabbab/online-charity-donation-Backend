<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Services::all(); // Replace YourModel with the actual model name

    return response()->json($data, 200);
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
        $type = new Services();
        
        $type->title = $data['title'];
        $type->description=$data['description'];
        $type->url = $data['url'];
        if($request->hasFile('profile_image')){
            $file=$request->file('profile_image');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            //$file->move('public/storge/images',$filename);
            $file = Storage::put('public/storge/images', $request->file('profile_image'));
            $path = Storage::url($file);
         
            $type->profile_image=$path;
        }
        $type->save();
        //$insertedData = Donation_types::create($data); // Replace YourModel with the actual model name

        return response()->json(['message' => 'Data inserted successfully','data' => $type], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Services $services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Services $services)
    {
        //
    }
}
