<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class TestController
{
    public function test(): JsonResponse
    {
        $a = User::first();
        return response()->json([
            'a' => $a?->id,
            'status' => 'okay staging'
        ]);
    }
}
