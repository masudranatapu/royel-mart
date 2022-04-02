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
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="main" method="post" action="{{route('admin.system-setting.update', $setting->id)}}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <div class="card-header bg-success">
                                        <h4 class="text-white">Update {{ $title }}</h4>
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Time Zone</label>
                                                <input type="text" class="form-control" name="time_zone" required value="{{$setting->time_zone}}" placeholder="Time zone">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Date Format</label>
                                                <input type="text" class="form-control" name="date_format" required value="{{$setting->date_format}}" placeholder="Date format">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Time Format</label>
                                                <input type="text" class="form-control" name="time_format" required value="{{$setting->time_format}}" placeholder="Time format">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Currency</label>
                                                <input type="text" class="form-control" name="currency" required value="{{$setting->currency}}" placeholder="Currency">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Shipping Charge</label>
                                                <input type="number" class="form-control" name="shipping_charge" required value="{{$setting->shipping_charge}}" placeholder="Shipping charge">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">Vat</label>
                                                <input type="text" class="form-control" name="vat" required value="{{$setting->vat}}" placeholder="Vat">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-success m-b-0">Update</button>
                                            </div>
                                        </div>

                                    </div>
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

<script>
        $(document).ready(function() {
            //add row
            $('body').on('click','.DiaAddBtn' ,function() {
                var itemData = $(this).parent().parent().parent();
                $('#diagnosis').append("<tr>"+itemData.html()+"</tr>");
                $('#diagnosis tr:last-child').find(':input').val('');
            });
            //remove row
            $('body').on('click','.DiaRemoveBtn' ,function() {
                $(this).parent().parent().parent().remove();
            });

        });

        function mainTham(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showTham').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function mainFavion(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#favion').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function mainThamFooter(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#footerlogo').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        function addNewAdditionalInfo() {
            // alert('helo');
            var website_row_number = $("#website_row_number").val();
            // alert(amount_id);

            var new_row_number = Math.floor(Math.random()*(999-100+1)+100);
            if($("#website_remove_row_" + website_row_number).new_row_number == 0) {
                var new_id = Math.floor(Math.random()*(999-100+1)+100);
            }
            $.ajax({
                type    : "POST",
                url     : "{{ route('admin.row.addremove') }}",
                data    : {
                    id      : website_row_number,
                    _token  : '{{csrf_token()}}',
                },
                success:function(data) {
                    console.log(data);
                    $('#show_row').append(data);
                    $('#website_row_number').val(new_row_number);
                },
            });
        };
        function websiteRemovieRow(obj) {
            // alert('Hell');
            var website_row_number = obj.id;
            // alert(website_row_number);
            $("#website_remove_row_" + website_row_number).remove();
        };
    </script>
@endpush
