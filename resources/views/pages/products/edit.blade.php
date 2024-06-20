@extends('layouts.app')

@section('title', 'Edit Product')

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
                <div class="breadcrumb-item">Products</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Products</h2>



            <div class="card">
                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Input Text</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Branch</label>
                            <select class="form-control selectric @error('branch_id') is-invalid @enderror" name="branch_id" id="branch_id">
                                <option value="">Choose Branch</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" @if(old('branch_id', $product->branch_id) == $branch->id) selected @endif>{{ $branch->name }} - {{ $branch->address }}</option>
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
                            @enderror" name="name" value="{{ $product->name }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control @error('description')
                                is-invalid
                            @enderror" name="description" value="{{ $product->description }}">
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Base Price per ml</label>
                            <input type="number" class="form-control @error('price')
                                is-invalid
                            @enderror" name="price" value="{{ $product->price }}">
                            @error('price')
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
                                <option value="{{ $category->id }}" data-fragrances="{{ $category->fragrances_status }}" @if(old('category_id', $product->category_id) == $category->id) selected @endif>{{ $category->name }} - {{ $category->fragrances_status == 1 ? 'Is Fragrances' : 'Is Not Fragrances' }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group" id="stockContainer" style="@if(old('category_id', $product->category_id) != $product->category->fragrances_status) display: none; @endif">
                            <label>Stock</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $product->stock) }}">
                            @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group" id="literContainer" style="@if(old('category_id', $product->category_id) != $product->category->fragrances_status) display: none; @endif">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="form-label">Fragrances Name</label>
                                    <input type="text" class="form-control @error('fragrances_name') is-invalid @enderror" name="fragrances_name" value="{{ old('fragrances_name', $product->fragrance->name ?? '') }}">
                                    @error('fragrances_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="form-label">Total Weight</label>
                                    <input type="number" class="form-control @error('total_weight') is-invalid @enderror" name="total_weight" value="{{ old('pump_weight', $product->fragrance->total_weight ?? '') }}"  id="total_weight">
                                    @error('total_weight')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label">Pump Weight</label>
                                    <input type="number" class="form-control @error('pump_weight') is-invalid @enderror" name="pump_weight" value="{{ old('pump_weight', $product->fragrance->pump_weight ?? '') }}" id="pump_weight">
                                    @error('pump_weight')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label">Bottle Weight</label>
                                    <input type="number" class="form-control @error('bottle_weight') is-invalid @enderror" name="bottle_weight" value="{{ old('bottle_weight', $product->fragrance->bottle_weight ?? '') }}" id="bottle_weight">
                                    @error('bottle_weight')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label">Concentration</label>
                                    <input type="text" class="form-control @error('concentration') is-invalid @enderror" name="concentration" value="{{ old('concentration', $product->fragrance->concentration ?? '') }}" id="concentration">
                                    @error('concentration')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label">Gram</label>
                                    <input type="number" class="form-control @error('gram') is-invalid @enderror" name="gram" value="{{ old('gram', $product->fragrance->gram ?? '') }}" id="gram">
                                    @error('gram')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label">Milliliter</label>
                                    <input type="number" class="form-control @error('milliliter') is-invalid @enderror" name="milliliter" value="{{ old('milliliter', $product->fragrance->mililiter ?? '') }}" id="milliliter">
                                    @error('milliliter')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label w-100">Status</label>
                            <div class="selectgroup selectgroup-pills">
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="1" class="selectgroup-input" {{ $product->status == 1 ? 'checked' : '' }}>
                                    <span class="selectgroup-button">Active</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="0" class="selectgroup-input" {{ $product->status == 0 ? 'checked' : '' }}>
                                    <span class="selectgroup-button">Inactive</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label mt-4">Photo Product</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="image" @error('image') is-invalid @enderror>
                            </div>
                        </div>

                        {{-- is favorite --}}
                        <div class="form-group mt-4">
                            <label class="form-label w-100">Is Favorite</label>
                            <div class="selectgroup selectgroup-pills">
                                <label class="selectgroup-item">
                                    <input type="radio" name="is_favorite" value="1" class="selectgroup-input" {{ $product->is_favorite == 1 ? 'checked' : '' }}>
                                    <span class="selectgroup-button">Yes</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="is_favorite" value="0" class="selectgroup-input" {{ $product->is_favorite == 0 ? 'checked' : '' }}>
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
