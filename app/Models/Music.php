<?php

namespace App\Models;

use App\Models\Practice;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'filename', 
    ];

    /**
    * The practices that belong to the music.
    */
    public function practices(): BelongsToMany
    {
        return $this->belongsToMany(Practice::class, 'music_practices');

    }

    /**
    * title mutators (runs before the data is saved to the database)
    * when "name" will save, it will convert into lowercase
    */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);
    }

    /**
    * title accessors (runs when we get the data from the database)
    */ 
    public function getTitleAttribute($value)
    {
        return ucwords($value);
    }

}
