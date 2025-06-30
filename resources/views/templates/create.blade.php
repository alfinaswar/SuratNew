@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Upload Template</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Template</label>
                            <input type="text" name="name" id="name" class="form-control" required
                                placeholder="Masukkan nama template">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control" rows="3"
                                placeholder="Masukkan deskripsi template"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">File Template (Word)</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <script>
            setTimeout(function() {
                swal.fire({
                    title: "{{ __('Success!') }}",
                    text: "{{ session('success') }}",
                    icon: "success"
                });
            }, 500);
        </script>
    @endif
@endsection
