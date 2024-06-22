@extends('layouts.app')

@section('title', 'Create Bundle')

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
                <div class="breadcrumb-item">Promotions Bundle</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Promotions Bundle</h2>


            <div class="card">
                <form action="{{ route('promotionBundle.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Input Text</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="" class="form-control" name="name_promotion" required>
                        </div>
                        <div class="form-group">
                            <label>Product</label>
                            <select class="form-control" name="product_id" required>
                                <option value="" selected disabled>-- Select Product --</option>
                                @foreach($product as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Product Bundle</label>
                            <select class="form-control" name="other_product_id" required>
                                <option value="" selected disabled>-- Select Product --</option>
                                @foreach($product as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" value="" class="form-control" name="from_date" required>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" value="" class="form-control" name="to_date" required>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" value="" class="form-control" name="price" required>
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
