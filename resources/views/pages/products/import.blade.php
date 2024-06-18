@extends('layouts.app')

@section('title', 'Product Create')

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
                <div class="breadcrumb-item">Product</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Import Product</h2>
                @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <form action="{{ route('products.import.excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Choose Excel File</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
        @endif
        </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#total_weight, #pump_weight, #bottle_weight, #concentration').on('keyup', function(){
            var total_weight = parseFloat($('#total_weight').val());
            var pump_weight = parseFloat($('#pump_weight').val());
            var bottle_weight = parseFloat($('#bottle_weight').val());
            var concentration = parseFloat($('#concentration').val());
            var gram = total_weight - (pump_weight + bottle_weight);
            var milliliter = gram * concentration;

            if(!isNaN(gram)) {
                $('#gram').val(gram);
                $('#milliliter').val(milliliter);
            }
        });
    });
</script>


@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category_id');
        const stockContainer = document.getElementById('stockContainer');
        const literContainer = document.getElementById('literContainer');

        categorySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const fragrancesStatus = selectedOption.getAttribute('data-fragrances');

            if (this.value === '') {
                stockContainer.style.display = 'none';
                literContainer.style.display = 'none';
            } else if (fragrancesStatus === '1') {
                stockContainer.style.display = 'none';
                literContainer.style.display = 'block';
            } else {
                stockContainer.style.display = 'block';
                literContainer.style.display = 'none';
            }
        });

        // Trigger change event on page load (if an option is pre-selected)
        categorySelect.dispatchEvent(new Event('change'));
    });
</script>
@endpush
