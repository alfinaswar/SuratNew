@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="mb-0">Daftar Surat Untuk Diverifikasi</h4>
            {{-- Tombol tambah dinonaktifkan untuk verifikator --}}
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                {{-- Data akan diisi oleh DataTables --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <script>
            setTimeout(function () {
                Swal.fire({
                    title: "Berhasil!",
                    text: "{!! \Session::get('success') !!}",
                    icon: "success"
                });
            }, 1000);
        </script>
    @endif

    <script>
        $(document).ready(function () {
            var dataTable = function () {
                var table = $('#datatable');
                table.DataTable({
                    responsive: true,
                    serverSide: true,
                    bDestroy: true,
                    processing: true,
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Memuat...</span> ',
                        paginate: {
                            next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                            previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                        },
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ entri",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                        zeroRecords: "Tidak ada data ditemukan",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                        infoFiltered: "(disaring dari _MAX_ total entri)"
                    },
                    ajax: "{{ route('verifikator.index') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center' },
                        { data: 'NomorSurat', name: 'NomorSurat' },
                        { data: 'Perihal', name: 'Perihal' },
                        { data: 'StatusLabel', name: 'StatusLabel', className: 'text-center' },
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
                    ]
                });
            };
            dataTable();
            $(".multi-select").select2();
        });
    </script>
@endsection