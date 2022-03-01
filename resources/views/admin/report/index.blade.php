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
                                <div class="col-md-8">
                                    <h2>Products  <small class="badge bg-success text-white">{{ $products->count() }}</small></h2>
                                </div>
                                <div class="col-md-4">
                                    <form action="{{ route('admin.sold-product-report.search') }}" method="GET">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-7">
                                                <label for="">Product Code</label>
                                                <select name="product_code" id="" class="form-control">
                                                    <option value="" >Select Product Code</option>
                                                    @foreach($myproducts as $myproduct)
                                                        <option value="{{ $myproduct->product_code }}">{{ $myproduct->name }} - {{ $myproduct->product_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
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
                            <div class="table-responsive dt-responsive">
                                <table id="row-callback"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center">Product code</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">In Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $key => $product)
                                            @php
                                                $purchases = App\Models\Purchases::where('product_id', $product->id)->sum('quantity');
                                                $sold = App\Models\Sold::where('product_id', $product->id)->sum('quantity');
                                                $stock =  $purchases - $sold;
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $product->product_code }}</td>
                                                <td class="text-center">{{ $product->name }}</td>
                                                <td class="text-center">
                                                    @if($stock <= 0)
                                                        <span class="bg-success text-white">No Product In Stock</span>
                                                    @else
                                                        {{ $stock }} Pices
                                                    @endif
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