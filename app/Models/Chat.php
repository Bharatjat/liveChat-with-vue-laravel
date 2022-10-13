<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id','message'];

    public function user(){
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

}
