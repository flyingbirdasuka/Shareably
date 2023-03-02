<?php

namespace App\Models;

use App\Models\User;
use App\Models\Practice;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
    * The users that belong to the category.
    */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_categories');
    }

    /**
    * The practices that belong to the category.
    */
    public function practices(): BelongsToMany
    {
        return $this->belongsToMany(Practice::class, 'practice_categories');
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
