@extends('layouts.app')

@section('title', 'Bottle Edit')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Bottle</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Bottle</a></div>
                <div class="breadcrumb-item">Edit Bottle</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Bottle</h2>

            <div class="card">
                <form action="{{ route('bottle.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Edit Bottle</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Bottle Name</label>
                            <input type="text" value="{{ $data->bottle_name }}" class="form-control @error('bottle_name') is-invalid @enderror" name="bottle_name">
                            @error('bottle_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bottle Size</label>
                            <input type="text" value="{{ $data->bottle_size }}" class="form-control @error('bottle_size') is-invalid @enderror" name="bottle_size">
                            @error('bottle_size')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bottle Type</label>
                            <input type="text" value="{{ $data->bottle_type }}" class="form-control @error('bottle_type') is-invalid @enderror" name="bottle_type">
                            @error('bottle_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Variant</label>
                            <select class="form-control selectric" name="variant">
                                <option value="edt" {{ $data->variant == 'edt' ? 'selected' : '' }}>Eau de Toilette</option>
                                <option value="edp" {{ $data->variant == 'edp' ? 'selected' : '' }}>Eau de Perfume</option>
                                <option value="perfume" {{ $data->variant == 'perfume' ? 'selected' : '' }}>Perfume</option>
                                <option value="full_perfume" {{ $data->variant == 'full_perfume' ? 'selected' : '' }}>Full Perfume</option>
                            </select>
                            @error('variant')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" value="{{ $data->harga_ml }}" class="form-control @error('harga_ml') is-invalid @enderror" name="harga_ml">
                            @error('harga_ml')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
