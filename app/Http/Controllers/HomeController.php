<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        dd("test");
        return response()->json();
    }
}
