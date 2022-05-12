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
                <div class="page-body row">
                    <div class="card col-md-8">
                        <div class="card-header">
                            <h2>{{ $title }} <small class="badge bg-success text-white">{{ $districts->count() }}</small></h2>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">SL No</th>
                                            <th>Name</th>
                                            <th width="15%">Areas</th>
                                            <th width="15%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($districts as $key => $district)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $district->name }}</td>
                                                <td>
                                                    <a href="{{ route('admin.districts-areas', $district->id) }}" class="btn btn-success">
                                                        <i class="ml-1 fa fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal-edit{{$key}}">
                                                        <i class="ml-1 fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteData({{ $district->id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $district->id }}" action="{{ route('admin.district.destroy', $district->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                                <div class="modal fade" id="large-Modal-edit{{$key}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit District</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.district.update', $district->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label class="text-right">District Name</label>
                                                                        <input type="text" class="form-control" name="name" value="{{$district->name}}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-success">Update</button>
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

                    <div class="card col-md-4">
                        <div class="card-header">
                            <h2>New District</h2>
                        </div>
                        <div class="card-block">
                            <form action="{{route('admin.district.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="division_id" value="{{ $division->id }}">
                                <div class="form-group">
                                    <label class="text-right">District Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="District Name">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Create District</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
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
                        'Your data is safe :-)',
                        'error'
                    )
                }
            })
        }

        $('.select2').select2();
    </script>
@endpush
