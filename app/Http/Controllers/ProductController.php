<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $products = $user->products()->withCount(["items" =>
            fn(Builder $q) => $q->where("sold", 0)]
        )->get();
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

    public function edit(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            "type" => ["required", "string"]
        ]);
        $product->update([
            "type" => $request->input("type")
        ]);
        return response()->json();
    }

    public function delete(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json();
    }
}
