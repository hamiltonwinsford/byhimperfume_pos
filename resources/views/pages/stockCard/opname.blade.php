@extends('layouts.app')

@section('title', 'Stock Opname')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Stock Opname</h1>
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
                            <h4>Stock Opname</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('stockcard.update', $stockCard->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="product_id" value="{{ $stockCard->product->id }}">
                                <div class="form-group">
                                    <label>Product</label>
                                    <input type="text" class="form-control" value="{{ $stockCard->product->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Opname Date</label>
                                    <input type="text" class="form-control" name="stock_opname_date" value="{{ now()->format('Y-m-d H:i:s') }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Real Stock (gram)</label>
                                    <input type="number" class="form-control" name="real_stock_gram" value="{{ $stockCard->real_stock_gram }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
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
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

<!-- Page Specific JS File -->
<script>
    $(document).ready(function() {
        // Set the opname date to today's date and make it readonly
        let today = new Date().toISOString().split('T')[0];
        $('input[name="stock_opname_date"]').val(today).attr('readonly', true);
    });
</script>
@endpush
