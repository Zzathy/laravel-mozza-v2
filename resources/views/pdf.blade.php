<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Laporan Transaksi Bulanan</h1>
    <br>
    <table style="width: 100%; margin: auto;">
        <tr>
            <th rowspan="2">Tanggal</th>
            <th colspan="2">Kode</th>
            <th colspan="3">Produk</th>
            <th rowspan="2">Jumlah</th>
        </tr>
        <tr>
            <th>Kode Transaksi</th>
            <th>Kode Produk</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Kuantitas</th>
        </tr>
        @php
            $total = 0;
        @endphp
        @foreach ($orders as $order)
            @php
                $orderDetails = \App\Models\OrderDetail::where('order_foreign', $order->order_id)->get();
            @endphp
            <tr style="text-align: center;">
                <td rowspan="{{ count($orderDetails) + 1 }}">{{ $order->created_at }}</td>
                <td rowspan="{{ count($orderDetails) + 1 }}">{{ $order->order_code }}</td>
                @foreach ($orderDetails as $orderDetail)
                    @php
                        $product = \App\Models\Product::where('product_id', $orderDetail->product_foreign)->first();
                    @endphp
            <tr style="text-align: center;">
                <td>{{ $product->product_code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->sell_price, 2, '.', ',') }}</td>
                <td>{{ number_format($orderDetail->quantity, 2, '.', ',') }}</td>
                <td>{{ number_format($product->sell_price * $orderDetail->quantity, 2, '.', ',') }}</td>
                @php
                    $total += $product->sell_price * $orderDetail->quantity;
                @endphp
            </tr>
        @endforeach
        </tr>
        @endforeach
        <tr>
            <th colspan="6">Total</th>
            <th>{{ number_format($total, 2, '.', ',') }}</th>
        </tr>
    </table>
</body>

</html>
