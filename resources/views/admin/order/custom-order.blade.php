@extends('layouts.backend.app')

@section('title')
    {{$title}}
@stop

@push('css')
    <link rel="stylesheet" href="{{asset('backend/select2/css/select2.css')}}">
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
                                    <h2>{{ $title }} <small class="badge bg-success text-white">{{ $orders->count() }}</small></h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">SL No</th>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>phone</th>
                                            <th>Address</th>
                                            <th width="20%">Order File</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th class="text-center" width="8%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $key => $order)
                                            <tr class="@if($order->status == 'Canceled') text-danger @endif">
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->email }}</td>
                                                <td>{{ $order->phone }}</td>
                                                <td>{{ $order->address }}</td>
                                                <td>
                                                    <a href="{{ URL::to($order->image) }}" target="_blank">
                                                        <img src="{{ URL::to($order->image) }}" width="100%" height="150px" alt="">
                                                    </a>
                                                </td>
                                                <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
                                                <td class="text-center">
                                                    @if($order->status == 'Canceled')
                                                        <span class="badge bg-danger text-white">Canceled</span>
                                                    @elseif($order->status == 'Confirmed')
                                                        <span class="badge bg-success text-white">Confirmed</span>
                                                    @else
                                                        <form action="{{ route('admin.custom-order-status-change') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                            <select name="status" id="" class="form-control select2" onchange="this.form.submit()">
                                                                <option value="">Select One</option>
                                                                <option @if($order->status == 'Pending') selected @endif disabled value="Pending">Pending</option>
                                                                <option @if($order->status == 'Confirmed') selected @endif @if($order->status == 'Confirmed' || $order->status == 'Canceled') disabled @endif  value="Confirmed">Confirmed</option>
                                                                <option @if($order->status == 'Canceled') selected @endif @if($order->status == 'Confirmed' || $order->status == 'Canceled') disabled @endif value="Canceled">Canceled</option>
                                                            </select>
                                                        </form>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->status == 'Confirmed')
                                                        <a href="{{ route('admin.create-custom-order', $order->id) }}" class="btn btn-sm btn-info" title="Edit Order">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif

                                                    <button class="btn btn-danger btn-sm waves-effect" type="button" onclick="deleteData({{ $order->id }})">
                                                        <i class="ml-1 fa fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $order->id }}" action="{{ route('admin.custom-order-delete', $order->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </td>
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
    <script src="{{asset('backend/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('massage/sweetalert/sweetalert.all.js')}}"></script>

    <script type="text/javascript">
        $('.select2').select2();

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
