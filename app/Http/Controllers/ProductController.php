<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Type;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manufacturers = Manufacturer::with('id', 'name')->get();
        $products = Product::with('type', 'manufacturer')->get();
        $types = Type::with('id', 'name')->get();

        $context = [
            'manufacturers' => $manufacturers,
            'products' => $products,
            'types' => $types
        ];

        return view('admin.product', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'type' => $request->type,
            'manufacturer' => $request->manufacturer,
            'base_price' => $request->base_price,
            'sell_price' => $request->sell_price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.product.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product, $id)
    {
        Product::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'manufacturer' => $request->manufacturer,
            'base_price' => $request->base_price,
            'sell_price' => $request->sell_price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('admin.product.index');
    }
}
