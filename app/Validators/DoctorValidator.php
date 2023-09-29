<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorValidator
{
    public function validate(Request $request)
    {
        $request->validate([
            $request->name => 'required|string',
            $request->email => 'required|email|unique:doctors,email',
            $request->password => 'required|string|min:8',
            $request->phone => 'required|string',
            $request->section => 'required|string',
            //$request->appointments => 'required|array',
            $request->price => 'required|numeric',

        ]);

    }

}
