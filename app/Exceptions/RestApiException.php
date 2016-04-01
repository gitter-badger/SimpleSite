<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Arrayable;

class RestApiControllerException extends \Exception implements Arrayable
{

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
}