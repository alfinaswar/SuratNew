@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-4 flex-wrap">
        <a href="{{ route('drafter.create') }}" class="btn btn-primary me-3 btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Surat
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Surat</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="20%">Nomor</th>
                                    <th width="25%">Perihal</th>
                                    <th width="15%">Ajukan</th>
                                    <th>Status</th>
                                    <th width="12%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
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
                swal.fire({
                    title: "{{ __('Success!') }}",
                    text: "{!! \Session::get('success') !!}",
                    icon: "success",
                    type: "success"
                });
            }, 1000);
        </script>
    @endif
    @if (session()->has('error'))
        <script>
            setTimeout(function () {
                swal.fire({
                    title: "{{ __('Error!') }}",
                    text: "{!! \Session::get('error') !!}",
                    icon: "error",
                    type: "error"
                });
            }, 1000);
        </script>
    @endif

    @push('js')
        <script>
            $(document).ready(function () {
                // Hapus Data
                $('body').on('click', '.btn-delete', function () {
                    var id = $(this).data('id');
                    Swal.fire({
                        title: 'Hapus Data',
                        text: "Anda Ingin Menghapus Data?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('drafter.destroy', ':id') }}'.replace(':id', id),
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function (response) {
                                    Swal.fire(
                                        'Dihapus',
                                        'Data Berhasil Dihapus',
                                        'success'
                                    );
                                    $('#example').DataTable().ajax.reload();
                                },
                                error: function (xhr) {
                                    Swal.fire(
                                        'Gagal!',
                                        xhr.responseJSON.message || 'Gagal',
                                        'error'
                                    );
                                    console.log(xhr.responseText);
                                }
                            });
                        }
                    });
                });

                // Ajukan Dokumen
                $('body').on('click', '.btn-ajukan', function () {
                    var id = $(this).data('id');
                    Swal.fire({
                        title: 'Ajukan Draft Dokumen',
                        text: "Anda Ingin Mengajukan Dokumen ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Ajukan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('drafter.ajukan', ':id') }}'.replace(':id', id),
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function (response) {
                                    Swal.fire(
                                        'Sukses',
                                        'Dokumen Berhasil Diajukan',
                                        'success'
                                    );
                                    $('#example').DataTable().ajax.reload();
                                },
                                error: function (xhr) {
                                    Swal.fire(
                                        'Gagal!',
                                        xhr.responseJSON.message || 'Gagal',
                                        'error'
                                    );
                                    console.log(xhr.responseText);
                                }
                            });
                        }
                    });
                });

                // DataTable
                var dataTable = function () {
                    var table = $('#example');
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
                            }
                        },
                        ajax: "{{ route('drafter.index') }}",
                        columns: [
                            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                            { data: 'NomorSurat', name: 'NomorSurat' },
                            { data: 'Perihal', name: 'Perihal' },
                            { data: 'ajukan', name: 'ajukan' },
                            { data: 'Status', name: 'Status' },
                            { data: 'action', name: 'action', orderable: false, searchable: false },
                        ]
                    });
                };
                dataTable();
            });
        </script>
    @endpush
@endsection