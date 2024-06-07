@extends('layouts.app')

@section('title', 'Detail Transactions')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Transactions</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Report</a></div>
                    <div class="breadcrumb-item">Detail Transactions</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Detail Transactions</h2>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail Transactions</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Transactions Number</th>
                                            <td>{{ $data->transaction_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Transactions Date</th>
                                            <td>{{ $data->transaction_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Cashier</th>
                                            <td>{{ $data->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Customers</th>
                                            <td>{{ $data->name_customer }}</td>
                                        </tr>
                                        <tr>
                                            <th>Branch</th>
                                            <td>{{ $data->name_branch }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Amount</th>
                                            <td>{{ $data->total_amount }}</td>
                                        </tr>

                                    </table>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($detail as $value)
                                            <tr>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->quantity }}</td>
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
