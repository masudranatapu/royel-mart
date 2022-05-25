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
                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Product Name</label>
                                                <input type="text"  class="form-control" name="name" placeholder="Product Name">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label>Product Name ( Eng )</label>
                                                <input type="text"  class="form-control" name="name_en" placeholder="Product Name ( Eng )">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Regular Price</label>
                                                                <input name="regular_price" type="number" class="form-control" id="regular_price" placeholder="Only number" value="0">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Sell Price <span class="text-danger"> * </span></label>
                                                                <input name="sale_price" readonly  type="number" class="form-control" id="sell_price" placeholder="Only number" value="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Discount</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">৳</span>
                                                                    </div>
                                                                    <input class="form-control" id="discount_tk" type="number" pattern="[0-9]*\.?[0-9]*" title="Numbers only and dot" name="discount_tk" value="0">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Discount Per</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">%</span>
                                                                    </div>
                                                                    <input class="form-control" id="discount" type="number" pattern="[0-9]*\.?[0-9]*" title="Numbers only and dot" name="discount" value="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Inside Shipping</label>
                                                        <input type="number" name="inside_shipping_charge" id="inside_shipping_charge" class="form-control" value="0" min="0" placeholder="Shipping Charge">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Outside Shipping</label>
                                                        <input type="number" name="outside_shipping_charge" id="outside_shipping_charge" class="form-control" value="0" min="0" placeholder="Shipping Charge">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Shipping Type</label>
                                                        <select class="form-control" name="free_shipping_charge" id="free_shipping_charge">
                                                            <option value="1" selected>Paid</option>
                                                            <option value="0">Free</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Cover Image <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" onChange="mainTham(this)" name="thumbnail" class="custom-file-input">
                                                                <label class="custom-file-label">Uploade</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>More Image</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" name="more_image[]" multiple="" id="multi_tham" class="custom-file-input">
                                                                <label class="custom-file-label">Uploade</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <img width="50" height="50" src="{{ asset('demomedia/demoproduct.png') }}" id="showTham">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row" id="preview_image"></div>
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
                                                    <div class="col-md-12">
                                                        <label>Category <span class="text-danger"> * </span></label>
                                                        <select name="category_id" id="category" class="form-control select2">
                                                            <option value="">Select One</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Parent Category</label>
                                                <select name="parent_id" id="subcategory" class="form-control select2">

                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Child Category</label>
                                                <select name="child_id" id="subsubcategory" class="form-control select2">

                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <label>Product Type <span class="text-danger"> *</span></label>
                                                        <select name="product_type" class="form-control select2">
                                                            <option value="" disabled>Select One</option>
                                                            <option value="New Arrival" selected>New Arrival</option>
                                                            <option value="Features">Features</option>
                                                            <option value="Best Selling">Best Selling</option>
                                                            <option value="Hot Collections">Hot Collections</option>
                                                            <option value="Trending">Trending</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Status<span class="text-danger"> *</span></label>
                                                        <select name="status" id="" class="form-control select2">
                                                            <option value="" disabled >Select One</option>
                                                            <option value="1" selected>Active</option>
                                                            <option class="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="row" id="">
                                                    <div class="col-md-6">
                                                        <label>Brand</label>
                                                        <select name="brand_id" class="form-control select2">
                                                            <option value="" disabled selected>Select One</option>
                                                            @foreach($brands as $brand)
                                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Units</label>
                                                        <select id="" name="unit_id" class="form-control select2">
                                                            <option value="">Select One</option>
                                                            @foreach($units as $key=>$unit)
                                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="row" id="showSelectedColor">
                                                    <div class="col-md-12">
                                                        <label>Color</label>
                                                        <select id="getColorId" class="form-control select2">
                                                            <option value="">Select One</option>
                                                            @foreach($colors as $key=>$color)
                                                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label>Alert Quantity</label>
                                                <input type="number" name="alert_quantity" class="form-control" value="5" min="0" placeholder="Alert Quantity">
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label>Max Order Qty</label>
                                                <input type="number" name="max_order" class="form-control" value="10" min="1" placeholder="Max Order Qty">
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
                                                        <textarea class="form-control summernote" style="height: 500px;" name="description" placeholder="Description"></textarea>
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
                                                <label class="w-100">
                                                    Outside Delivery

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_outside_delivery" name="show_outside_delivery" checked value="1">
                                                    </span>
                                                </label>
                                                <input type="text" name="outside_delivery" class="form-control" value="Home Delivery outside Dhaka 4 - 6 day(s)">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label class="w-100">
                                                    Inside Delivery

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_inside_delivery" name="show_inside_delivery" checked value="1">
                                                    </span>
                                                </label>
                                                <input type="text" name="inside_delivery" class="form-control" value="Home Delivery inside Dhaka 4 - 6 day(s)">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label id="payment_method_label" class="w-100">
                                                    Payment Method
                                                    <button type="button" class="btn btn-sm btn-info" onclick="addPayment()"><i class="fa fa-plus"></i></button>

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_payment_method" name="show_payment_method" checked value="1">
                                                    </span>
                                                </label>

                                                <input type="text" name="payment_method[]" class="form-control" placeholder="Payment Method">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label id="guarantee_policy_label" class="w-100">
                                                    Guarantee Policy
                                                    <button type="button" class="btn btn-sm btn-info" onclick="addGuarantee()"><i class="fa fa-plus"></i></button>

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_guarantee" name="show_guarantee" checked value="1">
                                                    </span>
                                                </label>
                                                <input type="text" name="guarantee_policy[]" class="form-control" placeholder="Guarantee Policy">
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <label id="warranty_policy_label" class="w-100">
                                                    Warranty Policy
                                                    <button type="button" class="btn btn-sm btn-info" onclick="addWarranty()"><i class="fa fa-plus"></i></button>

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_warranty" name="show_warranty" checked value="1">
                                                    </span>
                                                </label>
                                                <input type="text" name="warranty_policy[]" class="form-control" placeholder="Warranty Policy">
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <label id="product_service_label" class="w-100">
                                                    Service
                                                    <button type="button" class="btn btn-sm btn-info" onclick="addService()"><i class="fa fa-plus"></i></button>

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_product_service" name="show_product_service" checked value="1">
                                                    </span>
                                                </label>
                                                <input type="text" name="product_service[]" class="form-control" placeholder="Service">
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
                                                <textarea class="form-control" rows="3" name="schema" placeholder="Schema"></textarea>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label>Meta Keyword</label>
                                                <textarea class="form-control" rows="3" name="meta_keyword" placeholder="Meta Keyword"></textarea>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label >Meta Description</label>
                                                <textarea class="form-control" rows="3" name="meta_description" placeholder="Meta Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-upload"></i>
                                    Upload Product
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
        $('#regular_price').on('wheel keyup change', function(event) {
            var regular_price = $("#regular_price").val();
            var discount = $("#discount").val();

            var sell_price = regular_price - (regular_price*(discount/100));

            $("#sell_price").val(sell_price);
        });
        $('#discount').on('wheel keyup change', function(event) {
            var regular_price = $("#regular_price").val();
            var discount = $("#discount").val();

            var dis_price = regular_price*(discount/100);
            var sell_price = regular_price - (regular_price*(discount/100));

            $("#discount_tk").val(Math.ceil(dis_price));
            $("#sell_price").val(Math.ceil(sell_price));
        });
        $('#discount_tk').on('wheel keyup change', function(event) {
            var regular_price = $("#regular_price").val();
            var discount_tk = $("#discount_tk").val();

            var sell_price = regular_price - discount_tk;
            var discount = (discount_tk*100)/regular_price;

            $("#discount").val(Math.ceil(discount));
            $("#sell_price").val(sell_price);
        });
        $('#sell_price').on('wheel keyup change', function(event) {
            var regular_price = $("#regular_price").val();
            var sell_price = $("#sell_price").val();
            var discount_tk = $("#discount_tk").val();

            var diff = regular_price - sell_price;
            var discount = (diff/regular_price)*100;
            if (regular_price=='') {
                discount = 0;
                diff = 0;
                // regular_price = sell_price;
            }
            $("#discount").val(Math.ceil(discount));
            $("#discount_tk").val(diff);
            // $("#regular_price").val(regular_price);
        });

        function addPayment(){
            $( "#payment_method_label" ).after( '<input type="text" name="payment_method[]" class="form-control mb-2" placeholder="Another Payment Method">' );
        }

        function addGuarantee(){
            $( "#guarantee_policy_label" ).after( '<input type="text" name="guarantee_policy[]" class="form-control mb-2" placeholder="Another Guarantee Policy">' );
        }

        function addWarranty(){
            $( "#warranty_policy_label" ).after( '<input type="text" name="warranty_policy[]" class="form-control mb-2" placeholder="Another Warranty Policy">' );
        }

        function addService(){
            $( "#product_service_label" ).after( '<input type="text" name="product_service[]" class="form-control mb-2" placeholder="Another Service">' );
        }
    </script>
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
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result).width(50)
                            .height(50); //create image element
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
        $("#getColorId").on('change', function(){
            // alert('hell');
            var getColorId = $("#getColorId").val();
            // alert(getColorId);
            if($("#new_color_area_" + getColorId).length == 0){
                $.ajax({
                    type    : "POST",
                    url     : "{{ route('admin.color_id.ajax') }}",
                    data    : {
                            getColorId: getColorId,
                            _token: '{{csrf_token()}}',
                        },
                    success : function(data) {
                        console.log(data);
                        $(data).insertAfter('#showSelectedColor');
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

        $('#free_shipping_charge').on('change', function(){
            var free_shipping_charge = $('#free_shipping_charge').val();
            if(free_shipping_charge == '0'){
                $('#outside_shipping_charge').val(0);
                $('#inside_shipping_charge').val(0);

                $('#outside_shipping_charge').prop('readonly', true);
                $('#inside_shipping_charge').prop('readonly', true);
            }else{
                $('#outside_shipping_charge').prop('readonly', false);
                $('#inside_shipping_charge').prop('readonly', false);
            }
        });
    </script>
@endpush
