<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        "eventName",
        "dateStart",
        "dateEnd",
        "timeStart",
        "timeEnd",
        "description",
        "price",
        "category",
        "subcategory1",
        "status",
        "description",
    ];

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
}
