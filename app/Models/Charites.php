<?php

namespace App\Models;

use App\Models\Beneficiaries;
use App\Models\Dividable_donations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Charites extends Model
{
    public function benifeats(): HasMany
    {
        return $this->hasMany(Beneficiaries::class,'charity_id','id');
    }
    public function Dividabledonations(): HasMany
    {
        return $this->hasMany(Dividable_donations::class,'charity_id','id');
    }

    public function need(): HasMany
    {
        return $this->hasMany(Needs::class,'charity_id','id');
    }
    use HasFactory;
}
