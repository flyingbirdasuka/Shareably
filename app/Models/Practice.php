<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Music;
use App\Models\MusicSheet;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'description'
    ];

    /**
    * The users that belong to the practice. (favorites)
    */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    /**
    * The categories that belong to the practice.
    */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'practice_categories');
    }

    /**
    * The musics that belong to the practice.
    */
    public function musics(): BelongsToMany
    {
        return $this->belongsToMany(Music::class, 'music_practices');
    }

    /**
    * The musicsheets that belong to the practice.
    */
    public function musicsheets(): BelongsToMany
    {
        return $this->belongsToMany(MusicSheet::class, 'music_sheet_practices');
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
