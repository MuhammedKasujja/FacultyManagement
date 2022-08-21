<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Validator;

class Helper{

  public static function routefreestring($string)
{

    $string = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $string));

    $search = [' ', '&', '%', "?", '=', '{', '}', '$'];

    $replace = ['-', '-', '-', '-', '-', '-', '-', '-'];

    $string = str_replace($search, $replace, $string);

    return $string;
}

public static function custom_validator($request, $request_inputs, $custom_errors = [])
    {
        $validator = Validator::make($request, $request_inputs, $custom_errors);

        if ($validator->fails()) {
            $error = implode(',', $validator->errors()->all());

            throw new Exception($error, 101);
        }
    }

}