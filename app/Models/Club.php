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
        "president",
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

    
}
