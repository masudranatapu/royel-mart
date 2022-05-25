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
                                    <a class="btn btn-success" href="{{ route('admin.product.create') }}">
                                        <i class="fa fa-plus"></i>
                                        Add product
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>P Code</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>S. Price</th>
                                            <th>R. Price</th>
                                            <th>Discount</th>
                                            <th>Category</th>
                                            <th>P. Type</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $key => $product)
                                            <tr id="remove_tr_{{ $product->id }}">
                                                <td>{{$product->product_code}}</td>
                                                <td>
                                                    <img width="50" height="50" src="{{ asset($product->thumbnail) }}">
                                                </td>
                                                <td>{{$product->name}}</td>
                                                <td>{{$product->sale_price}} TK</td>
                                                <td>
                                                    {{$product->regular_price}} TK
                                                </td>
                                                <td>
                                                    {{$product->discount}} TK
                                                </td>
                                                <td>{{$product['category']['name']}}</td>
                                                <td>{{$product->product_type}}</td>
                                                <td>
                                                    @if($product->status == 1)
                                                        <span class="bg-success badge">Active</span>
                                                    @else
                                                        <span class="badge bg-warning text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td width="10%">
                                                    <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-info btn-xs waves-effect btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger waves-effect btn-xs" type="button" onclick="deleteData({{ $product->id }})">
                                                        <i class="fa fa-trash mr-1"></i>
                                                    </button>
                                                    {{-- <form id="delete-form-{{ $product->id }}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form> --}}
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
                    // document.getElementById('delete-form-'+id).submit();

                    $.ajax({
                        url: "{{ route('admin.product-delete') }}",
                        type:"POST",
                        data:{
                            _token: '{{csrf_token()}}',
                            id: id,
                        },
                        success:function(data) {
                            console.log(data);
                            if(data == 'Success'){
                                $('#remove_tr_'+id).remove();
                                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                            }
                        },
                    });

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
