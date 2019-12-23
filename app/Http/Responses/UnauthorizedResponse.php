<?php

namespace App\Http\Responses;

class UnauthorizedResponse extends BaseResponse
{
    protected $message = 'Unauthorized';

    protected $data;

    protected $statusCode = 401;
}
