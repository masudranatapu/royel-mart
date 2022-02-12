@extends('layouts.backend.app')

@section('title')
    {{$title}}
@stop

@push('css')
    <style>
        .category-image {
            width: 100px;
            height:100px;
            float: left;
        }
        .category-image-size {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style>
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
                                    <h4>Child {{ $title }}</h4>
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
                                            Child {{$title}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Child Category <small class="badge bg-success text-white">{{ $categories->count() }}</small></h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#large-Modal">
                                        <i class="fa fa-plus"></i>
                                        Add Child Category
                                    </button>
                                    <!-- crate modal  -->
                                    <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Create Category</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.child-category.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label">Main Category</label>
                                                            <div class="col-md-9">
                                                                <select name="category_id" id="chategoryId" class="form-control">
                                                                    <option value="" disabled selected>Select One</option>
                                                                    @foreach($categories as $category)
                                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" id="showParent" style="display:none;">
                                                            <label class="col-md-3 col-form-label">Parent Category</label>
                                                            <div class="col-md-9">
                                                                <select name="subcategory_id" id="subcategoryId" class="form-control">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label">Name</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="name" placeholder="Name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label">Imge</label>
                                                            <div class="col-md-9">
                                                                <input type="file" onChange="mainTham(this)" name="image" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label"></label>
                                                            <div class="col-md-9">
                                                                <img class="category-image" src="" id="showTham">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label">Icon <small>Fontawesome Icon</small></label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="icon" placeholder="fa fa-icon-name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label">Serial Number</label>
                                                            <div class="col-md-9">
                                                                <input type="number" class="form-control" name="serial_number" placeholder="Serial Number">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label"></label>
                                                            <div class="col-md-9 text-left">
                                                                <input type="checkbox" name="menu" value="1" id="menuChecked">
                                                                <label for="menuChecked">Menu Status</label>
                                                                <br>
                                                                <input type="checkbox" name="feature" value="1" id="featureChecked">
                                                                <label for="featureChecked">Feature Status</label>
                                                                <br>
                                                                <input type="checkbox" name="show_hide_status" value="1" id="showHideStatusChecked">
                                                                <label for="showHideStatusChecked">Show Hide Status</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label"></label>
                                                            <div class="col-md-9 text-left">
                                                                <input type="submit" class="btn btn-success" value="Create Clild Category">
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
                                            <th width="2%">SL No</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Main Category</th>
                                            <th>Parent Category</th>
                                            <th>Icon</th>
                                            <th>Menu</th>
                                            <th>Feature</th>
                                            <th>Show Hide Status</th>
                                            <th>Active Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subsubcategories as $key => $subsubcategory)
                                            <tr>
                                                <td>{{ $subsubcategory->serial_number }}</td>
                                                <td>{{ $subsubcategory->name }}</td>
                                                <td>
                                                    <img class="category-image-size" src="{{ asset($subsubcategory->image) }}" alt="">
                                                </td>
                                                <td>{{ $subsubcategory['category']['name'] }}</td>
                                                <td>{{ $subsubcategory['subcategory']['name'] }}</td>
                                                <td class="text-center">
                                                    <i class="{{ $subsubcategory->icon }}"></i>
                                                </td>
                                                <td>
                                                    @if($subsubcategory->menu == 1)
                                                        <span class="badge bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($subsubcategory->feature == 1)
                                                        <span class="badge bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($subsubcategory->show_hide_status == 1)
                                                        <span class="badge bg-success text-white">Show</span>
                                                    @else
                                                        <span class="badge bg-info text-white">Hide</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($subsubcategory->status == 1)
                                                        <span class="badge bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($subsubcategory->status == 1)
                                                        <a title="Inactive Brand" href="{{ route('admin.subsubcategory.inactive', $subsubcategory->id) }}" class="btn btn-danger">
                                                            <i class="ml-1 fa fa-angle-down"></i>
                                                        </a>
                                                    @else
                                                        <a title="Active Brand" href="{{ route('admin.subsubcategory.active', $subsubcategory->id) }}" class="btn btn-success">
                                                            <i class="ml-1 fa fa-angle-up"></i>
                                                        </a>
                                                    @endif
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal-edit{{$key}}">
                                                        <i class="ml-1 fa fa-edit"></i>
                                                    </button>
                                                </td>
                                                <div class="modal fade" id="large-Modal-edit{{$key}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Category</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.child-category.update', $subsubcategory->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label">Main Category</label>
                                                                        <div class="col-md-9">
                                                                            <select name="category_id" id="chategoryId_{{ $subsubcategory->id }}" onChange="eidtCategoryID('{{ $subsubcategory->id }}')" class="form-control">
                                                                                <option value="" disabled selected>Select One</option>
                                                                                @foreach($categories as $category)
                                                                                    <option @if($category->id == $subsubcategory->category_id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label">Parent Category</label>
                                                                        <div class="col-md-9">
                                                                            <select name="subcategory_id" id="subcategoryId_{{ $subsubcategory->id }}" class="form-control">
                                                                                @foreach($subcategories as $subcategory)
                                                                                    <option @if($subcategory->id == $subsubcategory->subcategory_id) selected @endif value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label">Name</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control" name="name" value="{{ $subsubcategory->name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label">Imge</label>
                                                                        <div class="col-md-9">
                                                                            <input type="file" onChange="mainThamEdit(this)" name="image" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label"></label>
                                                                        <div class="col-md-9">
                                                                            <img class="category-image showThamEdit" src="{{ asset($subsubcategory->image) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label">Icon <small>Fontawesome icon</small></label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control" name="icon" value="{{ $subsubcategory->icon }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label">Serial Number</label>
                                                                        <div class="col-md-9">
                                                                            <input type="number" class="form-control" name="serial_number" value="{{ $subsubcategory->serial_number }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label"></label>
                                                                        <div class="col-md-9 text-left">
                                                                            <input type="checkbox" name="menu" value="1" @if($subsubcategory->menu == 1) checked @endif id="menuChecked">
                                                                            <label for="menuChecked">Menu Status</label>
                                                                            <br>
                                                                            <input type="checkbox" name="feature" value="1" @if($subsubcategory->feature == 1) checked @endif id="featureChecked">
                                                                            <label for="featureChecked">Feature Status</label>
                                                                            <br>
                                                                            <input type="checkbox" name="show_hide_status" value="1" @if($subsubcategory->show_hide_status == 1) checked @endif id="showHideStatusChecked">
                                                                            <label for="showHideStatusChecked">Show Hide Status</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label"></label>
                                                                        <div class="col-md-9 text-left">
                                                                            <input type="submit" class="btn btn-success" value="Update Clild Category">
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
                                    <tfoot>
                                        <tr>
                                            <th width="2%">SL No</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Main Category</th>
                                            <th>Parent Category</th>
                                            <th>Icon</th>
                                            <th>Menu</th>
                                            <th>Feature</th>
                                            <th>Show Hide Status</th>
                                            <th>Active Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
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
        $("#chategoryId").on('change', function(event) {
            var category_id = $("#chategoryId").val();
            // alert(category_id);
            if(category_id){
                $.ajax({
                    type    : "POST",
                    url     : "{{ route('admin.category.ajax') }}",
                    data    : {
                            category_id: category_id,
                            _token: '{{csrf_token()}}',
                        },
                    success : function(data) {
                        console.log(data);
                        $("#showParent").show();
                        var d =$('#subcategoryId').empty();
                        $('#subcategoryId').append('<option value="" disabled selected> Select One </option>');
                        $.each(data, function(key, value){
                            $('#subcategoryId').append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });
                    },
                });
            }else {
                alert('Select your main category');
            }
        });
        function eidtCategoryID(id) {
            var category_id = $("#chategoryId_" + id).val();
            // alert(category_id);
            if(category_id){
                $.ajax({
                    type    : "POST",
                    url     : "{{ route('admin.category.ajax') }}",
                    data    : {
                            category_id: category_id,
                            _token: '{{csrf_token()}}',
                        },
                    success : function(data) {
                        console.log(data);
                        var d =$('#subcategoryId_' + id).empty();
                        $('#subcategoryId_' + id).append('<option value="" disabled selected> Select One </option>');
                        $.each(data, function(key, value){
                            $('#subcategoryId_' + id).append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });
                    },
                });
            }else {
                alert('Select your main category');
            }
        };
    </script>
@endpush