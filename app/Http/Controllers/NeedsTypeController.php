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
        // return redirect()->back()->with('status','needs type image added sucss');
        return response()->json(['message' => 'Data inserted successfully','data' => $type], 201);
    }
}
