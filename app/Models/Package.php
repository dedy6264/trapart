<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [

'courier_id',
'resi',
'status',
'weight',
'amount',
'start_date',
'desc',
        ];
        
}
