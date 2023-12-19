<?php

namespace App\Rules;

use Closure;
use App\Models\FileReference;
use Illuminate\Contracts\Validation\ValidationRule;

class CustomValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

    }
}
