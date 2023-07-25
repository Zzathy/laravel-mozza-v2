@extends('base')

@section('title', 'Pelanggan')
@section('customer', 'active')

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Data Pelanggan</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="d-flex justify-content-between card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary align-self-center">Tabel Data Pelanggan</h6>
                <!-- Button trigger modal -->
                <button type="button float-right" class="btn btn-success" data-toggle="modal" data-target="#createCustomer">
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
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->customer_code }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone_number }}</td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-warning btn-circle btn-sm" data-toggle="modal"
                                            data-target="#updateCustomer{{ $customer->customer_code }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        |
                                        <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal"
                                            data-target="#deleteCustomer{{ $customer->customer_code }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Customer Update Modal -->
                                <div class="modal fade" id="updateCustomer{{ $customer->customer_code }}"
                                    data-backdrop="static" data-keyboard="false" tabindex="-1"
                                    aria-labelledby="updateCustomerLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateCustomerLabel">Ubah Pelanggan</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('customer.update', $customer->customer_code) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name">Nama Pelanggan</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="name" value="{{ $customer->name }}" autocomplete="off"
                                                            required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">Alamat Pelanggan</label>
                                                        <input type="text" class="form-control" name="address"
                                                            id="address" value="{{ $customer->address }}"
                                                            autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email Pelanggan</label>
                                                        <input type="email" class="form-control" name="email"
                                                            id="email" value="{{ $customer->email }}"
                                                            autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone_number">Nomor Pelanggan</label>
                                                        <input type="text" class="form-control" name="phone_number"
                                                            id="phone_number" value="{{ $customer->phone_number }}"
                                                            autocomplete="off">
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

                                <!-- Customer Delete Modal -->
                                <div class="modal fade" id="deleteCustomer{{ $customer->customer_code }}"
                                    data-backdrop="static" data-keyboard="false" tabindex="-1"
                                    aria-labelledby="deleteCustomerLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteCustomerLabel">Hapus Pelanggan</h5>
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
                                                <form action="{{ route('customer.delete', $customer->customer_code) }}"
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

    <!-- Customer Create Modal -->
    <div class="modal fade" id="createCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="createCustomerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCustomerLabel">Tambah Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('customer.create') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="name" id="name" autocomplete="off"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat Pelanggan</label>
                            <input type="text" class="form-control" name="address" id="address"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Pelanggan</label>
                            <input type="email" class="form-control" name="email" id="email"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Nomor Pelanggan</label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number"
                                autocomplete="off">
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
