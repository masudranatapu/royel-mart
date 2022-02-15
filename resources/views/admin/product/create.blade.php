@extends('layouts.backend.app')

@section('title')
    {{$title}}
@stop

@push('css')
    <link rel="stylesheet" href="{{asset('backend/select2/css/select2.css')}}">
@endpush

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>
                                        {{ $title }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item"  style="float: left;">
                                        <a href="{{ route('admin.dashboard') }}">
                                            Home
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item"  style="float: left;">
                                        <a href="javascript:;">
                                            {{ $title }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="">Product Name</label>
                                        <input type="text"  class="form-control" name="name" placeholder="Product Name">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Cover Image <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" onChange="mainTham(this)" name="thambnail" class="custom-file-input">
                                                <label class="custom-file-label">Choose cover image</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <img src="" id="showTham">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label>Buying price</label>
                                        <input type="number" min="0" value="0"  class="form-control" name="buying_price" placeholder="Buying price" id="regular_price">
                                    </div>
                                    <div class="col-md-4">
                                        <label >Discount</label>
                                        <input type="number" min="0" value="0"  class="form-control" name="discount" placeholder="Discount" id="discount" pattern="[0-9]*\.?[0-9]*">
                                    </div>
                                    <div class="col-md-4">
                                        <label >Sell Price <span class="text-danger"> *</span></label>
                                        <input type="number" min="0" value="0"  class="form-control" name="sale_price" placeholder="Sell price" id="sale_price">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label>More Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="multi_thambnail[]" multiple="" id="multi_tham" class="custom-file-input">
                                                <label class="custom-file-label">Choose More Image</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row" id="preview_image"></div>
                                    </div>
                                </div>
                                <div class="row mt-3" id="showSelectedUnits">
                                    <div class="col-md-6">
                                        <label>Units</label>
                                        <select id="getUnitId" class="form-control">
                                            <option value="">Select One</option>
                                            @foreach($units as $key=>$unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Minimum Quantity</label>
                                        <input type="number" name="minimum_quantity" class="form-control" value="5" placeholder="Minimum Quantity">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label>Description </label>
                                        <textarea class="form-control" rows="5" name="description" placeholder="Description"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label >Brand</label>
                                        <select name="brand_id" id="" class="form-control">
                                            <option value="" disabled selected>Select One</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label >Category <span class="text-danger"> *</span></label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option value="">Select One</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Sub Category</label>
                                        <select name="subcategory_id" id="subcategory" class="form-control">
                                            <option value="">First Select Category</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Sub Sub Category</label>
                                        <select name="subsubcategory_id" id="subsubcategory" class="form-control">
                                            <option value="">First Select Sub Category</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>Product Type <span class="text-danger"> *</span></label>
                                        <select name="product_type" class="form-control">
                                            <option value="" disabled>Select One</option>
                                            <option value="New Arrival" selected>New Arrival</option>
                                            <option value="Hot Deals">Hot Deals</option>
                                            <option value="Features">Features</option>
                                            <option value="Best Selling">Best Selling</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Status<span class="text-danger"> *</span></label>
                                        <select name="status" id="" class="form-control">
                                            <option value="" disabled >Select One</option>
                                            <option value="1" selected>Active</option>
                                            <option class="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label>Schema</label>
                                        <textarea class="form-control" rows="3" name="schema" placeholder="Schema"></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Meta Keyword</label>
                                        <textarea class="form-control" rows="3" name="meta_keyword" placeholder="Meta Keyword"></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label >Meta Description</label>
                                        <textarea class="form-control" rows="3" name="meta_description" placeholder="Meta Description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <input type="submit" class="btn btn-success" value="Create Product">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('backend/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('massage/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        $('.select2').select2()
        // show thambnill
        function mainTham(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showTham').attr('src', e.target.result).width(100).height(80);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('#regular_price').on('wheel keyup change', function(event) {
            var regular_price = $("#regular_price").val();
            var discount = $("#discount").val();
            var sale_price = regular_price - (regular_price*(discount/100));
            $("#sale_price").val(sale_price);
        });
        $('#discount').on('wheel keyup change', function(event) {

            var regular_price = $("#regular_price").val();
            var discount = $("#discount").val();

            var sale_price = regular_price - discount;

            $("#sale_price").val(sale_price);
        });
        $('#sale_price').on('wheel keyup change', function(event) {
            var regular_price = $("#regular_price").val();
            var sale_price = $("#sale_price").val();

            var diff = regular_price - sale_price;
            var discount = (diff/regular_price)*100;
            if (regular_price=='') {
                discount = 0;
            }
            $("#discount").val(discount);
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#multi_tham').on('change', function(){ //on file input change
                if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
                {
                    var data = $(this)[0].files; //this file data
                    $.each(data, function(index, file){ //loop though each file
                        if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file){ //trigger function on successful read
                            return function(e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                            .height(100); //create image element 
                                $('#preview_image').append(img); //append image to output element
                            };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });
                }else{
                    alert("Your browser doesn't support File API!"); //if File API is absent
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#category').on('change', function(){
                var category_id = $(this).val();
                // alert(category_id);
                if(category_id) {
                    $.ajax({
                        url: "{{  url('/admin/product-category/ajax') }}/"+category_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            $('#subsubcategory').html('');
                            var d =$('#subcategory').empty();
                            $('#subcategory').append('<option value="" disabled selected> Select One </option>');
                            $.each(data, function(key, value){
                                $('#subcategory').append('<option value="'+ value.id +'">' + value.name + '</option>');
                            });
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
                        url: "{{  url('/admin/product-subcategory/ajax') }}/"+subcategory_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                        var d =$('#subsubcategory').empty();
                            $('#subsubcategory').append('<option value="" disabled selected> Select One </option>');
                            $.each(data, function(key, value){
                                $('#subsubcategory').append('<option value="'+ value.id +'">' + value.name + '</option>');
                            });
                        },
                    });
                } else {
                    alert('danger');
                }
            });
        });
    </script>
    <script>
        $("#getUnitId").on('change', function(){
            // alert('hell');
            var getUnitId = $("#getUnitId").val();
            // alert(getUnitId);
            if($("#new_color_area_" + getUnitId).length == 0){
                $.ajax({
                    type    : "POST",
                    url     : "{{ route('admin.unitid.ajax') }}",
                    data    : {
                            getUnitId: getUnitId,
                            _token: '{{csrf_token()}}',
                        },
                    success : function(data) {
                        console.log(data);
                        $(data).insertAfter('#showSelectedUnits');
                    },
                });
            }else {
                swal(
                    'Unit already added!',
                    '',
                    'error'
                );
            };
        });
        function removeNewColorAre(obj){
            var id = obj.id;
            $('#new_color_area_'+id).remove();
        }
    </script>
@endpush