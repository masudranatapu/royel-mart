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
                                    <a href="{{ route('admin.purchase.create') }}" type="button" class="btn btn-success">
                                        <i class="fa fa-plus"></i>
                                        Add Purchase Product
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">SL No</th>
                                            <th width="6%">P. Code</th>
                                            <th>Product</th>
                                            <th width="8%">Quantity</th>
                                            <th width="5%">Buying Price</th>
                                            <th width="5%">Sale Price</th>
                                            <th width="7%">Date</th>
                                            <th width="7%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchases as $key => $purchase)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{$purchase->purchase_code}}</td>
                                                <td>
                                                    @foreach ($purchase->products as $key=>$pur_product)
                                                        <div class="row pb-2 mb-2" style="border-bottom: solid 1px rgb(228, 225, 225)">
                                                            <div class="col-2">
                                                                <img width="50" height="50" src="{{ URL::to($pur_product->product->thumbnail) }}" alt="">
                                                            </div>
                                                            <div class="col-9">
                                                                {{ $pur_product->product->name }} <br>
                                                                @if ($pur_product->color_id != NULL)
                                                                    Color: {{ App\Models\Color::find($pur_product->color_id)->name }}
                                                                @endif
                                                                @if ($pur_product->size_id != NULL)
                                                                    <i class="fa fa-arrow-right"></i> Size: {{ App\Models\Size::find($pur_product->size_id)->name }}
                                                                @endif
                                                            </div>
                                                            <div class="col-1">
                                                                {{ $pur_product->quantity }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>{{$purchase->products->sum('quantity')}}</td>
                                                <td>
                                                    @foreach ($purchase->products as $key=>$pur_product)
                                                        <div class="pb-2 mb-2" style="border-bottom: solid 1px rgb(228, 225, 225)">
                                                            {{ $pur_product->buying_price }}
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($purchase->products as $key=>$pur_product)
                                                        <div class="pb-2 mb-2" style="border-bottom: solid 1px rgb(228, 225, 225)">
                                                            {{ $pur_product->sale_price }}
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $purchase->created_at->format('d M Y h:i A') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.purchase.edit', $purchase->id) }}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                                    <button class="btn btn-sm btn-danger waves-effect" type="button" onclick="deleteData({{ $purchase->id }})">
                                                        <i class="ml-1 fa fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $purchase->id }}" action="{{ route('admin.purchase.destroy', $purchase->id) }}" method="POST" style="display: none;">
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
    <script src="{{asset('massage/sweetalert/sweetalert.all.js')}}"></script>
    <script type="text/javascript">
        function deleteData(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    // event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
