<?php

namespace App\Models;

use App\Models\Charites;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dividable_donations extends Model
{
    public function charte():BelongsTo
    {
        return $this->belongsTo(Charites::class,'charity_id','id');
    }
    use HasFactory;
}
