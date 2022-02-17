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
                                    <h2>Category <small class="badge bg-success text-white">{{ $categories->count() }}</small></h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#large-Modal">
                                        <i class="fa fa-plus"></i>
                                        Add Category
                                    </button>
                                    @php
                                        $i = 1
                                    @endphp
                                    <!-- crate modal  -->
                                    <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Add Category</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label class="col-md-3 text-right">Name</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="name" placeholder="Name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 text-right">Imge</label>
                                                            <div class="col-md-9">
                                                                <input type="file" onChange="mainTham(this)" name="image" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 text-right"></label>
                                                            <div class="col-md-9 text-left">
                                                                <img width="100" height="100" src="{{ asset('demomedia/demo.png') }}" id="showTham">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 text-right mt-1">SL No</label>
                                                            <div class="col-md-9">
                                                                <input type="number" class="form-control" name="serial_number" value="{{ $categories->count() + $i }}" placeholder="Serial Number">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 text-right"></label>
                                                            <div class="col-md-9 text-left">
                                                                <input type="checkbox" name="menu" value="1" id="menuChecked">
                                                                <label for="menuChecked">Menu Status</label>
                                                                <br>
                                                                <input type="checkbox" name="feature" value="1" id="featureChecked">
                                                                <label for="featureChecked">Feature Status</label>
                                                                <br>
                                                                <input type="checkbox" name="show_hide" value="1" id="showHideChecked">
                                                                <label for="showHideChecked" id="showHide">Show Status</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 text-right"></label>
                                                            <div class="col-md-9 text-left">
                                                                <input type="submit" class="btn btn-success" value="Add category">
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
                                            <th>SL No</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Icon</th>
                                            <th>Menu</th>
                                            <th>Feature</th>
                                            <th>Show / Hide</th>
                                            <th>Parent Category</th>
                                            <th>Active Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $key => $category)
                                            <tr>
                                                <td>{{ $category->serial_number }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    <img width="60" height="60" src="{{ asset($category->image) }}" alt="">
                                                </td>
                                                <td class="text-center">
                                                    <i class="{{ $category->icon }}"></i>
                                                </td>
                                                <td>
                                                    @if($category->menu == 1)
                                                        <span class="badge bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($category->feature == 1)
                                                        <span class="badge bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($category->show_hide_status == 1)
                                                        <span class="badge bg-success text-white">Show</span>
                                                    @else
                                                        <span class="badge bg-info text-white">Hide</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($category->status == 1)
                                                        <span class="badge bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($category->status == 1)
                                                        <a title="Inactive Brand" href="{{ route('admin.category.inactive', $category->id) }}" class="btn btn-danger">
                                                            <i class="ml-1 fa fa-angle-down"></i>
                                                        </a>
                                                    @else
                                                        <a title="Active Brand" href="{{ route('admin.category.active', $category->id) }}" class="btn btn-success">
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
                                                                <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right">Name</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right">Imge</label>
                                                                        <div class="col-md-9">
                                                                            <input type="file" onChange="mainThamEdit(this)" name="image" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right"></label>
                                                                        <div class="col-md-9">
                                                                            <img width="100" height="100" class="showThamEdit" src="{{ asset($category->image) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right mt-1">SL No</label>
                                                                        <div class="col-md-9">
                                                                            <input type="number" class="form-control" name="serial_number" value="{{ $category->serial_number }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right"></label>
                                                                        <div class="col-md-9 text-left">
                                                                            <input type="checkbox" name="menu" value="1" @if($category->menu == 1) checked @endif id="menuChecked">
                                                                            <label for="menuChecked">Menu Status</label>
                                                                            <br>
                                                                            <input type="checkbox" name="feature" value="1" @if($category->feature == 1) checked @endif id="featureChecked">
                                                                            <label for="featureChecked">Feature Status</label>
                                                                            <br>
                                                                            <input type="checkbox" name="show_hide_status" value="1" @if($category->show_hide_status == 1) checked @endif id="showHideChecked">
                                                                            <label for="showHideChecked">Show Status</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right"></label>
                                                                        <div class="col-md-9 text-left">
                                                                            <input type="submit" class="btn btn-success" value="Update main category">
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
@endpush