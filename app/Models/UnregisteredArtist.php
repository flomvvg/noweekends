<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnregisteredArtist extends Model
{
    use HasFactory;

    protected $table = 'unregistered_artists';
    protected $primaryKey = 'id';

    protected $fillable = [
        'event_id',
        'name',
        'spotify',
        'soundcloud',
        'youtube',
        'amazon_music',
        'apple_music',
    ];

    public function events(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
