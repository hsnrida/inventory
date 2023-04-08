<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ProductResource;
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
}
