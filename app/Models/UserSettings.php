<?php

namespace App\Models;

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
}