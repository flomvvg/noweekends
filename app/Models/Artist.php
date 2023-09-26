<?php

namespace App\Models;

use App\Casts\TagCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    ];

    protected $casts = [
        'tag' => TagCast::class
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
