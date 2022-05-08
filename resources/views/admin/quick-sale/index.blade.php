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
                                    <h2>Quick Sale <small class="badge bg-success text-white">{{ $sales->count() }}</small></h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#large-Modal">
                                        <i class="fa fa-plus"></i>
                                        Add Quick Sale
                                    </button>
                                    <!-- crate modal  -->
                                    <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Create new sale</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="text-left" action="{{ route('admin.quick-sale.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <label><strong>Title *</strong></label>
                                                                <input type="text" class="form-control" name="title" required placeholder="Title">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <label><strong>Image</strong></label>
                                                                <input type="file" class="form-control" name="image" >
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label><strong>Start Time *</strong></label>
                                                                <input type="datetime-local" class="form-control" name="start_date_time" required placeholder="Start time">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label><strong>End Time</strong></label>
                                                                <input type="datetime-local" class="form-control" name="end_date_time" required placeholder="End time">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label><strong>Discount *</strong></label>
                                                                <input type="number" class="form-control" name="discount" required value="0" min="0">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label><strong>Discount Type *</strong></label>
                                                                <select class="form-control" name="discount_type" required id="discount_type">
                                                                    <option value="Solid" selected>Solid (৳)</option>
                                                                    <option value="Percentage">Percentage (%)</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <input type="submit" class="btn btn-success" value="Add Quicksale">
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
                                            <th width="15%" class="text-center">Banner</th>
                                            <th>Title</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Discount</th>
                                            <th>Discount Type</th>
                                            <th width="10%" class="text-center">Set Product</th>
                                            <th width="10%" class="text-center">Status</th>
                                            <th width="8%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sales as $key => $sale)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>
                                                    <img src="@if(file_exists($sale->image)) {{ asset($sale->image) }} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" width="100%" height="100px" alt="banner image">
                                                </td>
                                                <td>
                                                    <a href="#">{{ $sale->title }}</a>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($sale->start_date_time)->format('d M Y h:i A')}}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($sale->end_date_time)->format('d M Y h:i A')}}
                                                </td>
                                                <td>{{ $sale->discount }}</td>
                                                <td>
                                                    @if ($sale->discount_type == 'Solid')
                                                        {{ $sale->discount_type }} (৳)
                                                    @else
                                                        {{ $sale->discount_type }} (%)
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.quick-sale-product', $sale->id) }}" title="Set products for this sale" class="btn btn-info">
                                                        <i class="fa fa-plus"></i> Set Products
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.quick-sale-activity', $sale->id) }}" title="@if($sale->status == 1) Click for deactive @else  Click for active @endif" class="btn @if($sale->status == 1) btn-success @else  btn-danger @endif">
                                                        @if($sale->status == 1)
                                                            Active
                                                        @else
                                                            Inactive
                                                        @endif
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal-edit{{$key}}">
                                                        <i class="ml-1 fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteData({{ $sale->id }})">
                                                        <i class="ml-1 fa fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $sale->id }}" action="{{ route('admin.quick-sale.destroy', $sale->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                                <div class="modal fade" id="large-Modal-edit{{$key}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit voucher</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="text-left" action="{{ route('admin.quick-sale.update', $sale->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group row">
                                                                        <div class="col-md-12">
                                                                            <label><strong>Title *</strong></label>
                                                                            <input type="text" class="form-control" name="title" value="{{ $sale->title }}" required placeholder="Title">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-md-12">
                                                                            <label><strong>Image</strong></label>
                                                                            <input type="file" class="form-control" name="image" >
                                                                            <img class="mt-2" src="@if(file_exists($sale->image)) {{ asset($sale->image) }} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" width="150px" height="100px" alt="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-md-6">
                                                                            <label><strong>Start Time *</strong></label>
                                                                            <input type="datetime-local" class="form-control" name="start_date_time" value="{{ \Carbon\Carbon::parse($sale->start_date_time)->format('Y-m-d\TH:i:s')}}" required placeholder="Start time">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label><strong>End Time *</strong></label>
                                                                            <input type="datetime-local" class="form-control" name="end_date_time" value="{{ \Carbon\Carbon::parse($sale->end_date_time)->format('Y-m-d\TH:i:s')}}" required placeholder="End time">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-md-6">
                                                                            <label><strong>Discount *</strong></label>
                                                                            <input type="number" class="form-control" name="discount" required value="{{ $sale->discount }}" min="0">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label><strong>Discount Type *</strong></label>
                                                                            <select class="form-control" name="discount_type" required id="discount_type">
                                                                                <option value="Solid" @if($sale->discount_type == 'Solid') selected @endif>Solid (৳)</option>
                                                                                <option value="Percentage" @if($sale->discount_type == 'Percentage') selected @endif>Percentage (%)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-md-12">
                                                                            <input type="submit" class="btn btn-success" value="Update Quicksale">
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
@endpush
