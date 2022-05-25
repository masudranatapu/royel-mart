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
                                <div class="col-md-5">
                                    <h2>Sold Products  <small class="badge bg-success text-white">{{ $solds->count() }}</small></h2>
                                </div>
                                <div class="col-md-7">
                                    <form action="{{ route('admin.sold.search') }}" method="GET">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Product Code</label>
                                                <select name="product_code" id="" class="form-control">
                                                    <option value="" >Select Product Code</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->product_code }}">{{ $product->name }} - {{ $product->product_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Form Date</label>
                                                <input type="date" name="formDate" placeholder="Form Date" class="form-control" value="{{$form}}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">To Date</label>
                                                <input type="date" name="toDate" placeholder="To Date" class="form-control" value="{{$to}}">
                                            </div>
                                            <div class="col-md-1 text-right">
                                                <br>
                                                <button type="submit" class="btn btn-success mt-2">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center">Order Id</th>
                                            <th class="text-center">Order Code</th>
                                            <th class="text-center">Product Id</th>
                                            <th class="text-center">Product Code</th>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center">quantity</th>
                                            <th class="text-center">Create</th>
                                            <th class="text-center">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($solds as $key => $sold)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $sold->order_id }}</td>
                                                <td class="text-center">{{ $sold->order_code }}</td>
                                                <td class="text-center">{{ $sold->product_id }}</td>
                                                <td class="text-center">{{ $sold->product_code }}</td>
                                                <td class="text-center">{{ $sold->name }}</td>
                                                <td class="text-center">{{ $sold->quantity }}</td>
                                                <td class="text-center">{{ $sold->created_at->format('d M Y h:i A') }}</td>
                                                <td class="text-center">
                                                    <button title="Edit Brand" type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit_{{$key}}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
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
                                                                <h4 class="modal-title">Sold Info</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

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
