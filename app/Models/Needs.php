<?php

namespace App\Models;

use App\Models\Charites;
use App\Models\Needs_types;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Needs extends Model
{
    public function charte():BelongsTo
    {
        return $this->belongsTo(Charites::class,'charity_id','id');
    }

    public function needs_type():BelongsTo
    {
        return $this->belongsTo(Needs_types::class,'needs_type_id','id');
    }
    use HasFactory;
}
