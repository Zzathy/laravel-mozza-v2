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
            'manufacturers' => Manufacturer::all(),
            'products' => Product::with('type', 'manufacturer')->get(),
            'types' => Type::all()
        ];

        return view('product', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $code = 'PRDCT';
        $product = Product::orderBy('created_at', 'desc')->first();

        if(!is_null($product)) {
            $product_code = $code.strval($product->product_id + 1);
        } else {
            $product_code = $code.'1';
        }

        Product::create([
            'product_code' => $product_code,
            'name' => $request->name,
            'description' => $request->description,
            'manufacturer_foreign' => $request->manufacturer,
            'type_foreign' => $request->type,
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
        Product::where('product_code', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'manufacturer_foreign' => $request->manufacturer,
            'type_foreign' => $request->type,
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
        $product = Product::where('product_code', $id)->delete();

        return redirect()->route('product.index');
    }
}
