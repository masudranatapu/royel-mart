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
                                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteData({{ $purchase->id }})">
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