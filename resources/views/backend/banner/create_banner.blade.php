@extends('backend.master')
@section('content')
    <section class="content-main">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Add New Banner</h4>
                        <a href="{{ route('banner.index') }}" class="btn btn-primary">List</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Select A Category</label>
                                        <select class="form-select" name="banner_category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"> {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Banner Title</label>
                                        <input type="text" placeholder="Entire Name" class="form-control"
                                            name="banner_title">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Banner Image <span
                                                style="margin-left: 2px; font-size: 10px;color: #088178">Size( w-1266,
                                                h-842)</span></label>
                                        <input type="file" class="form-control" name="banner_image">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Link</label>
                                        <input type="text" placeholder="Entire Email" class="form-control"
                                            name="link">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Banner Description</label>
                                        <textarea class="form-control" name="banner_description" id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label"></label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label"></label>
                                        <button type="submit"
                                            class="btn btn-light rounded font-sm mr-5 text-body hover-up">+ Add
                                            Banner</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- card end// -->
            </div>
        </div>
    </section>
@endsection
