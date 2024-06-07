@extends('layouts.app')

@section('title', 'Seed Create')

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
            <h1>Advanced Forms</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Seed</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Seed</h2>


            <div class="card">
                <form action="{{ route('seeds.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Input Text</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Seed Code</label>
                            <input type="text" value="{{old('seed_code')}}" class="form-control @error('seed_code')
                                is-invalid
                            @enderror" name="seed_code">
                            @error('seed_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Seed Name</label>
                            <input type="text" value="{{old('seed_name')}}" class="form-control @error('seed_name')
                                is-invalid
                            @enderror" name="seed_name">
                            @error('seed_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Descriptions</label>
                            <input type="text" value="{{old('descriptions')}}" class="form-control @error('descriptions')
                                is-invalid
                            @enderror" name="descriptions">
                            @error('descriptions')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Density</label>
                            <input type="text" value="{{old('density')}}" class="form-control @error('density')
                                is-invalid
                            @enderror" name="density">
                            @error('density')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Dispenser Weight</label>
                            <input type="text" value="{{old('dispenser_weight')}}" class="form-control @error('dispenser_weight')
                                is-invalid
                            @enderror" name="dispenser_weight">
                            @error('dispenser_weight')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Total ML</label>
                            <input type="text" value="{{old('total_ml')}}" class="form-control @error('total_ml')
                                is-invalid
                            @enderror" name="total_ml">
                            @error('total_ml')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Total Gram</label>
                            <input type="text" value="{{old('total_gram')}}" class="form-control @error('total_gram')
                                is-invalid
                            @enderror" name="total_gram">
                            @error('total_gram')
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
@endpush