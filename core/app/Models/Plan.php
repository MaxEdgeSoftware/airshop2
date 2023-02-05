<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    
    protected $guarded = [''];

    public function ConvertedAmount($duration = "month"){
        $sign = seller()->base_currency;
        if($sign == "NGN" || $sign == "NG"){
            $rate = env("GBP_NGN");
        }else{
            $rate = 1;
        }

        if($duration == 'yearly'){
            return $this->price * $rate * 10;
        }

        return $this->price * $rate;
    }
}
