@extends('layouts.app')

@section('title', 'Edit Bundle')

@push('style')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Bundle</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('bundles.index') }}">Bundles</a></div>
                <div class="breadcrumb-item">Edit Bundle</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Bundle</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bundles.update', $bundle->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Bundle Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $bundle->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required>{{ $bundle->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" class="form-control datepicker" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="text" class="form-control datepicker" id="end_date" name="end_date" required>
                        </div>
                        <div class="form-group">
                            <label for="items">Bundle Items</label>
                            <div id="bundle-items">
                                @foreach($bundle->items as $index => $item)
                                    <div class="bundle-item mt-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Product</label>
                                                <select name="items[{{ $index }}][product_id]" class="form-control select2 product-select" required>
                                                    <option value="" disabled>Select Product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" @if($product->id == $item->product_id) selected @endif>{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Variant</label>
                                                <select name="items[{{ $index }}][variant]" class="form-control select2 variant-select" required>
                                                    <option value="" disabled>Select Variant</option>
                                                    @foreach($bottles as $bottle)
                                                        <option value="{{ $bottle->variant }}" @if($bottle->id == $item->bottle_id) selected @endif>{{ $bottle->variant }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Bottle Size (ml)</label>
                                                <select name="items[{{ $index }}][bottle_id]" class="form-control select2 bottle-size-select" required>
                                                    <option value="" disabled>Select Bottle Size</option>
                                                    @foreach($bottles as $bottle)
                                                        <option value="{{ $bottle->id }}" @if($bottle->id == $item->bottle_id) selected @endif>{{ $bottle->bottle_size }} ml</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Quantity</label>
                                                <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Discount (%)</label>
                                                <input type="number" name="items[{{ $index }}][discount_percent]" class="form-control discount-input" value="{{ $item->discount }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Harga</label>
                                                <input type="text" name="items[{{ $index }}][harga]" class="form-control harga-input" value="{{ $item->bottle->harga_ml }}" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Harga Setelah Diskon</label>
                                                <input type="text" name="items[{{ $index }}][harga_setelah_diskon]" class="form-control harga-diskon-input" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger mt-4 remove-item">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary mt-3" id="add-item">Add Another Item</button>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Bundle</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });

        let itemIndex = {{ count($bundle->items) }};
        let productData = @json($products);
        let variantData = @json($bottles->pluck('variant')->unique());

        function populateProducts(select) {
            select.empty();
            select.append('<option value="">Select Product</option>');
            $.each(productData, function(key, product) {
                select.append(`<option value="${product.id}">${product.name}</option>`);
            });
            select.trigger('change');
        }

        function populateVariants(select) {
            select.empty();
            select.append('<option value="">Select Variant</option>');
            $.each(variantData, function(key, variant) {
                select.append(`<option value="${variant}">${variant}</option>`);
            });
            select.trigger('change');
        }

        $(document).on('change', '.variant-select', function() {
            let variant = $(this).val();
            let bottleSizeSelect = $(this).closest('.bundle-item').find('.bottle-size-select');
            if (variant) {
                $.ajax({
                    url: `/bundles/get-bottle-sizes-by-variant/${variant}`,
                    method: 'GET',
                    success: function(data) {
                        bottleSizeSelect.empty();
                        bottleSizeSelect.append('<option value="" selected disabled>Select Bottle Size</option>');
                        $.each(data, function(key, bottle) {
                            bottleSizeSelect.append(`<option value="${bottle.id}" data-harga="${bottle.harga_ml}">${bottle.bottle_size} ml</option>`);
                        });
                        bottleSizeSelect.trigger('change');
                    }
                });
            }
        });

        $(document).on('change', '.bottle-size-select', function() {
            let harga = $(this).find(':selected').data('harga');
            let hargaInput = $(this).closest('.bundle-item').find('.harga-input');
            hargaInput.val(harga);
        });

        $(document).on('input', '.discount-input', function() {
            let discount = $(this).val();
            let harga = $(this).closest('.bundle-item').find('.harga-input').val();
            let hargaDiskonInput = $(this).closest('.bundle-item').find('.harga-diskon-input');
            let hargaSetelahDiskon = harga - (harga * (discount / 100));
            hargaDiskonInput.val(hargaSetelahDiskon);
        });

        $('#add-item').click(function() {
            let newItem =
                `<div class="bundle-item mt-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Product</label>
                            <select name="items[${itemIndex}][product_id]" class="form-control select2 product-select" required>
                                <option value="">Select Product</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Variant</label>
                            <select name="items[${itemIndex}][variant]" class="form-control select2 variant-select" required>
                                <option value="">Select Variant</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Bottle Size (ml)</label>
                            <select name="items[${itemIndex}][bottle_id]" class="form-control select2 bottle-size-select" required>
                                <option value="">Select Bottle Size</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Quantity</label>
                            <input type="number" name="items[${itemIndex}][quantity]" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label>Discount (%)</label>
                            <input type="number" name="items[${itemIndex}][discount_percent]" class="form-control discount-input">
                        </div>
                        <div class="col-md-2">
                            <label>Harga</label>
                            <input type="text" name="items[${itemIndex}][harga]" class="form-control harga-input" readonly>
                        </div>
                        <div class="col-md-2">
                            <label>Harga Setelah Diskon</label>
                            <input type="text" name="items[${itemIndex}][harga_setelah_diskon]" class="form-control harga-diskon-input" readonly>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger mt-4 remove-item">Remove</button>
                        </div>
                    </div>
                </div>`;
            $('#bundle-items').append(newItem);
            $('.select2').select2();

            let productSelect = $('.product-select').last();
            let variantSelect = $('.variant-select').last();

            populateProducts(productSelect);
            populateVariants(variantSelect);

            itemIndex++;
        });

        $(document).on('click', '.remove-item', function() {
            $(this).closest('.bundle-item').remove();
        });
    });
</script>
@endpush
