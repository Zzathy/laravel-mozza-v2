<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Type;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $context = [
            'customers' => Customer::all(),
            'orders' => Order::all(),
            'orderDetails' => OrderDetail::all(),
            'products' => Product::all(),
        ];
        return view('order', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $codeORD = 'ORD';
        $codeORDDTL = 'ORDDTL';
        $customer = Customer::select('customer_id')->where('customer_id', $request->customer)->first();
        $order = Order::orderBy('created_at', 'desc')->first();
        $total = 0;

        if(!is_null($order)) {
            $order_code = $codeORD.strval($order->order_id + 1);
        } else {
            $order_code = $codeORD.'1';
        }

        $order = Order::create([
            'order_code' => $order_code,
            'customer_foreign' => $customer->customer_id,
            'total' => 0
        ]);

        for($i = 0; $i < count($request->products); $i++) {
            $name = explode(' | ', $request->products[$i]);
            $orderDetail = OrderDetail::orderBy('created_at', 'desc')->first();
            $product = Product::select('product_id', 'sell_price', 'stock')->where('name', $name[0])->first();

            if(!is_null($orderDetail)) {
                $order_detail_code = $codeORDDTL.strval($orderDetail->order_detail_id + 1);
            } else {
                $order_detail_code = $codeORDDTL.'1';
            }

            if(!is_null($product)) {
                $total += intval($request->quantity[$i]) * $product->sell_price;

            OrderDetail::create([
                'order_detail_code' => $order_detail_code,
                'order_foreign' => $order->order_id,
                'product_foreign' => $product->product_id,
                'quantity' => $request->quantity[$i],
            ]);

            $product->stock -= $request->quantity[$i];
            $product->save();
            }
        }

        $order->total = $total;
        $order->save();

        return redirect()->route('order.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $total = 0;

        for($i = 0; $i < count($request->products); $i++) {
            $name = explode(' | ', $request->products[$i]);
            $orderDetail = OrderDetail::where('order_detail_code', $request->order_detail_code[$i])->first();
            $product = Product::select('product_id', 'sell_price', 'stock')->where('name', $name[0])->first();

            if($orderDetail->product_foreign != $product->product_id || $orderDetail->quantity != $request->quantity[$i]) {
                $product->stock += $orderDetail->quantity;
                $product->save();
            }

            $total += intval($request->quantity[$i]) * $product->sell_price;

            $orderDetail->product_foreign = $product->product_id;
            $orderDetail->quantity = $request->quantity[$i];
            $orderDetail->save();

            $product->stock -= $request->quantity[$i];
            $product->save();
        }

        Order::where('order_code', $id)->update([
            'total' => $total
        ]);

        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $order = Order::where('order_code', $id)->first();
        $orderDetails = OrderDetail::where('order_foreign', $order->order_id)->get();
        foreach($orderDetails as $orderDetail) {
            $product = Product::where('product_id', $orderDetail->product_foreign)->first();
            $product->stock += $orderDetail->quantity;
            $product->save();
            $orderDetail->delete();
        }
        $order->delete();

        return redirect()->route('order.index');
    }

    public function pdf() {
        $date = date('Y') . "-" . date('m') ."-01 00:00:00";
        $orders = Order::where('created_at', '>', $date)->get();

        $context = [
            'orders' => $orders
        ];

        $pdf = Pdf::loadView('pdf', $context);
        return $pdf->download(date('Y') . '-' . date('m') . '.pdf');
    }
}
