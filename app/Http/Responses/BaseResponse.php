<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

abstract class BaseResponse
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var null|Object
     */
    protected $data;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * BaseResponse constructor.
     *
     * @param null $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * @return JsonResponse
     */
    public function getResult(): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
            'data'    => $this->data,
        ], $this->statusCode);
    }
}
