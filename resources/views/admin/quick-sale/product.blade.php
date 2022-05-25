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
                                <div class="col-md-12">
                                    <h2>
                                        Quick Sale Products <small class="badge bg-success text-white">{{ $qs_products->count() }}</small>
                                        <button type="button" class="btn btn-sm btn-success pull-right" onclick="updateQuickSaleProduct()"><i class="fa fa-save"></i> Update</button>
                                    </h2>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Main Category</label>
                                    <select id="category" class="form-control select2">
                                        <option value="">Select One</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Parent Category</label>
                                    <select id="subcategory" class="form-control select2">

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Child Category</label>
                                    <select id="subsubcategory" class="form-control select2">

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Products</label>
                                    <select id="select_product_id" class="form-control select2">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <form action="{{ route('admin.update-quick-sale-product') }}" method="POST" id="update-quick-sale-product-form">
                                @csrf
                                <input type="hidden" name="quick_sale_id" id="quick_sale_id" value="{{ $quick_sale_id }}">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap qs-pro-table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="15%" class="text-center">Image</th>
                                                <th>Title</th>
                                                <th width="10%">Discount</th>
                                                <th width="10%">Discount Type</th>
                                                <th width="8%" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($qs_products as $key => $qs_product)
                                                <tr id="product_tr_{{ $qs_product->product_id }}">
                                                    <td>
                                                        <img src="@if(file_exists($qs_product->product->thumbnail)) {{ asset($qs_product->product->thumbnail) }} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" width="100%" height="100px" alt="banner image">
                                                    </td>
                                                    <td>
                                                        <input type="hidden" class="form-control" name="product_id[]" value="{{ $qs_product->product_id }}">
                                                        <a href="{{ route('productdetails', $qs_product->product->slug) }}" target="_blank">{{ $qs_product->product->name }}</a>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="discount[]" value="{{ $qs_product->discount }}">
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="discount_type[]" required id="discount_type">
                                                            <option value="Solid" @if($qs_product->discount_type == 'Solid') selected @endif>Solid (৳)</option>
                                                            <option value="Percentage" @if($qs_product->discount_type == 'Percentage') selected @endif>Percentage (%)</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger waves-effect" type="button" onclick="deleteData({{ $qs_product->id }})">
                                                            <i class="ml-1 fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function mainTham(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showTham').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        };
        function mainThamEdit(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.showThamEdit').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
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

        $('.select2').select2();

        function updateQuickSaleProduct(){
            $('#update-quick-sale-product-form').submit();
        }
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

            $('#category').on('change', function(){
                var category_id = $(this).val();
                // alert(category_id);
                if(category_id) {
                    $.ajax({
                        url: "{{ route('admin.parent-category-for-product') }}",
                        type:"POST",
                        data:{
                            _token: '{{csrf_token()}}',
                            category_id: category_id,
                        },
                        success:function(data) {
                            console.log(data);
                            $('#subsubcategory').html('');
                            $('#subcategory').html(data['cat']);
                            $('#select_product_id').html(data['product']);
                        },
                    });
                } else {
                    alert('danger');
                }
            });

            $('#subcategory').on('change', function(){
                var subcategory_id = $(this).val();
                // alert(subcategory_id);
                if(subcategory_id) {
                    $.ajax({
                        url: "{{ route('admin.child-category-for-product') }}",
                        type:"POST",
                        data:{
                            _token: '{{csrf_token()}}',
                            subcategory_id: subcategory_id,
                        },
                        success:function(data) {
                            console.log(data);
                            $('#subsubcategory').html(data['cat']);
                            $('#select_product_id').html(data['product']);
                        },
                    });
                } else {
                    alert('danger');
                }
            });

            $('#subsubcategory').on('change', function(){
                var subsubcategory_id = $(this).val();
                // alert(subsubcategory_id);
                if(subsubcategory_id) {
                    $.ajax({
                        url: "{{ route('admin.get-category-product-for-qs') }}",
                        type:"POST",
                        data:{
                            _token: '{{csrf_token()}}',
                            subsubcategory_id: subsubcategory_id,
                        },
                        success:function(data) {
                            console.log(data);
                            $('#select_product_id').html(data['product']);
                        },
                    });
                } else {
                    alert('danger');
                }
            });

            $('#select_product_id').on('change', function(){
                var product_id = $(this).val();
                var quick_sale_id = $('#quick_sale_id').val();
                $.ajax({
                    url: "{{ route('admin.add-product-to-qs-list') }}",
                    type:"POST",
                    data:{
                        _token: '{{csrf_token()}}',
                        product_id: product_id,
                        quick_sale_id: quick_sale_id,
                    },
                    success:function(data) {
                        $('.qs-pro-table > tbody:last-child').prepend(data);
                    },
                });
            });

        });
    </script>
@endpush
