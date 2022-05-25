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
                                    <h2>Voucher <small class="badge bg-success text-white">{{ $vouchers->count() }}</small></h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#large-Modal">
                                        <i class="fa fa-plus"></i>
                                        Add voucher
                                    </button>
                                    <!-- crate modal  -->
                                    <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Create new voucher</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="text-left" action="{{ route('admin.voucher.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label><strong>Code *</strong></label>
                                                                <input type="text" class="form-control" name="code" required placeholder="Voucher code">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label><strong>Useable Time *</strong></label>
                                                                <input type="number" class="form-control" name="useable_time" required value="1" min="1">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <label><strong>Purchase Amount(Min) *</strong></label>
                                                                <input type="number" class="form-control" name="purchase_amount" required value="0" min="0">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label><strong>Discount *</strong></label>
                                                                <input type="number" class="form-control" name="discount" required value="0" min="0">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label><strong>Discount Type *</strong></label>
                                                                <select class="form-control" name="discount_type" required id="discount_type">
                                                                    <option value="Solid" selected>Solid (৳)</option>
                                                                    <option value="Percentage">Percentage (%)</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <input type="submit" class="btn btn-success" value="Add voucher">
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
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">SL No</th>
                                            <th width="15%">Code</th>
                                            <th>Useable Time</th>
                                            <th>Purchase Amount(Min)</th>
                                            <th>Discount</th>
                                            <th>Discount Type</th>
                                            <th width="10%" class="text-center">Status</th>
                                            <th width="8%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vouchers as $key => $voucher)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $voucher->code }}</td>
                                                <td>{{ $voucher->useable_time }}</td>
                                                <td>{{ $voucher->purchase_amount }} ৳</td>
                                                <td>{{ $voucher->discount }}</td>
                                                <td>
                                                    @if ($voucher->discount_type == 'Solid')
                                                        {{ $voucher->discount_type }} (৳)
                                                    @else
                                                        {{ $voucher->discount_type }} (%)
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.voucher-activity', $voucher->id) }}" title="@if($voucher->status == 1) Click for deactive @else  Click for active @endif" class="btn @if($voucher->status == 1) btn-success @else  btn-danger @endif">
                                                        @if($voucher->status == 1)
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
                                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteData({{ $voucher->id }})">
                                                        <i class="ml-1 fa fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $voucher->id }}" action="{{ route('admin.voucher.destroy', $voucher->id) }}" method="POST" style="display: none;">
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
                                                                <form class="text-left" action="{{ route('admin.voucher.update', $voucher->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group row">
                                                                        <div class="col-md-6">
                                                                            <label><strong>Code *</strong></label>
                                                                            <input type="text" class="form-control" name="code" value="{{ $voucher->code }}" required placeholder="Voucher code">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label><strong>Useable Time *</strong></label>
                                                                            <input type="number" class="form-control" name="useable_time" required value="{{ $voucher->useable_time }}" min="1">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-md-4">
                                                                            <label><strong>Purchase Amount(Min) *</strong></label>
                                                                            <input type="number" class="form-control" name="purchase_amount" required value="{{ $voucher->purchase_amount }}" min="0">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label><strong>Discount *</strong></label>
                                                                            <input type="number" class="form-control" name="discount" required value="{{ $voucher->discount }}" min="0">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label><strong>Discount Type *</strong></label>
                                                                            <select class="form-control" name="discount_type" required id="discount_type">
                                                                                <option value="Solid" @if($voucher->discount_type == 'Solid') selected @endif>Solid (৳)</option>
                                                                                <option value="Percentage" @if($voucher->discount_type == 'Percentage') selected @endif>Percentage (%)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-md-12">
                                                                            <input type="submit" class="btn btn-success" value="Add voucher">
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
