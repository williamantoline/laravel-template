<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TestController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'yea',
        ]);
    }
}
