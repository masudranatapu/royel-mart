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
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>{{ $title }}</h4>
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
                                            {{$title}}
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
                                    <h2>Main Unit <small class="badge bg-success text-white">{{ $units->count() }}</small></h2>
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
                                                    <h4 class="modal-title">Create Sub Unit</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.sub-unit.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label">Main Unit</label>
                                                            <div class="col-md-9">
                                                                <select name="unit_id" id="" class="form-control">
                                                                    <option value="" disabled selected>Select One</option>
                                                                    @foreach($units as $unit)
                                                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                                    @endforeach
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
                                                            <label class="col-md-3 col-form-label"></label>
                                                            <div class="col-md-9 text-left">
                                                                <input type="submit" class="btn btn-success" value="Create Unit">
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
                                            <th>Main Unit</th>
                                            <th>Active Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subunits as $key => $subunit)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $subunit->name }}</td>
                                                <td>{{ $subunit['unit']['name'] }}</td>
                                                <td>
                                                    @if($subunit ->status == 1)
                                                        <span class="badge bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($subunit->status == 1)
                                                        <a title="Inactive Brand" href="{{ route('admin.subunit.inactive', $subunit->id) }}" class="btn btn-danger">
                                                            <i class="ml-1 fa fa-angle-down"></i>
                                                        </a>
                                                    @else
                                                        <a title="Active Brand" href="{{ route('admin.subunit.active', $subunit->id) }}" class="btn btn-success">
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
                                                                <h4 class="modal-title">Edit Unit</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.sub-unit.update', $subunit->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label">Main Unit</label>
                                                                        <div class="col-md-9">
                                                                            <select name="unit_id" id="" class="form-control">
                                                                                <option value="" disabled selected>Select One</option>
                                                                                @foreach($units as $unit)
                                                                                    <option @if($unit->id == $subunit->unit_id) selected @endif value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label">Name</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control" name="name" value="{{ $subunit->name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-3 col-form-label"></label>
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
                                    <tfoot>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Name</th>
                                            <th>Main Unit</th>
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

@endpush