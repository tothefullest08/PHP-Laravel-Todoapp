<?php

namespace App\Http\Responses;

class CreateSuccessResponse extends BaseResponse
{
    /**
     * @var string
     */
    protected $message = 'create success';

    /**
     * @var null|object
     */
    protected $data;

    /**
     * @var int
     */
    protected $statusCode = 201;
}
