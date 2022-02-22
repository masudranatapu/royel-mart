@extends('layouts.backend.app')

@section('title')
    {{$title}}
@stop

@push('css')
    <link rel="stylesheet" href="{{asset('backend/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('backend/summernote/summernote-bs4.min.css')}}">
@endpush

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <form action="{{ route('admin.product.update', $products->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Product Name</label>
                                                <input type="text"  class="form-control" name="name" value="{{ $products->name }}">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label>Product Name ( Bangla )</label>
                                                <input type="text"  class="form-control" name="name_bg" value="{{ $products->name_bg }}" placeholder="Product Name ( Bangla )">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Buying price</label>
                                                        <input type="number" min="0" value="{{ $products->buying_price }}" class="form-control" name="buying_price" placeholder="Buying price" id="regular_price">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Discount</label>
                                                        <input type="number" min="0" value="{{ $products->discount }}"  class="form-control" name="discount" placeholder="Discount" id="discount" pattern="[0-9]*\.?[0-9]*">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Sell Price <span class="text-danger"> * </span></label>
                                                        <input type="number" min="0" value="{{ $products->sale_price }}"  class="form-control" name="sale_price" placeholder="Sell price" id="sale_price">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Minimum Quantity</label>
                                                        <input type="number" name="minimum_quantity" class="form-control" value="{{ $products->minimum_quantity }}" placeholder="Minimum Quantity">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Cover Image <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" onChange="mainTham(this)" name="thambnail" class="custom-file-input">
                                                                <label class="custom-file-label">Uploade</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>More Image</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" name="multi_thambnail[]" multiple="" id="multi_tham" class="custom-file-input">
                                                                <label class="custom-file-label">Uploade</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <img width="50" height="50" src="{{ asset($products->thambnail) }}" id="showTham">
                                                    </div>
                                                    <div class="col-md-6" id="newmultiproduct_display" style="display: none;">
                                                        <div class="row" id="preview_image"></div>
                                                    </div>
                                                    <div class="col-md-6" id="oldmultiproduct_display">
                                                        <div class="row">
                                                            @if($products->multi_thambnail)
                                                                @php
                                                                    $multiproduct = explode('|', $products->multi_thambnail)
                                                                @endphp
                                                                @foreach($multiproduct as $key => $mulipro)
                                                                    <img src="{{ asset($mulipro) }}" width="50" height="50">
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Category <span class="text-danger"> * </span></label>
                                                        <select name="category_id" id="category" class="form-control">
                                                            <option value="">Select One</option>
                                                            @foreach($categories as $category)
                                                                <option @if($category->id == $products->category_id) selected @endif value="{{$category->id}}" value="{{$category->id}}">{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Brand</label>
                                                        <select name="brand_id" class="form-control">
                                                            <option value="" disabled selected>Select One</option>
                                                            @foreach($brands as $brand)
                                                                <option @if($brand->id == $products->brand_id) selected @endif value="{{$brand->id}}" value="{{$brand->id}}">{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6" id="sub_cate_display">
                                                        <label>Parent Category</label>
                                                        <select name="parent_id" id="subcategory" class="form-control">
                                                            <option value="">Select One</option>
                                                            @foreach($subcategory as $subcate)
                                                                <option @if($subcate->id == $products->subcategory_id) selected @endif value="{{ $subcate->name }}">{{ $subcate->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6" id="sub_sub_cate_display">
                                                        <label>Child Category</label>
                                                        <select name="child_id" id="subsubcategory" class="form-control">
                                                            <option value="" selected >Select One</option>
                                                            @foreach($subsubcategory as $subsubcate)
                                                                <option @if($subsubcate->id == $products->subsubcategory_id) selected @endif value="{{ $subsubcate->id }}">{{ $subsubcate->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <label>Product Type <span class="text-danger"> *</span></label>
                                                        <select name="product_type" class="form-control">
                                                            <option value="" disabled>Select One</option>
                                                            <option @if($products->product_type == 'New Arrival') selected @endif value="New Arrival" selected>New Arrival</option>
                                                            <option @if($products->product_type == 'Features') selected @endif value="Features">Features</option>
                                                            <option @if($products->product_type == 'Best Selling') selected @endif value="Best Selling">Best Selling</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Status<span class="text-danger"> *</span></label>
                                                        <select name="status" id="" class="form-control">
                                                            <option value="" disabled >Select One</option>
                                                            <option @if($products->status == 1) selected @endif value="1" selected>Active</option>
                                                            <option @if($products->status == 0) selected @endif class="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="row" id="showSelectedUnits">
                                                    <div class="col-md-12">
                                                        <label>Units</label>
                                                        <select id="getUnitId" class="form-control">
                                                            <option value="">Select One</option>
                                                            @foreach($units as $key=>$unit)
                                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @foreach($productUnits as $productUnit)
                                                    <div class="row mt-3" id="new_color_area_{{$productUnit->unit_id}}">
                                                        <div class="col-md-3">
                                                            @php
                                                                $units = App\Models\Unit::where('id', $productUnit->unit_id)->first();
                                                            @endphp
                                                            <input type="hidden" class="form-control" name="unit_id[]" value="{{$productUnit->unit_id}}">
                                                            <label>Unit Name</label>
                                                            <input type="text" class="form-control" readonly value="{{ $units->name }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Image</label>
                                                            <input type="file" class="form-control" name="image_{{$productUnit->unit_id}}" id="image_{{ $productUnit->unit_id }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Sub Unit</label>
                                                            <select name="subunit_id_{{ $productUnit->unit_id }}[]" class="form-control select2" multiple="multiple" data-placeholder="Select Sub Unit">
                                                                @foreach($productsubunits as $productsubunit)
                                                                    <option value="{{ $productsubunit->subunit_id }}">{{ $productsubunit->id }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Action</label><br>
                                                            <button type="button" class="btn btn-danger" id="{{ $productUnit->unit_id }}" onclick="removeNewColorAre(this)">
                                                                <i class="ml-1 fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                        <label>Product Description</label>
                                                        <textarea class="form-control summernote" style="height: 500px;" name="description" placeholder="Description">{{ $products->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mt-2">
                                                <label>Outside Delivery </label>
                                                <input type="text" name="outside_delivery" class="form-control" value="{{ $products->outside_delivery }}">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label>Inside Delivery </label>
                                                <input type="text" name="inside_delivery" class="form-control" value="{{ $products->inside_delivery }}">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label>Return Status </label>
                                                <input type="text" name="return_status" class="form-control" value="{{ $products->return_status }}">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label>Warranty Policy</label>
                                                <input type="text" name="warranty_policy" class="form-control" value="{{ $products->warranty_policy }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mt-2">
                                                <label>Schema</label>
                                                <textarea class="form-control" rows="3" name="schema" placeholder="Schema">{{ $products->schema }}</textarea>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label>Meta Keyword</label>
                                                <textarea class="form-control" rows="3" name="meta_keyword" placeholder="Meta Keyword">{{ $products->meta_keyword }}</textarea>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label >Meta Description</label>
                                                <textarea class="form-control" rows="3" name="meta_description" placeholder="Meta Description">{{ $products->meta_description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-upload"></i>
                                    Update Product
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('backend/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('backend/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('massage/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        // Summernote
        $('.summernote').summernote()

        $('.select2').select2()
        // show thambnill
        function mainTham(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showTham').attr('src', e.target.result).width(50).height(50);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('#regular_price').on('wheel keyup change', function(event) {
            var regular_price = $("#regular_price").val();
            var discount = $("#discount").val();
            var sale_price = regular_price - discount;

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

            if (regular_price=='') {
                discount = 0;
            }
            $("#discount").val(diff);
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

                                $('#newmultiproduct_display').show(); // only show whene the multiproduct will be change then 
                                $('#oldmultiproduct_display').hide(); //if product selected then old multi product willbe hide

                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result).width(50).height(50); //create image element 
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
                            $('#sub_cate_display').show();
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
                            $('#sub_sub_cate_display').show();
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
@endpush