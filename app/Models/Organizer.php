<?php

namespace App\Models;

use App\Casts\TagCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Laravel\Prompts\Concerns\Events;

class Organizer extends Model
{
    use HasFactory;

    protected $table = 'organizers';
    protected $primaryKey = 'id';


    protected $fillable = [
        'name',
        'description',
        'tag',
        'website',
        'archived'
    ];
    protected $casts = [
        'tag' => TagCast::class
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function getUpcomingEvents(): Collection
    {
        $events = Event::where('organizer_profile_type', 'organizer')->where('organizer_profile_id', '=', $this->id)->get();
        $upcomingEvents = collect();
        foreach ($events as $event) {
            $datetime = $event->end_date . " " . $event->end_time;
            if ($datetime > Carbon::now()) {
                $upcomingEvents->push($event);
            }
        }
        return $upcomingEvents;
    }

    public function getPastEvents(): Collection
    {
        $events = Event::where('organizer_profile_type', 'organizer')->where('organizer_profile_id', '=', $this->id)->get();
        $pastEvents = collect();
        foreach ($events as $event) {
            $datetime = $event->end_date . " " . $event->end_time;
            if ($datetime < Carbon::now()) {
                $pastEvents->push($event);
            }
        }
        return $pastEvents;
    }
}
