<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $products = $user->products()->withCount("items")->get();
        return response()->json([
            "products" => ProductResource::collection($products)
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $product = Product::query()->create([
            "type" => $request->input("type"),
            "user_id" => $request->user()->id,
        ]);

        return response()->json([
           "product" => ProductResource::make($product)
       ]);
    }
}
