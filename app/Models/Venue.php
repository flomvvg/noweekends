<?php

namespace App\Models;

use App\Casts\TagCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
