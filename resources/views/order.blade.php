@extends('base')

@section('title', 'Transaksi')
@section('order', 'active')

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Data Transaksi</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="d-flex justify-content-between card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary align-self-center">Tabel Data Transaksi</h6>
                <!-- Button trigger modal -->
                <button type="button float-right" class="btn btn-success" data-toggle="modal" data-target="#createOrder">
                    Create
                </button>
                <a href="{{ route('order.pdf') }}" class="btn btn-primary">Download</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ number_format($order->total, 2, ',', '.') }}</td>

                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success btn-circle btn-sm" data-toggle="modal"
                                            data-target="#detailOrder{{ $order->order_code }}">
                                            <i class="fas fa-info"></i>
                                        </button>
                                        |
                                        <button type="button" class="btn btn-warning btn-circle btn-sm" data-toggle="modal"
                                            data-target="#updateOrder{{ $order->order_code }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        |
                                        <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal"
                                            data-target="#deleteOrder{{ $order->order_code }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Order Detail Modal -->
                                <div class="modal fade" id="detailOrder{{ $order->order_code }}" data-backdrop="static"
                                    data-keyboard="false" tabindex="-1" aria-labelledby="detailOrderLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailOrderLabel">Detail Transaksi</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                    $orderDetails = \App\Models\OrderDetail::where('order_foreign', $order->order_id)->get();
                                                @endphp
                                                @foreach ($orderDetails as $orderDetail)
                                                    @php
                                                        $product = \App\Models\Product::where('product_id', $orderDetail->product_foreign)->first();
                                                    @endphp
                                                    <div class="form-group">
                                                        <label for="name">Nama Barang</label>
                                                        <input type="text" name="name" id="name"
                                                            class="form-control" value="{{ $product->name }}" readonly>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label for="">Harga Barang</label>
                                                            <input type="text" name="" id=""
                                                                class="form-control"
                                                                value="{{ number_format($product->sell_price, 2, ',', '.') }}"
                                                                readonly>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="">Kuantitas</label>
                                                            <input type="text" name="" id=""
                                                                class="form-control" value="{{ $orderDetail->quantity }}"
                                                                readonly>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="">Total</label>
                                                            <input type="text" name="" id=""
                                                                class="form-control"
                                                                value="{{ number_format($orderDetail->quantity * $product->sell_price, 2, ',', '.') }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Update Modal -->
                                <div class="modal fade" id="updateOrder{{ $order->order_code }}" data-backdrop="static"
                                    data-keyboard="false" tabindex="-1" aria-labelledby="updateOrderLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateOrderLabel">Ubah Transaksi</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('order.update', $order->order_code) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="customer">Pelanggan</label>
                                                        <select id="customer" name="customer" class="form-control">
                                                            <option>Pilih...</option>
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->customer_id }}"
                                                                    {{ $customer->customer_id == $order->customer_foreign ? 'selected' : '' }}>
                                                                    {{ $customer->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @foreach ($orderDetails as $orderDetail)
                                                        <input type="hidden" name="order_detail_code[]"
                                                            value="{{ $orderDetail->order_detail_code }}">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="name">Nama Produk & Harga</label>
                                                                <input class="form-control" list="datalistProducts"
                                                                    name="products[]" placeholder="Type to search..."
                                                                    autocomplete="off">
                                                                <datalist id="datalistProducts">
                                                                    @foreach ($products as $product)
                                                                        <option
                                                                            value="{{ $product->name . ' | ' . number_format($product->sell_price, 2, ',', '.') }}">
                                                                    @endforeach
                                                                </datalist>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="quantity">Kuantitas</label>
                                                                <input type="number" class="form-control"
                                                                    name="quantity[]" id="quantity" step="0.1"
                                                                    value="{{ $orderDetail->quantity }}">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Delete Modal -->
                                <div class="modal fade" id="deleteOrder{{ $order->order_code }}" data-backdrop="static"
                                    data-keyboard="false" tabindex="-1" aria-labelledby="deleteOrderLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteOrderLabel">Hapus Transaksi</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah anda yakin ingin menghapus data ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <form action="{{ route('order.delete', $order->order_code) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- Order Create Modal -->
    <div class="modal fade" id="createOrder" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="createOrderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createOrderLabel">Tambah Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('order.create') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="customer">Pelanggan</label>
                            <select id="customer" name="customer" class="form-control">
                                <option>Pilih...</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->customer_id }}">{{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @for ($i = 0; $i < 10; $i++)
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nama Produk & Harga</label>
                                    <input class="form-control" list="datalistProducts" name="products[]"
                                        placeholder="Type to search..." autocomplete="off">
                                    <datalist id="datalistProducts">
                                        @foreach ($products as $product)
                                            <option
                                                value="{{ $product->name . ' | ' . number_format($product->sell_price, 2, ',', '.') }}">
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="quantity">Kuantitas</label>
                                    <input type="number" class="form-control" name="quantity[]" id="quantity"
                                        step="0.1">
                                </div>
                            </div>
                        @endfor
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
