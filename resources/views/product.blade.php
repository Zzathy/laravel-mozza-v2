@extends('base')

@section('title', 'Barang')
@section('product', 'active')

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Data Product</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="d-flex justify-content-between card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary align-self-center">Tabel Data Product</h6>
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
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Jenis</th>
                                <th>Manufacturer</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Jenis</th>
                                <th>Manufacturer</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->type->name }}</td>
                                    <td>{{ $product->manufacturer->name }}</td>
                                    <td>{{ $product->base_price }}</td>
                                    <td>{{ $product->sell_price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-warning btn-circle btn-sm" data-toggle="modal"
                                            data-target="#updateProduct{{ $product->id }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        |
                                        <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal"
                                            data-target="#deleteProduct{{ $product->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Product Update Modal -->
                                <div class="modal fade" id="updateProduct{{ $product->id }}" data-backdrop="static"
                                    data-keyboard="false" tabindex="-1" aria-labelledby="updateProductLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateProductLabel">Ubah Barang</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('product.update', $product->id) }}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name">Nama Barang</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="name" value="{{ $product->name }}" autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Deskripsi Barang</label>
                                                        <input type="text" class="form-control" name="description"
                                                            id="description" value="{{ $product->description }}"
                                                            autocomplete="off">
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="manufacturer">Manufacturer</label>
                                                            <select id="manufacturer" name="manufacturer"
                                                                class="form-control">
                                                                <option>Choose...</option>
                                                                @foreach ($manufacturers as $manufacturer)
                                                                    <option value="{{ $manufacturer->id }}"
                                                                        {{ $manufacturer->id == $product->manufacturer_id ? 'selected' : '' }}>
                                                                        {{ $manufacturer->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="type">Jenis</label>
                                                            <select id="type" name="type" class="form-control">
                                                                <option>Choose...</option>
                                                                @foreach ($types as $type)
                                                                    <option value="{{ $type->id }}"
                                                                        {{ $type->id == $product->type_id ? 'selected' : '' }}>
                                                                        {{ $type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label for="base_price">Harga Pokok</label>
                                                            <input type="number" class="form-control" name="base_price"
                                                                id="base_price" value="{{ $product->base_price }}">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="sell_price">Harga Jual</label>
                                                            <input type="number" class="form-control" name="sell_price"
                                                                id="sell_price" value="{{ $product->sell_price }}">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="stock">Stok</label>
                                                            <input type="number" class="form-control" name="stock"
                                                                id="stock" step="0.1"
                                                                value="{{ $product->stock }}">
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
                                <div class="modal fade" id="deleteProduct{{ $product->id }}" data-backdrop="static"
                                    data-keyboard="false" tabindex="-1" aria-labelledby="deleteProductLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteProductLabel">Hapus Barang</h5>
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
                                                <form action="{{ route('product.delete', $product->id) }}"
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
                    <h5 class="modal-title" id="createProductLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('product.create') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Barang</label>
                            <input type="text" class="form-control" name="name" id="name"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi Barang</label>
                            <input type="text" class="form-control" name="description" id="description"
                                autocomplete="off">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="manufacturer">Manufacturer</label>
                                <select id="manufacturer" name="manufacturer" class="form-control">
                                    <option>Choose...</option>
                                    @foreach ($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type">Jenis</label>
                                <select id="type" name="type" class="form-control">
                                    <option>Choose...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="base_price">Harga Pokok</label>
                                <input type="number" class="form-control" name="base_price" id="base_price">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sell_price">Harga Jual</label>
                                <input type="number" class="form-control" name="sell_price" id="sell_price">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="stock">Stok</label>
                                <input type="number" class="form-control" name="stock" id="stock"
                                    step="0.1">
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
