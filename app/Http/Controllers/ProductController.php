<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Type;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $context = [
            'manufacturers' => Manufacturer::select('id', 'name')->get(),
            'products' => Product::with('type', 'manufacturer')->get(),
            'types' => Type::select('id', 'name')->get()
        ];
        return view('product', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'type_id' => $request->type,
            'manufacturer_id' => $request->manufacturer,
            'base_price' => $request->base_price,
            'sell_price' => $request->sell_price,
            'stock' => $request->stock
        ]);

        return redirect()->route('product.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Product::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'type_id' => $request->type,
            'manufacturer_id' => $request->manufacturer,
            'base_price' => $request->base_price,
            'sell_price' => $request->sell_price,
            'stock' => $request->stock
        ]);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Product $product, $id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('product.index');
    }
}
