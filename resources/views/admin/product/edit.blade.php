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
                                                <label>Product Name ( Eng )</label>
                                                <input type="text"  class="form-control" name="name_en" value="{{ $products->name_en }}" placeholder="Product Name ( Eng )">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Regular Price</label>
                                                                <input name="regular_price" type="number" class="form-control" id="regular_price" value="{{ $products->regular_price }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Sell Price <span class="text-danger"> * </span></label>
                                                                <input name="sale_price" readonly  type="number" class="form-control" id="sell_price" placeholder="Only number" value="{{ $products->sale_price }}">
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
                                                                    <input class="form-control" id="discount_tk" type="number" pattern="[0-9]*\.?[0-9]*" title="Numbers only and dot" name="discount_tk" value="{{ $products->discount_tk }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Discount Per</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">%</span>
                                                                    </div>
                                                                    <input class="form-control" id="discount" type="number" pattern="[0-9]*\.?[0-9]*" title="Numbers only and dot" name="discount" value="{{ $products->discount }}">
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
                                                        <input type="hidden" id="db_inside_shipping_charge" class="form-control" value="{{ $products->inside_shipping_charge }}">
                                                        <input type="number" @if($products->free_shipping_charge == '0') readonly @endif name="inside_shipping_charge" id="inside_shipping_charge" class="form-control" value="{{ $products->inside_shipping_charge }}" min="0" placeholder="Shipping Charge">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Outside Shipping</label>
                                                        <input type="hidden" id="db_outside_shipping_charge" class="form-control" value="{{ $products->outside_shipping_charge }}">
                                                        <input type="number" @if($products->free_shipping_charge == '0') readonly @endif name="outside_shipping_charge" id="outside_shipping_charge" class="form-control" value="{{ $products->outside_shipping_charge }}" min="0" placeholder="Shipping Charge">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Shipping Type</label>
                                                        <select class="form-control" name="free_shipping_charge" id="free_shipping_charge">
                                                            <option value="1" @if($products->free_shipping_charge == '1') selected @endif>Paid</option>
                                                            <option value="0" @if($products->free_shipping_charge == '0') selected @endif>Free</option>
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
                                                        <img width="50" height="50" src="{{ asset($products->thumbnail) }}" id="showTham">
                                                    </div>
                                                    <div class="col-md-6" id="newmultiproduct_display" style="display: none;">
                                                        <div class="row" id="preview_image"></div>
                                                    </div>
                                                    <div class="col-md-6" id="oldmultiproduct_display">
                                                        <div class="row">
                                                            @if($products->more_image)
                                                                @php
                                                                    $multiproduct = explode('|', $products->more_image)
                                                                @endphp
                                                                @foreach($multiproduct as $key => $mulipro)
                                                                    <img loading="eager|lazy" src="{{ asset($mulipro) }}" width="50" height="50">
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
                                                <label>Category <span class="text-danger"> * </span></label>
                                                <select name="category_id" id="category" class="form-control select2">
                                                    <option value="">Select One</option>
                                                    @foreach($categories as $category)
                                                        <option @if($category->id == $main_cat) selected @endif value="{{$category->id}}" value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6" id="sub_cate_display">
                                                        <label>Parent Category</label>
                                                        <select name="parent_id" id="subcategory" class="form-control select2">
                                                            <option value="">Select One</option>
                                                            @foreach($subcategory as $subcate)
                                                                <option @if($subcate->id == $parent_cat) selected @endif value="{{ $subcate->id }}">{{ $subcate->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6" id="sub_sub_cate_display">
                                                        <label>Child Category</label>
                                                        <select name="child_id" id="subsubcategory" class="form-control select2">
                                                            <option value="" selected >Select One</option>
                                                            @foreach($subsubcategory as $subsubcate)
                                                                <option @if($subsubcate->id == $child_cat) selected @endif value="{{ $subsubcate->id }}">{{ $subsubcate->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <label>Product Type <span class="text-danger"> *</span></label>
                                                        <select name="product_type" class="form-control select2">
                                                            <option value="" disabled>Select One</option>
                                                            <option @if($products->product_type == 'New Arrival') selected @endif value="New Arrival" selected>New Arrival</option>
                                                            <option @if($products->product_type == 'Features') selected @endif value="Features">Features</option>
                                                            <option @if($products->product_type == 'Best Selling') selected @endif value="Best Selling">Best Selling</option>
                                                            <option @if($products->product_type == 'Hot Collections') selected @endif value="Hot Collections">Hot Collections</option>
                                                            <option @if($products->product_type == 'Trending') selected @endif value="Trending">Trending</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Status<span class="text-danger"> *</span></label>
                                                        <select name="status" id="" class="form-control select2">
                                                            <option value="" disabled >Select One</option>
                                                            <option @if($products->status == 1) selected @endif value="1" selected>Active</option>
                                                            <option @if($products->status == 0) selected @endif class="0">Inactive</option>
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
                                                                <option @if($brand->id == $products->brand_id) selected @endif value="{{$brand->id}}" value="{{$brand->id}}">{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Units</label>
                                                        <select id="" name="unit_id" class="form-control select2">
                                                            <option value="">Select One</option>
                                                            @foreach($units as $key=>$unit)
                                                                <option value="{{ $unit->id }}" @if($unit->id == $products->unit_id) selected @endif>{{ $unit->name }}</option>
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
                                                @foreach($productColors as $productColor)
                                                    @php
                                                        $productSizes = App\Models\ProductSize::where('product_id', $products->id)->where('color_id', $productColor->color_id)->latest()->get();
                                                    @endphp
                                                    <div class="row mt-3" id="new_color_area_{{$productColor->color_id}}">
                                                        <div class="col-md-3">
                                                            @php
                                                                $color = App\Models\Color::where('id', $productColor->color_id)->first();
                                                            @endphp
                                                            <input type="hidden" class="form-control" name="color_id[]" value="{{$productColor->color_id}}">
                                                            <label>Color Name</label>
                                                            <input type="text" class="form-control" readonly value="{{ $color->name }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Image</label>
                                                            <input type="file" class="form-control" name="image_{{$productColor->color_id}}" id="image_{{ $productColor->color_id }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Size</label>
                                                            <select name="size_id_{{ $productColor->color_id }}[]" class="form-control" multiple="multiple" data-placeholder="Select Sub Unit">
                                                                @foreach($sizes as $size)
                                                                    <option value="{{ $size->id }}"
                                                                        @foreach ($productSizes as $key=>$productSize)
                                                                            @if ($size->id == $productSize->size_id)
                                                                                selected
                                                                            @endif
                                                                        @endforeach
                                                                    >{{ $size->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Action</label><br>
                                                            <button type="button" class="btn btn-danger" id="{{ $productColor->color_id }}" onclick="removeNewColorAre(this)">
                                                                <i class="ml-1 fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label>Alert Quantity</label>
                                                <input type="number" name="alert_quantity" class="form-control" value="{{ $products->alert_quantity }}" min="0" placeholder="Alert Quantity">
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label>Max Order Qty</label>
                                                <input type="number" name="max_order" class="form-control" value="{{ $products->max_order }}" min="1" placeholder="Max Order Qty">
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
                                                <label class="w-100">
                                                    Outside Delivery

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_outside_delivery" name="show_outside_delivery" @if($products->show_outside_delivery == '1') checked @endif value="1">
                                                    </span>
                                                </label>
                                                <input type="text" name="outside_delivery" class="form-control" value="{{ $products->outside_delivery }}">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label class="w-100">
                                                    Inside Delivery

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_inside_delivery" name="show_inside_delivery" @if($products->show_inside_delivery == '1') checked @endif value="1">
                                                    </span>
                                                </label>
                                                <input type="text" name="inside_delivery" class="form-control" value="{{ $products->inside_delivery }}">
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <label id="payment_method_label" class="w-100">
                                                    Payment Method
                                                    <button type="button" class="btn btn-sm btn-info" onclick="addPayment()"><i class="fa fa-plus"></i></button>

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_payment_method" name="show_payment_method" @if($products->show_payment_method == '1') checked @endif value="1">
                                                    </span>
                                                </label>
                                                @php
                                                    $payment_method = explode("|",$products->cash_delivery);
                                                @endphp
                                                @foreach($payment_method as $key=>$payment_method)
                                                    <input type="text" name="payment_method[]" class="form-control mb-2" value="{{ $payment_method }}" placeholder="Payment Method">
                                                @endforeach
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label id="guarantee_policy_label" class="w-100">
                                                    Guarantee Policy
                                                    <button type="button" class="btn btn-sm btn-info" onclick="addGuarantee()"><i class="fa fa-plus"></i></button>

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_guarantee" name="show_guarantee" @if($products->show_guarantee == '1') checked @endif value="1">
                                                    </span>
                                                </label>

                                                @php
                                                    $guarantee_policy = explode("|",$products->guarantee_policy);
                                                @endphp
                                                @foreach($guarantee_policy as $key=>$guarantee_policy)
                                                    <input type="text" name="guarantee_policy[]" class="form-control mb-2" value="{{ $guarantee_policy }}" placeholder="Guarantee Policy">
                                                @endforeach
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <label id="warranty_policy_label" class="w-100">
                                                    Warranty Policy
                                                    <button type="button" class="btn btn-sm btn-info" onclick="addWarranty()"><i class="fa fa-plus"></i></button>

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_warranty" name="show_warranty" @if($products->show_warranty == '1') checked @endif value="1">
                                                    </span>
                                                </label>

                                                @php
                                                    $warranty_policy = explode("|",$products->warranty_policy);
                                                @endphp
                                                @foreach($warranty_policy as $key=>$warranty_policy)
                                                    <input type="text" name="warranty_policy[]" class="form-control mb-2" value="{{ $warranty_policy }}" placeholder="Warranty Policy">
                                                @endforeach
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <label id="product_service_label" class="w-100">
                                                    Service
                                                    <button type="button" class="btn btn-sm btn-info" onclick="addService()"><i class="fa fa-plus"></i></button>

                                                    <span class="pull-right">
                                                        <span>Show</span>
                                                        <input type="checkbox" id="show_product_service" name="show_product_service" @if($products->show_product_service == '1') checked @endif value="1">
                                                    </span>
                                                </label>

                                                @php
                                                    $product_service = explode("|",$products->product_service);
                                                @endphp
                                                @foreach($product_service as $key=>$product_service)
                                                    <input type="text" name="product_service[]" class="form-control mb-2" value="{{ $product_service }}" placeholder="Service">
                                                @endforeach
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
                $('#outside_shipping_charge').val($('#db_outside_shipping_charge').val());
                $('#inside_shipping_charge').val($('#db_inside_shipping_charge').val());

                $('#outside_shipping_charge').prop('readonly', false);
                $('#inside_shipping_charge').prop('readonly', false);
            }
        });
    </script>
@endpush
