<?php

namespace App\Http\Controllers;
use App\Models\Needs_types;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class NeedsTypeController extends Controller
{
    public function index()
    {
        $data = Needs_types::all(); // Replace YourModel with the actual model name

    return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $type = new Needs_types;
        $type->type=$request->input('type');
        $type->status=$request->input('status');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

         
            $data['image'] = 'http://localhost:8000/uploads/' . $imageName;
        }
        $type->image = $data['image'];
        $type->save();
        // return redirect()->back()->with('status','needs type image added sucss');
        return response()->json(['message' => 'Data inserted successfully','data' => $type], 201);
    }
}
