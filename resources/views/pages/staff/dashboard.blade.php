@extends('layouts.app')

@section('title', 'Branch Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Branch Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Products in Your Branch</h4>
                            </div>
                            <div class="card-body">
                                {{ $products->count() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Transactions in Your Branch</h4>
                            </div>
                            <div class="card-body">
                                {{ $transactions->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="transactionsChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>New Transactions in Your Branch</h4>
                        </div>
                        <div class="table-responsive card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No Transactions</th>
                                        <th>Transaction Date</th>
                                        <th>Customer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lastTransaction as $val)
                                    <tr>
                                        <td>{{ $val->transaction_number }}</td>
                                        <td>{{ $val->transaction_date }}</td>
                                        <td>{{ $val->name }}</td> <!-- Mengakses nama customer terkait -->
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pt-1 pb-1 text-center">
                                <a href="{{ URL::to('report') }}" class="btn btn-primary btn-lg btn-round">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/daily-transactions') // Pastikan ini hanya mengirimkan data yang terkait dengan branch pengguna
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.day);
                    const totals = data.map(item => item.total);

                    const formatRupiah = (number) => {
                        return 'Rp. ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }

                    const ctx = document.getElementById('transactionsChart').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Transactions every Day',
                                data: totals,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value, index, values) {
                                            return formatRupiah(value);
                                        }
                                    }
                                }
                            },
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        return formatRupiah(tooltipItem.yLabel);
                                    }
                                }
                            }
                        }
                    });
                });
        });
    </script>
@endpush
