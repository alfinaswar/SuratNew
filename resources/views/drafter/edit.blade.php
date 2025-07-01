@extends('layouts.app')

@section('content')
    <style>
        .preview-item {
            border: 1px solid #e0e0e0;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            background: #fafbfc;
            margin-bottom: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .preview-item img {
            display: block;
            margin: 0 auto 8px auto;
            border-radius: 4px;
            max-width: 120px;
            max-height: 120px;
            object-fit: cover;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-12">
            <div class="card">
                <form action="{{ route('drafter.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h5 class="mb-0">Edit Surat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="tanggal_surat">Kategori Surat</label>
                                    <select class="form-select" data-trigger name="idJenis"
                                        id="choices-multiple-default-KategoriSurat" placeholder="Pilih Kategori Surat"
                                        onchange="changeKategori(this)">
                                        <option value="">Pilih Kategori Surat</option>
                                        @foreach ($kategori as $i)
                                            <option value="{{ $i->id }}" {{ $surat->idJenis == $i->id ? 'selected' : '' }}>
                                                {{ $i->JenisSurat }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idJenis')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="KodeProject">Kode Project</label>
                                    <select class="form-select" data-trigger name="KodeProject"
                                        id="choices-multiple-default" placeholder="Pilih Kode Project">
                                        <option value="">Pilih Kode Project</option>
                                        @foreach ($KodeProject as $p)
                                            <option value="{{ $p->id }}" {{ $surat->KodeProject == $p->id ? 'selected' : '' }}>
                                                {{ $p->Nama }} - {{ $p->Kode }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('KodeProject')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label" for="Perihal">Perihal</label>
                                    <input type="text" class="form-control" id="Perihal" name="Perihal"
                                        placeholder="Perihal" value="{{ old('Perihal', $surat->Perihal) }}">
                                    @error('Perihal')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="TanggalSurat">Tanggal Surat</label>
                                    <input type="date" class="form-control" id="TanggalSurat" name="TanggalSurat"
                                        value="{{ old('TanggalSurat', $surat->TanggalSurat) }}">
                                    @error('TanggalSurat')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="Lampiran">Lampiran</label>
                            <input type="file" class="form-control" id="Lampiran" name="Lampiran[]" multiple
                                onchange="previewFiles(this)">
                            @error('Lampiran')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <div id="preview-container" class="mt-3 d-flex flex-wrap gap-2">
                                @if(isset($surat->lampiran) && is_array($surat->lampiran))
                                    @foreach($surat->lampiran as $lampiran)
                                        <div class="preview-item">
                                            <a href="{{ asset('storage/lampiran/' . $lampiran) }}"
                                                target="_blank">{{ $lampiran }}</a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item" id="PenerimaInternal">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button fw-medium" type="button" aria-expanded="true"
                                        aria-controls="collapseThree">
                                        Penerima Internal
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse show"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="PenerimaSurat">Penerima Surat</label>
                                                    <select class="multi-select PenerimaSurat" name="PenerimaSurat"
                                                        placeholder="Pilih Penerima"
                                                        data-url="{{ route('users.getCCInternal') }}">
                                                        <option>Pilih Penerima</option>
                                                        @foreach ($penerima as $p)
                                                            <option value="{{ $p->id }}" {{ $surat->PenerimaSurat == $p->id ? 'selected' : '' }}>
                                                                {{ $p->name }} - {{ $p->jabatan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('PenerimaSurat')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="form-label" for="InisialPenerima">Inisial
                                                        Penerima</label>
                                                    <input type="text" name="InisialPenerima" id="InisialPenerima"
                                                        class="form-control" placeholder="Autofill" readonly
                                                        value="{{ old('InisialPenerima', $surat->InisialPenerima ?? '') }}">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="form-label" for="JabatanInt">Jabatan Penerima</label>
                                                    <input type="text" name="JabatanInt" id="JabatanInt"
                                                        class="form-control" placeholder="Autofill" readonly
                                                        value="{{ old('JabatanInt', $surat->JabatanInt ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="DepartemenInt">Departemen
                                                        Penerima</label>
                                                    <input type="text" name="DepartemenInt" id="DepartemenInt"
                                                        class="form-control" placeholder="Autofill" readonly
                                                        value="{{ old('DepartemenInt', $surat->DepartemenInt ?? '') }}">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="form-label" for="PerusahaanInt">Perusahaan
                                                        Penerima</label>
                                                    <input type="text" name="PerusahaanInt" id="PerusahaanInt"
                                                        class="form-control" placeholder="Autofill" readonly
                                                        value="{{ old('PerusahaanInt', $surat->PerusahaanInt ?? '') }}">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="form-label" for="AlamatInt">Alamat Penerima</label>
                                                    <input type="text" name="AlamatInt" id="AlamatInt" class="form-control"
                                                        placeholder="Autofill" readonly
                                                        value="{{ old('AlamatInt', $surat->AlamatInt ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="EmailInt">Email Penerima</label>
                                                    <input type="text" name="EmailInt" id="EmailInt" class="form-control"
                                                        placeholder="Autofill" readonly
                                                        value="{{ old('EmailInt', $surat->EmailInt ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item" id="PenerimaEksternal">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button fw-medium" type="button" data-bs-target="#collapseFour"
                                        aria-expanded="true" aria-controls="collapseFour">
                                        Penerima Eksternal
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse show"
                                    aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="PenerimaSuratEksternal">Penerima
                                                        Surat</label>
                                                    <select class="multi-select PenerimaSuratEksternal"
                                                        name="PenerimaSuratEksternal" placeholder="Pilih Penerima"
                                                        data-url="{{ route('users.getCCExternal') }}">
                                                        <option value="">Pilih Penerima</option>
                                                        @foreach ($eksternal as $pa)
                                                            <option value="{{ $pa->id }}" {{ $surat->PenerimaSuratEksternal == $pa->id ? 'selected' : '' }}>
                                                                {{ $pa->Nama }} - {{ $pa->Jabatan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('PenerimaSuratEksternal')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="form-label" for="InisialPenerimaExt">Inisial
                                                        Penerima</label>
                                                    <input type="text" name="InisialPenerima" id="InisialPenerimaExt"
                                                        class="form-control" placeholder="Autofill" readonly
                                                        value="{{ old('InisialPenerima', $surat->InisialPenerima ?? '') }}">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="form-label" for="JabatanExt">Jabatan Penerima</label>
                                                    <input type="text" name="JabatanExt" id="JabatanExt"
                                                        class="form-control" placeholder="Autofill" readonly
                                                        value="{{ old('JabatanExt', $surat->JabatanExt ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="DepartemenExt">Departemen
                                                        Penerima</label>
                                                    <input type="text" name="DepartemenExt" id="DepartemenExt"
                                                        class="form-control" placeholder="Autofill" readonly
                                                        value="{{ old('DepartemenExt', $surat->DepartemenExt ?? '') }}">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="form-label" for="PerusahaanExt">Perusahaan
                                                        Penerima</label>
                                                    <input type="text" name="PerusahaanExt" id="PerusahaanExt"
                                                        class="form-control" placeholder="Autofill" readonly
                                                        value="{{ old('PerusahaanExt', $surat->PerusahaanExt ?? '') }}">
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label class="form-label" for="AlamatExt">Alamat Penerima</label>
                                                    <input type="text" name="AlamatExt" id="AlamatExt" class="form-control"
                                                        placeholder="Autofill" readonly
                                                        value="{{ old('AlamatExt', $surat->AlamatExt ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="EmailExt">Email Penerima</label>
                                                    <input type="text" name="EmailExt" id="EmailExt" class="form-control"
                                                        placeholder="Autofill" readonly
                                                        value="{{ old('EmailExt', $surat->EmailExt ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item" id="CCInternal">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button fw-medium" type="button" data-bs-target="#collapseFive"
                                        aria-expanded="true" aria-controls="collapseFive">
                                        CC Internal
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse show"
                                    aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group">
                                            <label class="form-label" for="CarbonCopy">Carbon Copy Internal</label>
                                            <select class="multi-select PenerimaInternal2" name="CarbonCopy[]" multiple
                                                data-url="{{ route('users.getBCCInternal') }}">
                                                <option>Pilih Penerima</option>
                                                @foreach ($penerima as $p)
                                                    <option value="{{ $p->id }}" @if(isset($surat->CarbonCopy) && in_array($p->id, (array) $surat->CarbonCopy)) selected @endif>
                                                        {{ $p->name }} - {{ $p->jabatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('CarbonCopy')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item" id="CCExternal">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button fw-medium" type="button" data-bs-target="#collapseSix"
                                        aria-expanded="true" aria-controls="collapseSix">
                                        Carbon Copy Eksternal
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group mb-3">
                                            <label for="cc">Carbon Copy Eksternal</label>
                                            <select class="multi-select CarbonCopyExt" data-trigger name="CarbonCopyExt[]"
                                                placeholder="Pilih penerima CC" multiple
                                                data-url="{{ route('users.getCCExternal2') }}">
                                                @foreach ($eksternal as $pa2)
                                                    <option value="{{ $pa2->id }}" @if(isset($surat->CarbonCopyExt) && in_array($pa2->id, (array) $surat->CarbonCopyExt)) selected @endif>
                                                        {{ $pa2->Nama }} - {{ $pa2->Jabatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('CarbonCopy')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item" id="BCCInternal">
                                    <h2 class="accordion-header" id="headingSeven">
                                        <button class="accordion-button fw-medium" type="button"
                                            data-bs-target="#collapseSeven" aria-expanded="true"
                                            aria-controls="collapseSeven">
                                            BCC Internal
                                        </button>
                                    </h2>
                                    <div id="collapseSeven" class="accordion-collapse collapse show"
                                        aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-group mb-3">
                                                <label for="cc">Blind Carbon Copy Internal</label>
                                                <select class="multi-select PenerimaInternal3" name="BlindCarbonCopyInt[]"
                                                    placeholder="Pilih penerima CC" multiple>
                                                    @foreach ($penerima as $p)
                                                        <option value="{{ $p->id }}" @if(isset($surat->BlindCarbonCopyInt) && in_array($p->id, (array) $surat->BlindCarbonCopyInt)) selected
                                                        @endif>
                                                            {{ $p->name }} - {{ $p->jabatan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('CarbonCopy')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item" id="BCCExternal">
                                    <h2 class="accordion-header" id="headingEight">
                                        <button class="accordion-button fw-medium" type="button"
                                            data-bs-target="#collapseEight" aria-expanded="true"
                                            aria-controls="collapseEight">
                                            BCC Eksternal
                                        </button>
                                    </h2>
                                    <div id="collapseEight" class="accordion-collapse collapse show"
                                        aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-group mb-3">
                                                <label for="bcc">Blind CC Eksternal</label>
                                                <select class="multi-select BlindCarbonCopyExt" data-trigger
                                                    name="BlindCarbonCopyExt[]" placeholder="Pilih penerima BC" multiple>
                                                    @foreach ($eksternal as $pa2)
                                                        <option value="{{ $pa2->id }}" @if(isset($surat->BlindCarbonCopyExt) && in_array($pa2->id, (array) $surat->BlindCarbonCopyExt)) selected
                                                        @endif>
                                                            {{ $pa2->Nama }} - {{ $pa2->Jabatan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('BlindCarbonCopy')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseEight" class="accordion-collapse collapse show" aria-labelledby="headingEight"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-group mb-3">
                                        <label for="isi_surat">Isi Surat</label>
                                        <textarea class="form-control" id="ckeditor-classic" name="Isi" rows="10"
                                            placeholder="Masukkan isi surat">{{ old('Isi', $surat->Isi) }}</textarea>
                                        @error('Isi')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div><!-- end accordion -->
                        <div class="card-footer mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('drafter.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                </form>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $("#PenerimaInternal").hide();
            $("#PenerimaEksternal").hide();
            $("#CCInternal").hide();
            $("#CCExternal").hide();
            $("#BCCInternal").hide();
            $("#BCCExternal").hide();
            $("#IsiSurat").show();

            $('.PenerimaSurat').on('change', function () {
                let Penerima1 = $(this).val();
                let url = $(this).data('url');

                $('.PenerimaInternal2').empty().append('<option value="">Loading...</option>');

                if (Penerima1) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id: Penerima1
                        },
                        success: function (response) {
                            $('.PenerimaInternal2').empty().append(
                                '<option value="">Pilih Nama</option>');
                            $.each(response, function (key, unit) {
                                $('.PenerimaInternal2').append(
                                    `<option value="${unit.id}">${unit.name}</option>`
                                );
                            });
                        },
                        error: function () {
                            $('.PenerimaInternal2').empty().append(
                                '<option value="">Gagal mengambil data</option>');
                        }
                    });
                } else {
                    $('.PenerimaInternal2').empty().append('<option value="">Pilih Nama</option>');
                }
            });
            $('.PenerimaInternal2').on('change', function () {
                let Penerima1 = $(this).val();
                let Penerima2 = $('.PenerimaSurat').val();
                // alert(Penerima1)
                let url = $(this).data('url');

                $('.PenerimaInternal3').empty().append('<option value="">Loading...</option>');

                if (Penerima1) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id: Penerima1,
                            id2: Penerima2
                        },
                        success: function (response) {
                            $('.PenerimaInternal3').empty().append(
                                '<option value="">Pilih Nama</option>');
                            $.each(response, function (key, unit) {
                                $('.PenerimaInternal3').append(
                                    `<option value="${unit.id}">${unit.name}</option>`
                                );
                            });
                        },
                        error: function () {
                            $('.PenerimaInternal3').empty().append(
                                '<option value="">Gagal mengambil data</option>');
                        }
                    });
                } else {
                    $('.PenerimaInternal3').empty().append('<option value="">Pilih Nama</option>');
                }
            });
            $('.PenerimaSuratEksternal').on('change', function () {
                let Penerima1 = $(this).val();
                let url = $(this).data('url');

                $('.CarbonCopyExt').empty().append('<option value="">Loading...</option>');

                if (Penerima1) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id: Penerima1
                        },
                        success: function (response) {
                            $('.CarbonCopyExt').empty().append(
                                '<option value="">Pilih Nama</option>');
                            $.each(response, function (key, unit) {
                                $('.CarbonCopyExt').append(
                                    `<option value="${unit.id}">${unit.name}</option>`
                                );
                            });
                        },
                        error: function () {
                            $('.CarbonCopyExt').empty().append(
                                '<option value="">Gagal mengambil data</option>');
                        }
                    });
                } else {
                    $('.CarbonCopyExt').empty().append('<option value="">Pilih Nama</option>');
                }
            });
            $('.CarbonCopyExt').on('change', function () {
                let Penerima1 = $(this).val();
                let Penerima2 = $('.PenerimaSuratEksternal').val();
                // alert(Penerima1)
                let url = $(this).data('url');

                $('.BlindCarbonCopyExt').empty().append('<option value="">Loading...</option>');

                if (Penerima1) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id: Penerima1,
                            id2: Penerima2
                        },
                        success: function (response) {
                            $('.BlindCarbonCopyExt').empty().append(
                                '<option value="">Pilih Nama</option>');
                            $.each(response, function (key, unit) {
                                $('.BlindCarbonCopyExt').append(
                                    `<option value="${unit.id}">${unit.name}</option>`
                                );
                            });
                        },
                        error: function () {
                            $('.BlindCarbonCopyExt').empty().append(
                                '<option value="">Gagal mengambil data</option>');
                        }
                    });
                } else {
                    $('.BlindCarbonCopyExt').empty().append('<option value="">Pilih Nama</option>');
                }
            });
            changeKategori();
        });


        function changeKategori(data) {
            var id = data.value;
            $.ajax({
                type: "GET",
                url: "{{ route('kategori-surat.get-field', '') }}/" + id,
                data: {},
                dataType: "json",
                success: function (response) {
                    $("#IsiSurat").show();
                    if (response.PenerimaInternal == "YA") {
                        $("#PenerimaInternal").show();
                    } else {
                        $("#PenerimaInternal").hide();
                    }
                    if (response.PenerimaEksternal == "YA") {
                        $("#PenerimaEksternal").show();
                    } else {
                        $("#PenerimaEksternal").hide();
                    }
                    if (response.CCInternal == "YA") {
                        $("#CCInternal").show();
                    } else {
                        $("#CCInternal").hide();
                    }
                    if (response.CCEksternal == "YA") {
                        $("#CCExternal").show();
                    } else {
                        $("#CCExternal").hide();
                    }
                    if (response.BCCInternal == "YA") {
                        $("#BCCInternal").show();
                    } else {
                        $("#BCCInternal").hide();
                    }
                    if (response.BCEksternal == "YA") {
                        $("#BCCExternal").show();
                    } else {
                        $("#BCCExternal").hide();
                    }

                }
            });
        }
    </script>
    <script>
        function previewFiles(input) {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = ''; // Clear previous previews

            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                const previewElement = document.createElement('div');
                previewElement.className = 'preview-item position-relative';

                reader.onload = function (e) {
                    if (file.type.startsWith('image/')) {
                        previewElement.innerHTML =
                            `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <img src="${e.target.result}" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="mt-1">${file.name}</div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            `;
                    } else {
                        let fileIcon = '📄';
                        if (file.type.includes('pdf')) fileIcon = '📕';
                        else if (file.type.includes('word')) fileIcon = '📘';
                        else if (file.type.includes('excel') || file.type.includes('sheet')) fileIcon = '📗';

                        previewElement.innerHTML =
                            `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="text-center">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div style="font-size: 2rem;">${fileIcon}</div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div style="word-break: break-word; max-width: 150px;">${file.name}</div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            `;
                    }
                };

                if (file.type.startsWith('image/')) {
                    reader.readAsDataURL(file);
                } else {
                    reader.readAsText(file);
                }

                previewContainer.appendChild(previewElement);
            });
        }
    </script>
@endpush