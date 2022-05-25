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
                                <div class="col-md-8">
                                    <h2>Sale <small class="badge bg-success text-white">{{ $sales->count() }}</small></h2>
                                </div>
                                <div class="col-md-4 text-right">
                                    <form class="row" action="{{ route('admin.sale-report-search') }}" method="GET" enctype="multipart/form-data">

                                        <div class="form-group text-left col-5">
                                            <input type="date" class="form-control" name="from" value="{{ \Carbon\Carbon::parse($from)->format('Y-m-d') }}">
                                        </div>

                                        <div class="form-group text-left col-5">
                                            <input type="date" class="form-control" name="to" value="{{ \Carbon\Carbon::parse($to)->format('Y-m-d') }}">
                                        </div>

                                        <div class="form-group text-left col-2">
                                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">SL</th>
                                            <th width="15%">Order Code</th>
                                            <th>Customer</th>
                                            <th width="10%" class="text-right">Total</th>
                                            <th width="10%" class="text-right">Paid</th>
                                            <th width="10%" class="text-right">Due</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                            $paid = 0;
                                            $due = 0;
                                        @endphp
                                        @foreach($sales as $key => $sale)
                                            @php
                                                $total += $sale->total;
                                                $paid += $sale->paid;
                                                $due += $sale->due;
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $sale->order_code }}</td>
                                                <td>
                                                    {{ $sale->customer->name }} <br>
                                                    {{ $sale->customer->phone }}
                                                </td>
                                                <td class="text-right">{{ $sale->total }}</td>
                                                <td class="text-right">{{ $sale->paid }}</td>
                                                <td class="text-right">{{ $sale->due }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    @if ($total > 0)
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right"><strong>Total</strong></td>
                                                <td class="text-right">{{ $total }}</td>
                                                <td class="text-right">{{ $paid }}</td>
                                                <td class="text-right">{{ $due }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
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
