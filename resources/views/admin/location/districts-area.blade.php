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
                            <h2>{{ $title }} <small class="badge bg-success text-white">{{ $areas->count() }}</small></h2>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">SL No</th>
                                            <th>Name</th>
                                            {{-- <th>Position</th> --}}
                                            <th width="15%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($areas as $key => $area)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $area->name }}</td>
                                                {{-- <td>
                                                    @if ($area->is_inside == 0)
                                                        Outside Dhaka
                                                    @else
                                                        Inside Dhaka
                                                    @endif
                                                </td> --}}
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal-edit{{$key}}">
                                                        <i class="ml-1 fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteData({{ $area->id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $area->id }}" action="{{ route('admin.area.destroy', $area->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                                <div class="modal fade" id="large-Modal-edit{{$key}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Area</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.area.update', $area->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label class="text-right">area Name</label>
                                                                        <input type="text" class="form-control" name="name" value="{{$area->name}}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="text-right">Position</label>
                                                                        <select name="is_inside" class="form-control">
                                                                            <option value="0" @if($area->is_inside == '0') selected @endif>Outside Dhakha</option>
                                                                            <option value="1" @if($area->is_inside == '1') selected @endif>Inside Dhakha</option>
                                                                        </select>
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
                            <h2>New Area</h2>
                        </div>
                        <div class="card-block">
                            <form action="{{route('admin.area.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="district_id" value="{{ $district->id }}">

                                <div class="form-group">
                                    <label class="text-right">Area Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Area Name">
                                </div>

                                <div class="form-group">
                                    <label class="text-right">Position</label>
                                    <select name="is_inside" class="form-control">
                                        <option value="0" selected>Outside Dhakha</option>
                                        <option value="1">Inside Dhakha</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Create Area</button>
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
