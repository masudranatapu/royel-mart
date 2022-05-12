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
                            <h2>Location:- {{ division_name($division_id) }}{{ district_name($district_id) }}{{ area_name($area_id) }}</h2>
                        </div>
                        <div class="card-block">
                            <form action="{{route('admin.delivery-location.update', $default_location->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label class="text-right">Division</label>
                                        <select name="division_id" id="division_id" required class="form-control select2">
                                            <option value="" disabled selected>Select One</option>
                                            @foreach($divisions as $division)
                                                <option value="{{$division->id}}" @if($division->id == $division_id) selected @endif>{{$division->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-right">District</label>
                                        <select name="district_id" id="district_id" required class="form-control select2">
                                            <option value="">Select One</option>
                                            @foreach($districts as $district)
                                                <option value="{{$district->id}}" @if($district->id == $district_id) selected @endif>{{$district->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-right">Area</label>
                                        <select name="area_id" id="area_id" required class="form-control select2">
                                            <option value="">Select One</option>
                                            @foreach($areas as $area)
                                                <option value="{{$area->id}}" @if($area->id == $area_id) selected @endif>{{$area->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Update Location</button>
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

        $('#division_id').on('change', function(){
            var division_id = $(this).val();

            $('#district_id').html('<option value="">Select One</option>');
            $('#area_id').html('<option value="">Select One</option>');

            $.ajax({
                url: "{{ route('admin.get-district-by-division') }}",
                type:"POST",
                data:{
                    _token: '{{csrf_token()}}',
                    division_id: division_id,
                },
                success:function(data) {
                    $('#district_id').html(data);
                },
            });

        });

        $('#district_id').on('change', function(){
            var district_id = $(this).val();

            $('#area_id').html('<option value="">Select One</option>');

            $.ajax({
                url: "{{ route('admin.get-area-by-district') }}",
                type:"POST",
                data:{
                    _token: '{{csrf_token()}}',
                    district_id: district_id,
                },
                success:function(data) {
                    $('#area_id').html(data);
                },
            });

        });
    </script>
@endpush
