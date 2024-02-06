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

     protected $fillable = [
        'service',
        'overview',
        'total_amount_of_donation',
        'users_id',
        'users_name', // Add this line
        'charity_id',
        'Beneficiaries_id',
        'Beneficiaries_name',
    ];

    use HasFactory;
}
