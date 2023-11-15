<?php

namespace App\Models;

use App\Models\Archives;
use App\Models\Charites;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiaries extends Model
{
    public function archives(): HasMany
    {
        return $this->hasMany(Archives::class,'Beneficiaries_id','id');
    }

    public function charte():BelongsTo
    {
        return $this->belongsTo(Charites::class,'charity_id','id');
    }
    use HasFactory;
}
