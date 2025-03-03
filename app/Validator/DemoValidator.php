<?php

namespace App\Validator;

use Illuminate\Support\Facades\Validator;

class DemoValidator
{
    public static function update($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
            ],
            [
                'id.required' => 'Please enter your id.',
            ]
        );

        return $validator;
    }

}
