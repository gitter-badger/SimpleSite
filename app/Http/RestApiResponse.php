<?php

namespace App\Http;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestApiResponse
{

    const TYPE_ERROR = 'error';
    const TYPE_CONTENT = 'content';
    const TYPE_REDIRECT = 'redirect';

    /**
     * @param Request    $request
     * @param \Exception $exception
     *
     * @return static
     */
    public static function createFromException(Request $request, \Exception $exception)
    {
        $data = [
            'code'    => $exception->getCode(),
            'type'    => static::TYPE_ERROR,
            'message' => $exception->getMessage(),
        ];

        if ($exception instanceof Arrayable) {
            $data = array_merge($data, $exception->toArray());
        }

        $response = new static($request, $data, $exception->getCode());

        return $response->sendResponse();
    }

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $code;

    /**
     * Response constructor.
     *
     * @param Request $request
     * @param array   $data
     * @param int     $code
     */
    public function __construct(Request $request, array $data, int $code = 200)
    {
        $this->request = $request;
        $this->data    = $data;
        $this->code    = $code;
    }

    /**
     * @return JsonResponse
     */
    protected function sendResponse()
    {
        return new JsonResponse($this->data, $this->code, [
            'Content-Type' => 'application/json',
        ]);
    }
}