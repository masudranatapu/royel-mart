@extends('layouts.backend.app')

@section('title')
    {{$title}}
@stop

@push('css')

@endpush

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Product <small class="badge bg-success text-white">{{ $products->count() }}</small></h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a class="btn btn-success" href="{{ route('admin.product.create') }}" target="__blank">
                                        <i class="fa fa-plus"></i>
                                        Add product
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
                                <table id="row-callback"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Product code</th>
                                            <th>Thambnail</th>
                                            <th>Name</th>
                                            <th>Sell price</th>
                                            <th>Regular price</th>
                                            <th>Discount</th>
                                            <th>Category Name</th>
                                            <th>Availability</th>
                                            <th>Product Type</th>
                                            <th>Product Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $key => $product)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{$product->product_code}}</td>
                                                <td>
                                                    <img src="{{ asset($product->thambnail) }}" style="width: 50px; height: 50px;">
                                                </td>
                                                <td>{{$product->name}}</td>
                                                <td>{{$product->sell_price}} TK</td>
                                                <td>
                                                    @if($product->regular_price)
                                                        {{ $product->regular_price }} TK
                                                    @else
                                                        {{$product->sell_price}} TK
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($product->discount)
                                                        {{ $product->discount }} % 
                                                    @else 
                                                        <span class="badge bg-warning">No Discount</span>
                                                    @endif
                                                </td>
                                                <td>{{$product['category']['name']}}</td>
                                                <td>
                                                    @if($product->availability == 1)
                                                        <span class="badge bg-success">Availability</span>
                                                    @else 
                                                        <span class="badge bg-warning">Unavailability</span>
                                                    @endif
                                                </td>
                                                <td>{{$product->product_type}}</td>
                                                <td>
                                                    @if($product->product_type == 1)
                                                        <span class="badge bg-sucess text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-warning text-white">Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info waves-effect btn-xs" target="blank">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger waves-effect btn-xs" type="button" onclick="deleteData({{ $product->id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
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
    </div>
@endsection

@push('js')

@endpush