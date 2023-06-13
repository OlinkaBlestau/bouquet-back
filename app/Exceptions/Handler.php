<?php

namespace App\Exceptions;

use App\Validators\UserValidator;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Prettus\Validator\Exceptions\ValidatorException;
use Throwable;

class Handler extends ExceptionHandler
{

    public function report(Throwable $exception): void
    {
        if ($exception instanceof ValidatorException) {
            $message = json_encode([
                'error' => true,
                'messages' => $exception->getMessageBag()
            ]);

            throw new HttpResponseException(
                response($message, 422)
            );
        }

        parent::report($exception);
    }


}
