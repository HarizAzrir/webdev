<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'events';

    protected $fillable = [
        "eventName",
        "dateStart",
        "dateEnd",
        "timeStart",
        "timeEnd",
        "venue",
        "description",
        "price",
        "category",
        "subcategory1",
        "status",
        "image",
    ];

    public function getImageURL(){
        if($this->image){
            return url('storage/' .$this->image);
        }
        return "images/blankprofile.png";
    }


    public function getDateStartFormattedAttribute()
    {
        return Carbon::parse($this->attributes['dateStart'])->format('l, d F Y');
    }

    public function getDateEndFormattedAttribute()
    {
        return Carbon::parse($this->attributes['dateEnd'])->format('l, d F Y');
    }

    public function getTimeStartFormattedAttribute()
    {
        return Carbon::parse($this->attributes['timeStart'])->format('H:i');
    }

    public function getTimeEndFormattedAttribute()
    {
        return Carbon::parse($this->attributes['timeEnd'])->format('H:i');
    }

    // Event.php
    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks', 'event_id', 'user_id')->withTimestamps();
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
    
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }


}