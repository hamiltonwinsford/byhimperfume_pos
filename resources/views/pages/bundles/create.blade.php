@extends('layouts.app')

@section('title', 'Create Bundle')

@push('style')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Create Bundle</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('bundles.index') }}">Bundles</a></div>
                <div class="breadcrumb-item">Create Bundle</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Create New Bundle</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bundles.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="branch">Select Branch</label>
                            <select name="branch_id" id="branch" class="form-control select2" required>
                                <option value="" selected disabled>Select Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Bundle Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="items">Bundle Items</label>
                            <div id="bundle-items">
                                <div class="bundle-item">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Product</label>
                                            <select name="items[0][product_id]" class="form-control select2 product-select" required>
                                                <option value="" selected disabled>Select Product</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Variant</label>
                                            <select name="items[0][variant_id]" class="form-control select2 variant-select" required>
                                                <option value="" selected disabled>Select Variant</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Bottle Size (ml)</label>
                                            <select name="items[0][bottle_size]" class="form-control select2 bottle-size-select" required>
                                                <option value="" selected disabled>Select Bottle Size</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Quantity</label>
                                            <input type="number" name="items[0][quantity]" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Discount (%)</label>
                                            <input type="number" name="items[0][discount_percent]" class="form-control discount-input">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Harga</label>
                                            <input type="text" name="items[0][harga]" class="form-control harga-input" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Harga Setelah Diskon</label>
                                            <input type="text" name="items[0][harga_setelah_diskon]" class="form-control harga-diskon-input" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary mt-3" id="add-item">Add Another Item</button>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Bundle</button>
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

    let itemIndex = 1;
    let productData = [];
    let variantData = [];

    $('#branch').change(function() {
        let branchId = $(this).val();
        if (branchId) {
            $.ajax({
                url: `/bundles/get-products-by-branch/${branchId}`,
                method: 'GET',
                success: function(data) {
                    console.log(data); // Debug response dari server
                    productData = data; // Simpan data produk dalam variabel global
                    $('.product-select').each(function() {
                        $(this).empty();
                        $(this).append('<option value="">Select Product</option>');
                        $.each(productData, function(key, product) {
                            $(this).append(`<option value="${product.id}">${product.name}</option>`);
                        }.bind(this));
                        $(this).trigger('change'); // Trigger change event to update Select2
                    });
                }
            });
        }
    });

    $.ajax({
        url: `/bundles/get-variants`,
        method: 'GET',
        success: function(data) {
            console.log(data); // Debug response dari server
            variantData = data; // Simpan data produk dalam variabel global
            $('.variant-select').each(function() {
                $(this).empty();
                $(this).append('<option value="" selected disabled>Select Variant</option>');
                $.each(variantData, function(key, variant) {
                    $(this).append(`<option value="${variant}">${variant}</option>`);
                }.bind(this));
                $(this).trigger('change'); // Trigger change event to update Select2
            });
        }
    });

    $(document).on('change', '.variant-select', function() {
        let variant = $(this).val();
        let bottleSizeSelect = $(this).closest('.bundle-item').find('.bottle-size-select');
        if (variant) {
            $.ajax({
                url: `/bundles/get-bottle-sizes-by-variant/${variant}`,
                method: 'GET',
                success: function(data) {
                    console.log(data); // Tambahkan ini untuk debug response dari server
                    bottleSizeSelect.empty();
                    bottleSizeSelect.append('<option value="" selected disabled>Select Bottle Size</option>');
                    $.each(data, function(key, bottle) {
                        bottleSizeSelect.append(`<option value="${bottle.bottle_size}" data-harga="${bottle.harga_ml}">${bottle.bottle_size} ml</option>`);
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
                </div>
            </div>`;
        $('#bundle-items').append(newItem);
        $('.select2').select2();

        $('.product-select').last().empty();
        $('.product-select').last().append('<option value="">Select Product</option>');
        $.each(productData, function(key, product) {
            $('.product-select').last().append(`<option value="${product.id}">${product.name}</option>`);
        });

        // Isi dropdown varian pada item baru
        $('.variant-select').last().empty();
        $('.variant-select').last().append('<option value="">Select Variant</option>');
        $.each(variantData, function(key, variant) {
            $('.variant-select').last().append(`<option value="${variant}">${variant}</option>`);
        });

        itemIndex++;
    });
});

</script>
@endpush
