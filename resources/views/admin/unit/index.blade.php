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
                                    <h2>Unit <small class="badge bg-success text-white">{{ $units->count() }}</small></h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#large-Modal">
                                        <i class="fa fa-plus"></i>
                                        Add Unit
                                    </button>
                                    <!-- crate modal  -->
                                    <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Unit</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.unit.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label class="col-md-3 text-right">Unit name</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="name" placeholder="Unit name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3"></label>
                                                            <div class="col-md-9 text-left">
                                                                <input type="submit" class="btn btn-success" value="Add Unit">
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
                            <div class="dt-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">SL No</th>
                                            <th>Name</th>
                                            <th width="10%" class="text-center">Active Status</th>
                                            <th width="8%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($units as $key => $unit)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $unit->name }}</td>
                                                <td class="text-center">
                                                    @if($unit->status == 1)
                                                        <a title="Inactive Now" href="{{ route('admin.unit.inactive', $unit->id) }}" class="btn btn-success">
                                                            Active
                                                        </a>
                                                    @else
                                                        <a title="Active Now" href="{{ route('admin.unit.active', $unit->id) }}" class="btn btn-danger">
                                                            Inactive
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal-edit{{$key}}">
                                                        <i class="ml-1 fa fa-edit"></i>
                                                    </button>
                                                </td>
                                                <div class="modal fade" id="large-Modal-edit{{$key}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Unit</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.unit.update', $unit->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 text-right">Unit Name</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control" name="name" value="{{ $unit->name }}" placeholder="Unit Name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3"></label>
                                                                        <div class="col-md-9 text-left">
                                                                            <input type="submit" class="btn btn-success" value="Update Unit">
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

@endpush
