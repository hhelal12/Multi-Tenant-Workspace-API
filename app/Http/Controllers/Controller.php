<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Controller
{
     protected function success($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    protected function created($data)
    {
        return response()->json($data, 201);
    }

    // Error responses
    protected function unauthorized($message = 'Unauthorized')
    {
        return response()->json(['message' => $message], 401);
    }
    protected function badRequest($message = 'Bad request')
    {
        return response()->json(['message' => $message], 400);
    }

    protected function forbidden($message = 'Forbidden')
    {
        return response()->json(['message' => $message], 403);
    }

    protected function notFound($message = 'Not found')
    {
        return response()->json(['message' => $message], 404);
    }

    protected function serverError($message = 'Server error')
    {
        return response()->json(['message' => $message], 500);
    }
}
