<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Profile extends Model
{
    use HasFactory;
     protected $fillable=['user_id','user_email','user_phone','user_address','profile_name'];
     
     public function user()
     {
        return $this->belongsToMany(User::class);
        
     }
    
}
