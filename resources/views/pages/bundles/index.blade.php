@extends('layouts.app')

@section('title', 'Bundle')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Bundle</h1>
            <div class="section-header-button">
                <a href="{{ route('bundles.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Bundle</a></div>
                <div class="breadcrumb-item">All Bundle</div>
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
                            <h4>All Bundle</h4>
                        </div>
                        <div class="card-body">

                            <div class="float-right">
                                <form method="GET" action="{{ route('bundles.index') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Products</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bundles as $bundle)
                                        <tr>
                                            <td>{{ $bundle->name }}</td>
                                            <td>{{ $bundle->description }}</td>
                                            <td>{{ $bundle->price }}</td>
                                            <td>{{ $bundle->start_date }}</td>
                                            <td>{{ $bundle->end_date }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($bundle->items as $item)
                                                        <li>{{ $item->product->name }} ({{ $item->quantity }})</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href='{{ route('bundles.edit', $bundle->id) }}' class="btn btn-sm btn-info btn-icon">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('bundles.destroy', $bundle->id) }}" method="POST" class="ml-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                            <i class="fas fa-times"></i> Delete
                                                        </button>
                                                    </form>
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
<!-- JS Libraries -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
