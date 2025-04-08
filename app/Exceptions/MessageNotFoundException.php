<?php

namespace App\Exceptions;

use Exception;

class MessageNotFoundException extends Exception
{
    protected $messageName;

    public function __construct($messageName = null)
    {
        $this->messageName = $messageName;

        $message = "{$messageName} no encontrado.";

        parent::__construct($message);
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage()
        ], 404);
    }
}