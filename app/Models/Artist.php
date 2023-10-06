<?php

namespace App\Models;

use App\Casts\TagCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Artist extends Model
{
    use HasFactory;

    protected $table = 'artists';
    protected $primaryKey = 'id';


    protected $fillable = [
        'name',
        'tag',
        'description',
        'spotify',
        'soundcloud',
        'youtube',
        'amazon_music',
        'apple_music',
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

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
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
