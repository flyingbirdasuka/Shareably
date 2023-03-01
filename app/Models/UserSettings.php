<?php

namespace App\Models;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'notification_setting', 'sound_setting'
    ];

    /**
     * Get the languages for the user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
    * The language that belong to the user_settings.
    */
    public function language(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'user_settings_language');
    }
}