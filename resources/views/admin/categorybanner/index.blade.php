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
                                    <h2>Category Banner <small class="badge bg-success text-white">{{ $categorybanners->count() }}</small></h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#large-Modal">
                                        <i class="fa fa-plus"></i>
                                        Add Category Banner
                                    </button>
                                    <!-- crate modal  -->
                                    <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Category Banner</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.category-banner.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label class="col-md-3">
                                                                <label>Category <span class="text-danger"> * </span></label>
                                                            </label>
                                                            <div class="col-md-9">
                                                                <select name="category_id" id="category" class="form-control">
                                                                    <option value="">Select One</option>
                                                                    @foreach($categories as $category)
                                                                        @if($category->id == 1)

                                                                        @else
                                                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" id="sub_cate_display" style="display:none;">
                                                            <label class="col-md-3">
                                                                <label>Parent Category</label>
                                                            </label>
                                                            <div class="col-md-9">
                                                                <select name="parent_id" id="subcategory" class="form-control">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" id="sub_sub_cate_display" style="display:none;">
                                                            <label class="col-md-3">
                                                                <label>Child Category</label>
                                                            </label>
                                                            <div class="col-md-9">
                                                                <select name="child_id" id="subsubcategory" class="form-control">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 text-right">Link</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="link" value="#" placeholder="link">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3">Image</label>
                                                            <div class="col-md-9">
                                                                <input type="file" onChange="mainTham(this)" name="image" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3"></label>
                                                            <div class="col-md-9 text-left">
                                                                <img width="100" height="100" src="{{ asset('demomedia/demo.png') }}" id="showTham">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3"></label>
                                                            <div class="col-md-9 text-left">
                                                                <input type="submit" class="btn btn-success" value="Create Category Banner">
                                                            </div>
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
                            <div class="table-responsive dt-responsive">
                                <table id="row-callback"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">SL No</th>
                                            <th width="15%" class="text-center">Image</th>
                                            <th class="">Category</th>
                                            <th class="">Link</th>
                                            <th width="15%" class="text-center">Status</th>
                                            <th width="8%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categorybanners as $key => $categorybanner)
                                            <tr>
                                                <td class="text-center">{{  $key + 1 }}</td>
                                                <td class="text-center">
                                                    <img wodth="60" height="60" src="{{ asset($categorybanner->image) }}">
                                                </td>
                                                <td class="">
                                                    {{ $categorybanner->category->name }}
                                                </td>
                                                <td class="">
                                                    {{ $categorybanner->link }}
                                                </td>
                                                <td class="text-center">
                                                    @if($categorybanner->status == 1)
                                                        <a title="Inactive Now" href="{{ route('admin.categorybanner.inactive', $categorybanner->id) }}" class="btn btn-success">
                                                            Active
                                                        </a>
                                                    @else
                                                        <a title="Active Now" href="{{ route('admin.categorybanner.active', $categorybanner->id) }}" class="btn btn-danger">
                                                            Inactive
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal-edit{{$key}}">
                                                        <i class="ml-1 fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteData({{ $categorybanner->id }})">
                                                        <i class="ml-1 fa fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $categorybanner->id }}" action="{{ route('admin.category-banner.destroy', $categorybanner->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                                <div class="modal fade" id="large-Modal-edit{{$key}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit client</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.category-banner.update', $categorybanner->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right">Category</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control" readonly value="{{ $categorybanner->category->name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right">Link</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control" name="link" value="{{ $categorybanner->link }}" placeholder="link">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right">Image</label>
                                                                        <div class="col-md-9">
                                                                            <input type="file" onChange="mainThamEdit(this)" name="image" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right"></label>
                                                                        <div class="col-md-9 text-left">
                                                                            <img width="100" height="100" class="showThamEdit" src="{{ asset($categorybanner->image) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right"></label>
                                                                        <div class="col-md-9 text-left">
                                                                            <input type="submit" class="btn btn-success" value="Update Category Banner">
                                                                        </div>
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
