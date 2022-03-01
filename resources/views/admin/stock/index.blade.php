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
                                    <h2>Purchases  <small class="badge bg-success text-white">{{ $purchases->count() }}</small></h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#large-Modal">
                                        <i class="fa fa-plus"></i>
                                        Add Purchases
                                    </button>
                                    <!-- crate modal  -->
                                    <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Add Purchases Product</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.purchase.store') }}" method="POST">
                                                        @csrf
                                                        <div class="row form-group">
                                                            <div class="col-md-4 text-right">
                                                                <label >Product Name </label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select name="product_id" id="product_id_code" class="form-control">
                                                                    <option value="">Select One</option>
                                                                    @foreach($products as $product)
                                                                        <option value="{{ $product->id }}">{{$product->name}} - {{ $product->product_code }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group" id="product_code_show" style="display: none;">
                                                            <div class="col-md-4 text-right">
                                                                <label >Product Code</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" readonly name="product_code" class="form-control" id="product_code_val">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group" id="name_show" style="display: none;">
                                                            <div class="col-md-4 text-right">
                                                                <label >Product Name</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" readonly name="name" class="form-control" id="name_val">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-4 text-right">
                                                                <label >Product Quantity</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="number" name="quantity" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-4">
                                                                <label ></label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="submit" value="PUrchase Product" class="btn btn-success">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
                                <table id="row-callback"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center">Product Code</th>
                                            <th class="text-center">Product Image</th>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Stock Status</th>
                                            <th class="text-center">date in Stock</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchases as $key => $purchase)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{$purchase->product_code}}</td>
                                                <td class="text-center">
                                                    <img width="50" height="50" src="{{ asset($purchase['product']['thambnail']) }}" alt="">
                                                </td>
                                                <td class="text-center">{{$purchase->name}}</td>
                                                <td class="text-center">{{$purchase->quantity}}</td>
                                                <td class="text-center">
                                                    @if($purchase->quantity > 0 )
                                                        <span class="badge bg-success text-white">Stock Available</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Out of Stock</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($purchase->updated_at)
                                                        {{ $purchase->updated_at->format('d M Y h:i A') }}
                                                    @else
                                                        {{ $purchase->created_at->format('d M Y h:i A') }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal-edit{{$key}}">
                                                        <i class="ml-1 fa fa-edit"></i>
                                                    </button>
                                                </td>
                                                <div class="modal fade" id="large-Modal-edit{{$key}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Purchase</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.purchase.update', $purchase->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" value="{{ $purchase->id }}" name="for_edit_id">
                                                                    <div class="row form-group">
                                                                        <div class="col-md-4 text-right">
                                                                            <label >Product Name</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select name="product_id" id="edit_product_id_code_{{ $purchase->id }}" onChange="editProductIdCode('{{ $purchase->id }}')" class="form-control">
                                                                                <option value="">Select One</option>
                                                                                @foreach($editproducts as $product)
                                                                                    <option @if($purchase->product_id == $product->id) selected @endif value="{{ $product->id }}">{{$product->name}} - {{ $product->product_code }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-4 text-right">
                                                                            <label >Product Code</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text" readonly name="product_code" id="product_code_val_{{ $purchase->id }}" value="{{$purchase->product_code}}" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-4 text-right">
                                                                            <label >Product Name</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text" readonly name="name" id="name_val_{{ $purchase->id }}" value="{{$purchase->name}}" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-4 text-right">
                                                                            <label >Product Quantity</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="number" name="quantity" value="{{$purchase->quantity}}" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-4">
                                                                            <label ></label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="submit" value="PUrchase Product" class="btn btn-success">
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
    <script>
        $("#product_id_code").on('change', function(event) {
            // alert('id');
            var product_id = $("#product_id_code").val();
            // alert(product_id);
            if(product_id){
                $.ajax({
                    type    : "POST",
                    url     : "{{ route('admin.stock.purchase') }}",
                    data    : {
                            product_id: product_id,
                            _token: '{{csrf_token()}}',
                        },
                    success : function(data) {
                        console.log(data);
                        // show all hide row 
                        $("#product_code_show").show();
                        $("#name_show").show();
                        // show val on input field
                        $("#product_code_val").val(data[0]);
                        $("#name_val").val(data[1]);
                    },
                });
            }else {
                alert('Select your product');
            }
        });
        function editProductIdCode(id) {
            var product_id = $("#edit_product_id_code_"+id).val();
            // alert(product_id);
            if(product_id){
                $.ajax({
                    type    : "POST",
                    url     : "{{ route('admin.stock.purchase') }}",
                    data    : {
                            product_id: product_id,
                            _token: '{{csrf_token()}}',
                        },
                    success : function(data) {
                        console.log(data);
                        // show val on input field
                        $("#product_code_val_" + id).val(data[0]);
                        $("#name_val_" + id).val(data[1]);
                    },
                });
            }else {
                alert('Select your product');
            }
        };
    </script>
@endpush