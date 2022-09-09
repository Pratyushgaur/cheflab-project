<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VendorOrderTimeRule implements Rule
{
    protected $request_data = [];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request_data)
    {
        $this->request_data = $request_data;
        //
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
        $get_index = explode('.', $attribute); //attribut==available.0
        // dd($value);
        if ($value == 1) {
            // echo $value;
            if (isset($get_index[1])) {
                if ($this->request_data->start_time[$get_index[1]] != '' && $this->request_data->end_time[$get_index[1]] != '')
                    return true;
            }
        } else{
            // dd("here");
            return true;
        }


        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // return 'Please provide both "opening time" and "closing time". :attribute ';
        return 'Please provide both "opening time" and "closing time".';
    }
}
