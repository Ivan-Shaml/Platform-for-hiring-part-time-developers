<?php

namespace App\Http\Requests\Api;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DeveloperApiRequest extends \App\Http\Requests\DeveloperRequest
{
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(new Response([
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], ResponseAlias::HTTP_BAD_REQUEST));
    }
}
