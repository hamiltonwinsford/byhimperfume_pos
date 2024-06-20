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
            <h2 class="section-title">Product</h2>


            <div class="card">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Input Text</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Branch</label>
                            <select class="form-control selectric @error('branch_id') is-invalid @enderror" name="branch_id" id="branch_id">
                                <option value="">Choose Branch</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" @if(old('branch_id')==$branch->id) selected @endif>{{ $branch->name }} - {{$branch->address}}</option>
                                @endforeach
                            </select>
                            @error('branch_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name')
                                is-invalid
                            @enderror" value="{{ old('name') }}" name="name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" value="{{ old('description') }}" class="form-control @error('description')
                                is-invalid
                            @enderror" name="description">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select class="form-control selectric @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                                <option value="">Choose Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" data-fragrances="{{ $category->fragrances_status }}" @if(old('category_id')==$category->id) selected @endif>{{ $category->name }} - {{ $category->fragrances_status == 1 ? 'Is Fragrances' : 'Is Not Fragrances' }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Base Price per ML</label>
                            <input type="number" value="{{ old('price') }}" class="form-control @error('price')
                                is-invalid
                            @enderror" name="price">
                            @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group" id="stockContainer">
                            <label>Stock</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock') }}">
                            @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group" id="literContainer" style="display: none;">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="form-label">Fragrances Name</label>
                                    <input type="text" class="form-control @error('fragrances_name') is-invalid @enderror" name="fragrances_name" value="{{ old('fragrances_name') }}">
                                    @error('fragrances_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="form-label">Total Weight</label>
                                    <input type="number" class="form-control @error('total_weight') is-invalid @enderror" name="total_weight" value="{{ old('total_weight') }}" id="total_weight">
                                    @error('total_weight')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label">Pump Weight</label>
                                    <input type="number" class="form-control @error('pump_weight') is-invalid @enderror" name="pump_weight" value="{{ old('pump_weight') }}" id="pump_weight">
                                    @error('pump_weight')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label">Bottle Weight</label>
                                    <input type="number" class="form-control @error('bottle_weight') is-invalid @enderror" name="bottle_weight" value="{{ old('bottle_weight') }}" id="bottle_weight">
                                    @error('bottle_weight')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label">Gram to Mililiter</label>
                                    <input type="text" class="form-control @error('gram_to_ml') is-invalid @enderror" name="gram_to_ml" value="{{ old('gram_to_ml', $product->fragrance->gram_to_ml ?? '') }}" id="gram_to_ml">
                                    @error('gram_to_ml')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label">Mililiter to Gram</label>
                                    <input type="text" class="form-control @error('ml_to_gram') is-invalid @enderror" name="ml_to_gram" value="{{ old('ml_to_gram', $product->fragrance->ml_to_gram ?? '') }}" id="ml_to_gram">
                                    @error('ml_to_gram')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label">Gram</label>
                                    <input type="number" class="form-control @error('gram') is-invalid @enderror" name="gram" value="{{ old('gram') }}" id="gram">
                                    @error('gram')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label">Milliliter</label>
                                    <input type="number" class="form-control @error('milliliter') is-invalid @enderror" name="milliliter" value="{{ old('milliliter') }}" id="milliliter">
                                    @error('milliliter')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                        </div>



                        <div class="form-group">
                            <label class="form-label">Photo Product</label>

                            <input type="file" class="form-control" name="image" @error('image') is-invalid @enderror>
                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="selectgroup selectgroup-pills">
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="1" class="selectgroup-input" checked="">
                                    <span class="selectgroup-button">Active</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">Inactive</span>
                                </label>
                            </div>
                        </div>

                        {{-- is favorite --}}
                        <div class="form-group">
                            <label class="form-label">Is Favorite</label>
                            <div class="selectgroup selectgroup-pills">
                                <label class="selectgroup-item">
                                    <input type="radio" name="is_favorite" value="1" class="selectgroup-input" checked="">
                                    <span class="selectgroup-button">Yes</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="is_favorite" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">No</span>
                                </label>
                            </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        function calculateWeights() {
            var total_weight = parseFloat($('#total_weight').val());
            var pump_weight = parseFloat($('#pump_weight').val());
            var bottle_weight = parseFloat($('#bottle_weight').val());
            var gram_to_ml = parseFloat($('#gram_to_ml').val());

            if (!isNaN(total_weight) && !isNaN(pump_weight) && !isNaN(bottle_weight) && !isNaN(gram_to_ml)) {
                var gram = total_weight - (pump_weight + bottle_weight);
                var milliliter = gram * gram_to_ml;

                $('#gram').val(gram);
                $('#milliliter').val(milliliter);
            }
        }

        $('#total_weight, #pump_weight, #bottle_weight, #gram_to_ml').on('keyup', function(){
            calculateWeights();
        });
    });

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
@endsection
@push('scripts')
@endpush
