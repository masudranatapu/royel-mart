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
                                    <h2>Charge Decrease Variant</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#large-Modal">
                                        <i class="fa fa-plus"></i>
                                        New Charge
                                    </button>
                                    <!-- crate modal  -->
                                    <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Charge Decrease Variant</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.category-shipping-charge.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="pull-left">Category *</label>
                                                            <select name="category_id" id="category" class="form-control select2" required>
                                                                <option value="">Select One</option>
                                                                @foreach($categories as $category)
                                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group" id="sub_cate_display" style="display:none;">
                                                            <label class="pull-left">Parent Category</label>
                                                            <select name="parent_id" id="subcategory" class="form-control select2">

                                                            </select>
                                                        </div>
                                                        <div class="form-group" id="sub_sub_cate_display" style="display:none;">
                                                            <label class="pull-left">Child Category</label>
                                                            <select name="child_id" id="subsubcategory" class="form-control select2">

                                                            </select>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label class="pull-left">Qty One (%)</label>
                                                                <input type="number" class="form-control" name="qty_one_charge_variant" value="0" min="0">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="pull-left">Qty Two (%)</label>
                                                                <input type="number" class="form-control" name="qty_two_charge_variant" value="0" min="0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label class="pull-left">Qty Three (%)</label>
                                                                <input type="number" class="form-control" name="qty_three_charge_variant" value="0" min="0">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="pull-left">Qty Four (%)</label>
                                                                <input type="number" class="form-control" name="qty_four_charge_variant" value="0" min="0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label class="pull-left">Qty Five (%)</label>
                                                                <input type="number" class="form-control" name="qty_five_charge_variant" value="0" min="0">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="pull-left">Qty More Than Five (%)</label>
                                                                <input type="number" class="form-control" name="qty_more_than_five_charge_variant" value="0" min="0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="submit" class="btn btn-success pull-left" value="Submit">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">SL No</th>
                                            <th class="">Category</th>
                                            <th class="">Qty One (%)</th>
                                            <th class="">Qty Two (%)</th>
                                            <th class="">Qty Three (%)</th>
                                            <th class="">Qty Four (%)</th>
                                            <th class="">Qty Five (%)</th>
                                            <th class="">Qty More Than Five (%)</th>
                                            <th width="8%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($category_crgs as $key => $category_crg)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $category_crg->category->name }}</td>
                                                <td>{{ $category_crg->qty_one_charge_variant }}</td>
                                                <td>{{ $category_crg->qty_two_charge_variant }}</td>
                                                <td>{{ $category_crg->qty_three_charge_variant }}</td>
                                                <td>{{ $category_crg->qty_four_charge_variant }}</td>
                                                <td>{{ $category_crg->qty_five_charge_variant }}</td>
                                                <td>{{ $category_crg->qty_more_than_five_charge_variant }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal-edit{{$key}}">
                                                        <i class="ml-1 fa fa-edit"></i>
                                                    </button>
                                                </td>
                                                <div class="modal fade" id="large-Modal-edit{{$key}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Update Charge</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.category-shipping-charge.update', $category_crg->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label class="pull-left">Category</label>
                                                                        <input type="text" class="form-control" readonly value="{{ $category_crg->category->name }}">
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-md-6">
                                                                            <label class="pull-left">Qty One (%)</label>
                                                                            <input type="number" class="form-control" name="qty_one_charge_variant" value="{{ $category_crg->qty_one_charge_variant }}" min="0">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="pull-left">Qty Two (%)</label>
                                                                            <input type="number" class="form-control" name="qty_two_charge_variant" value="{{ $category_crg->qty_two_charge_variant }}" min="0">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-md-6">
                                                                            <label class="pull-left">Qty Three (%)</label>
                                                                            <input type="number" class="form-control" name="qty_three_charge_variant" value="{{ $category_crg->qty_three_charge_variant }}" min="0">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="pull-left">Qty Four (%)</label>
                                                                            <input type="number" class="form-control" name="qty_four_charge_variant" value="{{ $category_crg->qty_four_charge_variant }}" min="0">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-md-6">
                                                                            <label class="pull-left">Qty Five (%)</label>
                                                                            <input type="number" class="form-control" name="qty_five_charge_variant" value="{{ $category_crg->qty_five_charge_variant }}" min="0">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="pull-left">Qty More Than Five (%)</label>
                                                                            <input type="number" class="form-control" name="qty_more_than_five_charge_variant" value="{{ $category_crg->qty_more_than_five_charge_variant }}" min="0">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input type="submit" class="btn btn-success pull-left" value="Update">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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

        // $('.select2').select2();

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
