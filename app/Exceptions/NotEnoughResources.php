<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class NotEnoughResources extends Exception
{
    public function __construct($id, $type)
    {
        parent::__construct("Not enough $type $id at system storage", Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
