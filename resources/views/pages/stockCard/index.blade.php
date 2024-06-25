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
                <div class="breadcrumb-item"><a href="{{ route('stockcard.index') }}">Stock</a></div>
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


                            <div class="col-6">
                                <form method="get" action="{{ route('stockcard.index') }}">
                                    @csrf
                                        <select class="form-control selectric" name="branch_id" required>
                                            <option value="" selected disabled>-- Select Branch --</option>
                                            @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }} - {{$branch->address}}</option>
                                            @endforeach
                                        </select>
                            </div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>

                            </form>

                        </div>

                        <div class="card-body">
                            <div class="clearfix mb-3"></div>
                            <div class="table-responsive mt-4">
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Branch</th>
                                            <th>Fragrance</th>
                                            <th>Opening Stock (g)</th>
                                            <th>Restock (g)</th>
                                            <th>Sales (ml)</th>
                                            <th>Calc (g)</th>
                                            <th>Calc (ml)</th>
                                            <th>Real (g)</th>
                                            <th>Real (ml)</th>
                                            <th>Difference (g)</th>
                                            <th>Difference (ml)</th>
                                            <th>Opname Start</th>
                                            <th>Opname End</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $stockCard)
                                            <tr>
                                                <td>{{ $stockCard->product->name }}</td>
                                                <td>{{ $stockCard->branch->name }}</td>
                                                <td>{{ $stockCard->fragrance->name ?? 'N/A' }}</td>
                                                <td>{{ $stockCard->opening_stock_gram }}</td>
                                                <td>{{ $stockCard->restock_gram }}</td>
                                                <td>{{ $stockCard->sales_ml }}</td>
                                                <td>{{ $stockCard->calc_g }}</td>
                                                <td>{{ $stockCard->calc_ml }}</td>
                                                <td>{{ $stockCard->real_g }}</td>
                                                <td>{{ $stockCard->real_ml }}</td>
                                                <td>{{ $stockCard->difference_g }}</td>
                                                <td>{{ $stockCard->difference_ml }}</td>
                                                <td>{{ $stockCard->stock_opname_start }}</td>
                                                <td>{{ $stockCard->stock_opname_end }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('stockcard.opname', $stockCard->id) }}' class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    </div>
                                                </td>
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
