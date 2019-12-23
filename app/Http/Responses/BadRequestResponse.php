<?php

namespace App\Http\Responses;

class BadRequestResponse extends BaseResponse
{
    /**
     * @var string
     */
    protected $message = 'Bad Request';

    /**
     * @var null|object
     */
    protected $data;

    /**
     * @var int
     */
    protected $statusCode = 400;
}
