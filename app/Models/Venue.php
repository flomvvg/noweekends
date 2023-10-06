<?php

namespace App\Models;

use App\Casts\TagCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Venue extends Model
{
    use HasFactory;

    protected $table = 'venues';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'tag',
        'description',
        'street',
        'number',
        'zip',
        'city',
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
        $events = $this->events()->get();
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
        $events = $this->events()->get();
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
