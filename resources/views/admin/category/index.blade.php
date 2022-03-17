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
                                        Category
                                    </button>
                                    @php
                                        $i = 0 ;
                                    @endphp
                                    <!-- crate modal  -->
                                    <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Category</h4>
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
                                                            <label class="col-md-3 text-right">Image</label>
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
                                                                <input type="number" class="form-control" name="serial_number" value="{{ $serial }}" placeholder="Serial Number">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 text-right"></label>
                                                            <div class="col-md-9 text-left">
                                                                <input type="checkbox" name="menu" value="1" id="menuChecked">
                                                                <label for="menuChecked">Menu</label>
                                                                <br>
                                                                <input type="checkbox" name="feature" value="1" id="featureChecked">
                                                                <label for="featureChecked">Feature</label>
                                                                <br>
                                                                <input type="checkbox" name="show_hide" value="1" checked id="showHideChecked">
                                                                <label for="showHideChecked" id="showHide">Show</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 text-right"></label>
                                                            <div class="col-md-9 text-left">
                                                                <input type="submit" class="btn btn-success" value="Create Category">
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
                                            <th class="text-center">SL No</th>
                                            <th>Name</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Menu</th>
                                            <th class="text-center">Feature</th>
                                            <th class="text-center">Show / Hide</th>
                                            <th class="text-center">Link</th>
                                            <th class="text-center">Parent Category</th>
                                            <th class="text-center">Active Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $key => $category)
                                            <tr>
                                                <td class="text-center">{{ $key+1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td class="text-center">
                                                    <img width="60" height="60" src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
                                                </td>
                                                <td class="text-center">
                                                    @if($category->menu == 1)
                                                        <span class="badge bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($category->feature == 1)
                                                        <span class="badge bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($category->show_hide == 1)
                                                        <span class="badge bg-success text-white">Show</span>
                                                    @else
                                                        <span class="badge bg-info text-white">Hide</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('category', $category->slug) }}" target="_blank">{{ route('category', $category->slug) }}</a>
                                                </td>
                                                <td class="text-center">
                                                    <a title="View Parent Cateogory" href="{{ route('admin.view-parent-category', $category->slug) }}" class="btn btn-success">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    @if($category->status == 1)
                                                        <a title="Inactive Now" href="{{ route('admin.category.inactive', $category->id) }}" class="btn btn-success">
                                                            Active
                                                        </a>
                                                    @else
                                                        <a title="Active Now" href="{{ route('admin.category.active', $category->id) }}" class="btn btn-danger">
                                                            Inactive
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal-edit{{$key}}">
                                                        <i class="ml-1 fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteData({{ $category->id }})">
                                                        <i class="ml-1 fa fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $category->id }}" action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
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
                                                                        <label class="col-md-3 text-right">Image</label>
                                                                        <div class="col-md-9">
                                                                            <input type="file" onChange="mainThamEdit(this)" name="image" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right"></label>
                                                                        <div class="col-md-9">
                                                                            <img width="100" height="100" class="showThamEdit" src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif">
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
                                                                            <label for="menuChecked">Menu</label>
                                                                            <br>
                                                                            <input type="checkbox" name="feature" value="1" @if($category->feature == 1) checked @endif id="featureChecked">
                                                                            <label for="featureChecked">Feature</label>
                                                                            <br>
                                                                            <input type="checkbox" class="editShowHide" name="show_hide" value="1" @if($category->show_hide == 1) checked @endif id="editshowHideChecked">
                                                                            <label for="editshowHideChecked" class="showHide">Show</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right"></label>
                                                                        <div class="col-md-9 text-left">
                                                                            <input type="submit" class="btn btn-success" value="Update Category">
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
        $("#showHideChecked").on('click', function() {
             // access properties using this keyword
            if($(this).prop("checked") == true){
                $("#showHide").text("Show");
            }
            else if($(this).prop("checked") == false){
                $("#showHide").text("Hide");
            }
        });

        $(".editShowHide").click(function(){
            if($(this).prop("checked") == true){
                $(".showHide").text("Show");
            }
            else if($(this).prop("checked") == false){
                $(".showHide").text("Hide");
            }
        });
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
@endpush
