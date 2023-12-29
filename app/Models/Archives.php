<?php

namespace App\Models;

use App\Models\Beneficiaries;
use App\Models\Donation_types;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archives extends Model
{
    public function users():BelongsTo
    {
        return $this->belongsTo(Users::class);
    }

    public function benefit():BelongsTo
    {
        return $this->belongsTo(Beneficiaries::class,'Beneficiaries_id','id');
    }
     public function service():BelongsTo
     {
         return $this->belongsTo(Services::class,'donation_type_id','id');
     }
    use HasFactory;
}
