<?php

namespace App\Http\Controllers;

use App\Models\Archives;
use App\Models\Users;
use Illuminate\Http\Request;

class ArchivesController extends Controller
{
    function get_alldonations_for_user($users_id)
    {
        $arch = Archives::where('users_id', $users_id)
            ->get();
    
        return response()->json(['' => $arch], 200);
    }
}
