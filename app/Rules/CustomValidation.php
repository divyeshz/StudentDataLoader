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
        if (request()->export_type === 'file') {
            // Check if the value exists as a UUID in the FileReference table
            // return FileReference::where('id', $value)->exists();
            $fail('The email format is invalid.');
        } elseif (request()->export_type === 'class') {
            // Validate numeric value between 1 and 12
            // return is_numeric($value) && $value >= 1 && $value <= 12;
            $fail('The email format is invalid.');
        } else {
            return false;
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('The email format is invalid.');
        }
    }
}
