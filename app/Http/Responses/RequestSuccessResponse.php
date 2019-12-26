<?php

namespace App\Http\Responses;

class RequestSuccessResponse extends BaseResponse
{
    /**
     * @var string
     */
    protected $message = 'Response success';

    /**
     * @var null|object
     */
    protected $data;

    /**
     * @var int
     */
    protected $statusCode = 200;
}
