<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {
        $data = Company::all(); // Replace YourModel with the actual model name

    return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $comp = new Company;
        
        if($request->hasFile('logo')){
            $file=$request->file('logo');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            //$file->move('public/storge/images',$filename);
            $file = Storage::put('public/storge/images', $request->file('logo'));
            $path = Storage::url($file);
         
            $comp->logo=$path;
        }
        $comp->name=$request->input('name');
        $comp->email=$request->input('email');
        $comp->total_donations=$request->input('total_donations');
        $comp->phone_number=$request->input('phone_number');

        $comp->save();
        // return redirect()->back()->with('status','needs type image added sucss');
        return response()->json(['message' => 'Data inserted successfully','data' => $comp], 201);
    }
}
