<?php

namespace App\Models;
use App\Models\Needs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Services extends Model
{
    public function need(): HasMany
    {
        return $this->hasMany(Needs::class,'needs_type_id','id');
    }
    use HasFactory;
}
