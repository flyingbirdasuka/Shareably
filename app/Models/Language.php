<?php

namespace App\Models;

use App\Models\UserSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Language extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'language_code', 'language'
    ];

    /**
    * The user_settings that belong to the language.
    */
    public function user_settings(): BelongsToMany
    {
        return $this->belongsToMany(UserSettings::class, 'user_settings_language');
    }

}
