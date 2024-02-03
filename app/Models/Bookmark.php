<?php
// Bookmark.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = 'bookmarks'; // If your table name is different

    protected $primaryKey = 'bookmark_id'; // If your primary key column has a different name

    public $timestamps = false; // If you don't need timestamps for this model

    protected $fillable = [
        'user_id', 'event_id',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship with the Event model
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}

