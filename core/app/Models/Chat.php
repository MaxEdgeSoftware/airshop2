<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Messages(){
        return $this->hasMany(Message::class);
    }
    public function Unread(){
        return $this->hasMany(Message::class);
    }
}
