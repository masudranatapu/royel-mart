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
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Divisions <small class="badge bg-success text-white">{{ $divisions->count() }}</small></h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">SL No</th>
                                            <th>Name</th>
                                            <th width="15%" class="text-center">Districts</th>
                                            <th width="15%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($divisions as $key => $division)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $division->name }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.divisions-districts', $division->id) }}" class="btn btn-success">
                                                        <i class="ml-1 fa fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal-edit{{$key}}">
                                                        <i class="ml-1 fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteData({{ $division->id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $division->id }}" action="{{ route('admin.division.destroy', $division->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                                <div class="modal fade" id="large-Modal-edit{{$key}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Division</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.division.update', $division->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label class="text-right">Division</label>
                                                                        <input type="text" class="form-control" name="name" value="{{ $division->name }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-success">Update Division</button>
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
                            <h2>New Division</h2>
                        </div>
                        <div class="card-block">
                            <form action="{{route('admin.division.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="text-right">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Divisions Name">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success text-right">Create Division</button>
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
    </script>
@endpush
