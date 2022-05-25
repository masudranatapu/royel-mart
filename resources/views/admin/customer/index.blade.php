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
                                <h2>Customer <small class="badge bg-success text-white">{{ $customers->count() }}</small></h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">SL No</th>
                                        <th class="">Image</th>
                                        <th>Name</th>
                                        <th class="">Phone</th>
                                        <th class="">Email</th>
                                        <th class="">Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $key => $customer)
                                    <tr>
                                        <td class="">{{ $key+1 }}</td>
                                        <td class="">
                                            <img width="60" height="60" src="@if($customer->image) {{ asset($customer->image) }} @else {{ asset('demomedia/customer.png') }} @endif" alt="">
                                        </td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->address }}</td>
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
            title: 'Are you sure?'
            , text: "You won't be able to revert this!"
            , type: 'warning'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Yes, delete it!'
            , cancelButtonText: 'No, cancel!'
            , confirmButtonClass: 'btn btn-success'
            , cancelButtonClass: 'btn btn-danger'
            , buttonsStyling: false
            , reverseButtons: true
        }).then((result) => {
            if (result.value) {
                // event.preventDefault();
                document.getElementById('delete-form-' + id).submit();
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swal(
                    'Cancelled'
                    , 'Your data is safe :)'
                    , 'error'
                )
            }
        })
    }

</script>
@endpush
