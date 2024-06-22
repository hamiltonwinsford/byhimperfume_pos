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
                                <option value="">Select Branch</option>
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
                                                <option value="">Select Product</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Bottle Size (ml)</label>
                                            <select name="items[0][bottle_id]" class="form-control select2">
                                                @foreach ($bottles as $bottle)
                                                    <option value="{{ $bottle->id }}">{{ $bottle->size }} ml</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Quantity</label>
                                            <input type="number" name="items[0][quantity]" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Discount (%)</label>
                                            <input type="number" name="items[0][discount_percent]" class="form-control" required>
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

        $('#branch').change(function() {
            let branchId = $(this).val();
            if (branchId) {
                $.ajax({
                    url: `/bundles/get-products-by-branch/${branchId}`,
                    method: 'GET',
                    success: function(data) {
                        $('.product-select').each(function() {
                            $(this).empty();
                            $(this).append('<option value="">Select Product</option>');
                            $.each(data, function(key, product) {
                                $(this).append(`<option value="${product.id}">${product.name}</option>`);
                            }.bind(this));
                            $(this).trigger('change'); // Trigger change event to update Select2
                        });
                    }
                });
            }
        });

        $('#add-item').click(function() {
            let newItem = `
                <div class="bundle-item mt-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Product</label>
                            <select name="items[${itemIndex}][product_id]" class="form-control select2 product-select" required>
                                <option value="">Select Product</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Bottle Size (ml)</label>
                            <select name="items[${itemIndex}][bottle_id]" class="form-control select2">
                                @foreach ($bottles as $bottle)
                                    <option value="{{ $bottle->id }}">{{ $bottle->size }} ml</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Quantity</label>
                            <input type="number" name="items[${itemIndex}][quantity]" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label>Discount (%)</label>
                            <input type="number" name="items[${itemIndex}][discount_percent]" class="form-control" required>
                        </div>
                    </div>
                </div>`;
            $('#bundle-items').append(newItem);
            $('.select2').select2();
            itemIndex++;
        });
    });
</script>
@endpush
