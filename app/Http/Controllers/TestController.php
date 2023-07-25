<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class TestController
{
    public function test(): JsonResponse
    {
        return response()->json([
            'status' => 'okay staging'
        ]);
    }
}
