<?php

namespace App\Casts;

use App\Models\Artist;
use App\Models\Organizer;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TagCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        $value = $this->generateTag();
        while (!$this->isTagAvailable($value)) {
            $value = $this->generateTag();
        }
        return $value;
    }

    private function isTagAvailable(string $tag): bool
    {
        $organizerTag = Organizer::where('tag', $tag)->first();
        $artistTag = Artist::where('tag', $tag)->first();
        if ($organizerTag === null && $artistTag === null) {
            return true;
        }

        return false;
    }

    private function generateTag(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $tag = '';
        for ($i = 0; $i < 4; $i++) {
            $tag = $tag . $characters[rand(4, strlen($characters))];
        }
        return $tag;
    }
}
