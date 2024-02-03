<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;


    protected $fillable = [
        "clubname",
        "club_nickname",
        "user_id",
        "about",
        "email",
        "instagram",
        "contact_number",
        'image', // Make sure this line is present

    ];


    public function getImageURL(){
        if($this->image){
            return url('storage/' .$this->image);
        }
        return "images/blankprofile.png";
    }

     // Define the relationship with the User model
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }

     public function president()
     {
         return $this->belongsTo(User::class, 'user_id');
     }
}
