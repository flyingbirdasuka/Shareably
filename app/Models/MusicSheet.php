<?php

namespace App\Models;

use App\Models\Practice;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicSheet extends Model
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
    * The practices that belong to the musicsheet.
    */
    public function practices(): BelongsToMany
    {
        return $this->belongsToMany(Practice::class, 'music_sheet_practices');

    }
}
