<?php

namespace App\Exceptions;

use App\Traits\Respondable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicationException extends Exception
{
    use Respondable;

    /**
     * Render the exception into an HTTP response.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        $code = $this->getCode();
        $message = $this->getMessage();
        return $this->error(null, $message, $code);
    }
}
