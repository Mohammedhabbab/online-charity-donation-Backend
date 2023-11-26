<?php

namespace App\Models;
//use App\Http\Controllers\AuthController;
use App\Models\Archives;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Users extends Model
{
    public function archives(): HasMany
    {
        return $this->hasMany(Archives::class,'users_id','id');
    }
    use HasFactory;
}
