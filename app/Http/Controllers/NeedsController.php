<?php

namespace App\Http\Controllers;

use App\Models\Needs;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class NeedsController extends Controller
{
    public function index()
    {
        $data = Needs::all(); // Replace YourModel with the actual model name

    return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $needs= new Needs();
        $needs->needs_type_id=$request->input('needs_type_id');
        $needs->charity_id=$request->input('charity_id');
        $needs->total_count=$request->input('total_count');
        $needs->count=$request->input('count');
        $needs->price_per_item=$request->input('price_per_item');  
        $needs->total_amount=$request->input('total_amount');
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
}
