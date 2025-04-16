@extends('backend.master')
@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Service List </h2>
                {{-- <p>Here Your All Catego.</p> --}}
            </div>
            <div>
                <input type="text" placeholder="Search order ID" class="form-control bg-white">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('succ'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ session('succ') }}</li>
                        </ul>
                    </div>
                @endif

                @if (session('err'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ session('err') }}</li>
                        </ul>
                    </div>
                @endif
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Add New Service</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('variation.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="product_name" class="form-label">Service Logo</label>
                                    <input type="file" placeholder="Entire Name" class="form-control" name="logo">
                                </div>
                            </div> --}}
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Service Message</label>
                                        <textarea type="text" placeholder="Entire Name" class="form-control" name="variation_name"> </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label"></label>
                                        <button type="submit"
                                            class="btn btn-light rounded font-sm mr-5 text-body hover-up">+
                                            Add
                                            Service</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- card end// -->
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Service Message</th>
                                        <th scope="col" class="text-end"> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $key => $request)
                                        <tr>
                                            <td><b>{{ $request->message }}</b></td>
                                            <form action="{{ route('variation.destroy', $request->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <td class="text-end">
                                                    <a href="{{ route('variation.edit', $request->id) }}"
                                                        class="btn btn-md rounded font-sm">Edit</a>
                                                    @if (Auth::guard('admin')->user()->role == 'superAdmin')
                                                        <button type="submit"
                                                            class="btn btn-md bg-warning rounded font-sm">Delete</button>
                                                    @endif
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- table-responsive //end -->
                    </div> <!-- card-body end// -->
                </div> <!-- card end// -->
            </div>

        </div>
    </section> <!-- content-main end// -->
@endsection
