<?php

namespace App\Rules;

use App\Models\Artist;
use App\Models\Organizer;
use App\Models\Venue;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class TagExists implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dbEntry = Venue::where('tag', $value)->get();
        $dbEntry = $dbEntry->merge(Organizer::where('tag', $value)->get());
        $dbEntry = $dbEntry->merge(Artist::where('tag', $value)->get());

        if ($dbEntry->isEmpty()) {
            $fail("This :attribute does not exist");
        }
    }
}
