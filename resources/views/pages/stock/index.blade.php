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
                            <h4>All Stock</h4>
                        </div>
                        <div class="card-body">

                            <div class="float-right">
                                <form method="GET" action="{{ route('bottle.index') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <tr>
                                        <th>Product</th>
                                        <th>First</th>
                                        <th>Stock IN</th>
                                        <th>Stock Out</th>
                                        <th>CALC (G)</th>
                                        <th>CALC (ML)</th>
                                        <th>Real (G)</th>
                                        <th>Real (ML)</th>
                                        <th>Difference (G)</th>
                                        <th>Difference (ML)</th>
                                        <th>Stock Opname Date</th>
                                    </tr>
                                    @foreach ($data as $value)
                                    <tr>

                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->total_weight }}</td>
                                        <td>{{ $value->stock_in }}</td>
                                        <td>{{ $value->stock_out }}</td>
                                        <td>{{ $value->calc_g }}</td>
                                        <td>{{ $value->calc_ml }}</td>
                                        <td>{{ $value->real_g }}</td>
                                        <td>{{ $value->real_ml }}</td>
                                        <td>{{ $value->difference_g }}</td>
                                        <td>{{ $value->difference_ml }}</td>
                                        <td>{{ $value->stock_opname_date }}</td>
                                    </tr>
                                    @endforeach


                                </table>
                            </div>
                            <div class="float-right">
                                {{ $data->withQueryString()->links() }}
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