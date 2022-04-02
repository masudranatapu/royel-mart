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
                        <div class="card-body">
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
                    </div>
                    <hr>
                    <form action="{{ route('admin.store-product-for-purchase') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h2>
                                            Product List
                                            <button type="submit" class="btn btn-sm btn-success pull-right"><i class="fa fa-save"></i> Save Purchase</button>
                                        </h2>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="purchase_product_add_table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th width="10%">Quantity</th>
                                                    <th width="10%">B. Price</th>
                                                    <th width="10%">S. Price</th>
                                                    <th width="6%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <label>Subtotal</label>
                                                <input class="form-control" type="number" readonly id="grand_sub_total" name="grand_sub_total" value="0">
                                            </div>
                                            <div class="col-md-12">
                                                <label>Paid</label>
                                                <input class="form-control" type="number" id="paid" name="paid" value="0">
                                            </div>
                                            <div class="col-md-12">
                                                <label>Due</label>
                                                <input class="form-control" readonly type="number" id="due" name="due" value="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="submit" class="btn btn-info" value="Purchase Now">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('massage/sweetalert/sweetalert.all.js')}}"></script>

    <script type="text/javascript">
        $('.select2').select2();
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
                if($(".tr_exist_" + product_id).length == 0) {
                    $.ajax({
                        url: "{{ route('admin.add-product-for-purchase') }}",
                        type:"POST",
                        data:{
                            _token: '{{csrf_token()}}',
                            product_id: product_id,
                        },
                        success:function(data) {
                            console.log(data);
                            $('#purchase_product_add_table > tbody:last-child').prepend(data);
                        },
                    });
                }else{
                    swal(
                        'Product already added for purchase!',
                        '',
                        'error'
                    )
                }
            });

        });

        function removeSizeProduct(product_id, color_id, size_id){
            $('#product_tr_size_'+product_id+'_'+color_id+'_'+size_id).remove();
        }

        function removeColorProduct(product_id, color_id){
            $('#product_tr_color_'+product_id+'_'+color_id).remove();
        }

        function removeProduct(product_id){
            $('#product_tr_'+product_id).remove();
        }

        function storePurchse(){
            $('#purchase_form').submit();
        }
    </script>

@endpush
