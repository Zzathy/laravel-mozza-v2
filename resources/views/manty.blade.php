    @extends('base')

    @section('title', 'Type & Manufacturer')
    @section('manty', 'active')

    @section('css')
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection

    @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data Manufacturer & Type</h1>
            <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                For more information about DataTables, please visit the <a target="_blank"
                    href="https://datatables.net">official
                    DataTables documentation</a>.</p>

            <div class="row">
                <div class="col">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="d-flex justify-content-between card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary align-self-center">Tabel Data Manufacturer</h6>
                            <!-- Button trigger modal -->
                            <button type="button float-right" class="btn btn-success" data-toggle="modal"
                                data-target="#createManufacturer">
                                Create
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($manufacturers as $manufacturer)
                                            <tr>
                                                <td>{{ $manufacturer->name }}</td>
                                                <td>{{ $manufacturer->email }}</td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-warning btn-circle btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#updateManufacturer{{ $manufacturer->id }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                    |
                                                    <button type="button" class="btn btn-danger btn-circle btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#deleteManufacturer{{ $manufacturer->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Manufacturer Update Modal -->
                                            <div class="modal fade" id="updateManufacturer{{ $manufacturer->id }}"
                                                data-backdrop="static" data-keyboard="false" tabindex="-1"
                                                aria-labelledby="updateManufacturerLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateManufacturerLabel">Update
                                                                Manufacturer</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('manty.update', $manufacturer->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="mode" value="manufacturer">
                                                                <div class="form-group">
                                                                    <label for="name">Nama Manufacturer</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" id="name"
                                                                        value="{{ $manufacturer->name }}"
                                                                        autocomplete="off">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input type="text" class="form-control"
                                                                        name="email" id="email"
                                                                        value="{{ $manufacturer->email }}"
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

                                            <!-- Manufacturer Delete Modal -->
                                            <div class="modal fade" id="deleteManufacturer{{ $manufacturer->id }}"
                                                data-backdrop="static" data-keyboard="false" tabindex="-1"
                                                aria-labelledby="deleteManufacturerLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteManufacturerLabel">Delete
                                                                Manufacturer</h5>
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
                                                            <form action="{{ route('manty.delete', $manufacturer->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <input type="hidden" name="mode"
                                                                    value="manufacturer">
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
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
                <div class="col">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="d-flex justify-content-between card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary align-self-center">Tabel Data Type</h6>
                            <!-- Button trigger modal -->
                            <button type="button float-right" class="btn btn-success" data-toggle="modal"
                                data-target="#createType">
                                Create
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($types as $type)
                                            <tr>
                                                <td>{{ $type->name }}</td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-warning btn-circle btn-sm"
                                                        data-toggle="modal" data-target="#updateType{{ $type->id }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                    |
                                                    <button type="button" class="btn btn-danger btn-circle btn-sm"
                                                        data-toggle="modal" data-target="#deleteType{{ $type->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Type Update Modal -->
                                            <div class="modal fade" id="updateType{{ $type->id }}"
                                                data-backdrop="static" data-keyboard="false" tabindex="-1"
                                                aria-labelledby="updateTypeLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateTypeLabel">Update Type</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('manty.update', $type->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="mode" value="type">
                                                                <div class="form-group">
                                                                    <label for="name">Nama Jenis</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" id="name"
                                                                        value="{{ $type->name }}" autocomplete="off">
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

                                            <!-- Type Delete Modal -->
                                            <div class="modal fade" id="deleteType{{ $type->id }}"
                                                data-backdrop="static" data-keyboard="false" tabindex="-1"
                                                aria-labelledby="deleteTypeLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteTypeLabel">Delete Type</h5>
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
                                                            <form action="{{ route('manty.delete', $type->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <input type="hidden" name="mode" value="type">
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
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
            </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Manufacturer Create Modal -->
        <div class="modal fade" id="createManufacturer" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="createManufacturerLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createManufacturerLabel">Tambah Manufacturer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('manty.create') }}" method="post">
                            @csrf
                            <input type="hidden" name="mode" value="manufacturer">
                            <div class="form-group">
                                <label for="name">Nama Satuan</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
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

        <!-- Type Create Modal -->
        <div class="modal fade" id="createType" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="createTypeLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTypeLabel">Tambah Jenis</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('manty.create') }}" method="post">
                            @csrf
                            <input type="hidden" name="mode" value="type">
                            <div class="form-group">
                                <label for="name">Nama Jenis</label>
                                <input type="text" class="form-control" name="name" id="name"
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
