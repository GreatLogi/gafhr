<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DepartureDateRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $arrivalDate;

    public function __construct($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $departureDate = new \DateTime($value);
        $arrivalDate = new \DateTime($this->arrivalDate);

        return $departureDate <= $arrivalDate;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The departure date cannot be ahead of the arrival date.';
    }
}
