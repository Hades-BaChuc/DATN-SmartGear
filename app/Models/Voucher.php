<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['code','type','amount','active','starts_at','ends_at','usage_limit'];
    protected $casts = ['starts_at'=>'datetime','ends_at'=>'datetime','active'=>'boolean'];
}
