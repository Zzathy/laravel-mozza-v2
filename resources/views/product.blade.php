@extends('base')

@section('title', 'Produk')
@section('product', 'active')

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Data Produk</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="d-flex justify-content-between card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary align-self-center">Tabel Data Produk</h6>
                <!-- Button trigger modal -->
                <button type="button float-right" class="btn btn-success" data-toggle="modal" data-target="#createProduct">
                    Create
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Jenis</th>
                                <th>Produsen</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Jenis</th>
                                <th>Produsen</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->product_code }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->type->name }}</td>
                                    <td>{{ $product->manufacturer->name }}</td>
                                    <td>{{ number_format($product->base_price, 2, ',', '.') }}</td>
                                    <td>{{ number_format($product->sell_price, 2, ',', '.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-warning btn-circle btn-sm" data-toggle="modal"
                                            data-target="#updateProduct{{ $product->product_code }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        |
                                        <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal"
                                            data-target="#deleteProduct{{ $product->product_code }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Product Update Modal -->
                                <div class="modal fade" id="updateProduct{{ $product->product_code }}"
                                    data-backdrop="static" data-keyboard="false" tabindex="-1"
                                    aria-labelledby="updateProductLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateProductLabel">Ubah Produk</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('product.update', $product->product_code) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name">Nama Produk</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="name" value="{{ $product->name }}" autocomplete="off"
                                                            required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Deskripsi Produk</label>
                                                        <input type="text" class="form-control" name="description"
                                                            id="description" value="{{ $product->description }}"
                                                            autocomplete="off">
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="type">Jenis</label>
                                                            <select id="type" name="type" class="form-control">
                                                                <option value="0">Pilih...</option>
                                                                @foreach ($types as $type)
                                                                    <option value="{{ $type->type_id }}"
                                                                        {{ $type->type_id == $product->type_foreign ? 'selected' : '' }}>
                                                                        {{ $type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="manufacturer">Produsen</label>
                                                            <select id="manufacturer" name="manufacturer"
                                                                class="form-control">
                                                                <option value="0">Pilih...</option>
                                                                @foreach ($manufacturers as $manufacturer)
                                                                    <option value="{{ $manufacturer->manufacturer_id }}"
                                                                        {{ $manufacturer->manufacturer_id == $product->manufacturer_foreign ? 'selected' : '' }}>
                                                                        {{ $manufacturer->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label for="base_price">Harga Pokok</label>
                                                            <input type="number" class="form-control" name="base_price"
                                                                id="base_price" value="{{ $product->base_price }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="sell_price">Harga Jual</label>
                                                            <input type="number" class="form-control" name="sell_price"
                                                                id="sell_price" value="{{ $product->sell_price }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="stock">Stok</label>
                                                            <input type="number" class="form-control" name="stock"
                                                                id="stock" step="0.1"
                                                                value="{{ $product->stock }}" required>
                                                        </div>
                                                    </div>
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

                                <!-- Product Delete Modal -->
                                <div class="modal fade" id="deleteProduct{{ $product->product_code }}"
                                    data-backdrop="static" data-keyboard="false" tabindex="-1"
                                    aria-labelledby="deleteProductLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteProductLabel">Hapus Produk</h5>
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
                                                <form action="{{ route('product.delete', $product->product_code) }}"
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

    <!-- Product Create Modal -->
    <div class="modal fade" id="createProduct" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="createProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductLabel">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('product.create') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" class="form-control" name="name" id="name" autocomplete="off"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi Produk</label>
                            <input type="text" class="form-control" name="description" id="description"
                                autocomplete="off">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="manufacturer">Produsen</label>
                                <select id="manufacturer" name="manufacturer" class="form-control">
                                    <option>Pilih...</option>
                                    @foreach ($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->manufacturer_id }}">{{ $manufacturer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type">Jenis</label>
                                <select id="type" name="type" class="form-control">
                                    <option>Pilih...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->type_id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="base_price">Harga Pokok</label>
                                <input type="number" class="form-control" name="base_price" id="base_price" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sell_price">Harga Jual</label>
                                <input type="number" class="form-control" name="sell_price" id="sell_price" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="stock">Stok</label>
                                <input type="number" class="form-control" name="stock" id="stock" step="0.1"
                                    required>
                            </div>
                        </div>
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
