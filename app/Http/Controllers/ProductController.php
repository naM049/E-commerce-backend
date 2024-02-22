<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index()
    {
        return ProductResource::collection(Product::paginate());
    }

    public function store(ProductRequest $request)
    {
        return new ProductResource(Product::create($request->validated()));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'price' => ['numeric'],
            'units_in_stock' => ['numeric','integer'],
            'category_id' => ['numeric','exists:categories,id'],
        ]);

        $product->update([
            'name' => $request->name ?? $product->name,
            'description' => $request->description ?? $product->description,
            'price' => $request->price ?? $product->price,
            'units_in_stock' => $request->units_in_stock ?? $product->units_in_stock,
            'category_id' => $request->category_id ?? $product->category_id,
        ]);

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json();
    }
}
