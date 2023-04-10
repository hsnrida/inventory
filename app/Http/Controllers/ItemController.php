<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function all(Product $product): JsonResponse
    {
        return response()->json([
            "items" => ItemResource::collection($product->items()->get())
        ]);
    }

    public function sold(Product $product, Item $item): JsonResponse
    {
        $item->update([
            "sold" => true
        ]);
        return response()->json();
    }

    public function store(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            "items" => ["required", "array"],
            "items.*.serial_number" => ["required", "numeric"],
        ]);

        $items = $request->input("items");
        foreach ($items as $item) {
            Item::query()->create([
                "serial_number" => data_get($item, "serial_number"),
                "product_id" => $product->id,
            ]);
        }

        return response()->json();
    }

    public function delete(Product $product, Item $item): JsonResponse
    {
        $item->delete();
        return response()->json();
    }
}
