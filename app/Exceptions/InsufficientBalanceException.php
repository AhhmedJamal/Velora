<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InsufficientBalanceException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->getMessage() ?: 'رصيدك غير كافي لإتمام هذه العملية.',
        ], 422);
    }
}