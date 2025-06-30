@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-4 flex-wrap">
        {{-- <a href="{{ route('persetujuan-surat.create') }}" class="btn btn-primary me-3 btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Persetujuan
        </a> --}}
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Persetujuan Surat</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="text-center">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Status Persetujuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
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
                swal.fire({
                    title: "Berhasil!",
                    text: "{!! \Session::get('success') !!}",
                    icon: "success"
                });
            }, 500);
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
                    ajax: "{{ route('persetujuan-surat.index') }}",
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'NomorSurat',
                            name: 'NomorSurat'
                        },
                        {
                            data: 'Perihal',
                            name: 'Perihal'
                        },
                        {
                            data: 'StatusLabel',
                            name: 'StatusLabel'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            };
            dataTable();

        });
    </script>
@endsection