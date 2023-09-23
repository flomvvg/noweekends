<?php

namespace App\Models;

use App\Casts\TagCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organizer extends Model
{
    use HasFactory;

    protected $table = 'organizers';
    protected $primaryKey = 'id';


    protected $fillable = [
        'name',
        'description',
        'tag',
    ];
    protected $casts = [
        'tag' => TagCast::class
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
