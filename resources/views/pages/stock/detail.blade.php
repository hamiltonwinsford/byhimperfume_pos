@extends('layouts.app')

@section('title', 'Stock')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Stock</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Stock</a></div>
                <div class="breadcrumb-item">All Stock</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Stock In</h4>
                        </div>
                        <div class="card-body">
                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table id="myTable" class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Stock In</th>
                                            <th>Stock Opname Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $value)
                                        <tr>

                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->stock_in }}</td>
                                            <td>{{ $value->stock_opname_date }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Stock Out</h4>
                        </div>
                        <div class="card-body">
                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table id="myTable-1" class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Stock Out</th>
                                            <th>Out Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($out as $value)
                                        <tr>

                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->quantity }}</td>
                                            <td>{{ $value->transaction_date }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush