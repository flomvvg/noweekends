<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'type',
        'weather_condition',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'genre_id',
        'minimum_age',
        'presale_available',
        'presale_link',
        'box_office_available',
        'box_office_price',
        'facebook_event',
        'organizer_profile_type',
        'organizer_profile_id',
        'venue_registered',
        'venue_id',
        'venue_name',
        'street',
        'number',
        'zip',
        'city',
        'oneway',
        'cancelled',
    ];

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function unregisteredArtists(): HasMany
    {
        return $this->hasMany(UnregisteredArtist::class);
    }

    public function organizerProfile(): Artist|Venue|Organizer
    {
        $organizerProfileType = new("App\\Models\\" . ucfirst($this->organizer_profile_type));
        return $organizerProfileType::find($this->organizer_profile_id)->first();
    }
}
