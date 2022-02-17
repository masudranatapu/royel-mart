@extends('layouts.backend.app')

@section('title')
{{$title}}
@stop

@push('css')
    <style>
        .website-logo {
            height: 80px;
            width: 80px;
        }
        .website-favicon {
            height: 50px;
            width: 50px;
         }
         .website-footer-logo {
            height: 80px;
            width: 80px;
         }
    </style>
@endpush

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="main" method="post" action="{{route('admin.website.update', $website->id)}}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <div class="card-header bg-success">
                                        <h4 class="text-white">Update Your Website</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Website Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name" value="{{$website->name}}" placeholder="Website Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Email Address</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="email" value="{{$website->email}}" placeholder="Email Address">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Logo</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" onChange="mainTham(this)" name="logo" class="custom-file-input">
                                                        <label class="custom-file-label">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <img class="website-logo" src="@if($website->logo) {{ asset($website->logo) }} @else {{ asset('demomedia/projanmoitlogo.png') }} @endif" id="showTham">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Favicon</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" onChange="mainFavion(this)" name="favicon" class="custom-file-input">
                                                        <label class="custom-file-label">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <img class="website-favicon" src="@if($website->favicon) {{ asset($website->favicon) }} @else {{ asset('demomedia/projanmoitlogo.png') }} @endif" id="favion">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Footer Logo</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" onChange="mainThamFooter(this)" name="footer_logo" class="custom-file-input">
                                                        <label class="custom-file-label">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <img class="website-footer-logo" src="@if($website->footer_logo) {{ asset($website->footer_logo) }} @else {{ asset('demomedia/projanmoitlogo.png') }} @endif" id="footerlogo">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Phone Number</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="phone" value="{{$website->phone}}" placeholder="Phone Number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Fax Number</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="fax" value="{{$website->fax}}" placeholder="Fax number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Telephone Number</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="tel" value="{{$website->tel}}" placeholder="Telephone number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-9">
                                                <textarea name="description" class="form-control" placeholder="Description" cols="30" rows="2">{{$website->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Meta Keyword</label>
                                            <div class="col-sm-9">
                                                <textarea name="meta_keyword" class="form-control" placeholder="Key word" cols="30" rows="2">{{$website->meta_keyword}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Meta Decription</label>
                                            <div class="col-sm-9">
                                                <textarea name="meta_decription" class="form-control" placeholder="Meta description" cols="30" rows="2">{{$website->meta_decription}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Address</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="address" value="{{$website->address}}" placeholder="Website address">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Twitter Api</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="twitter_api" value="{{$website->twitter_api}}" placeholder="Twitter Api">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Google map</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="google_map" value="{{$website->google_map}}" placeholder="Google map">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Facebook Pixel </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="facebook_pixel" value="{{$website->facebook_pixel}}" placeholder="Facebook pixel">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Google Analytics</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="google_analytics" value="{{$website->google_analytics}}" placeholder="Google analytics">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Schema</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="schema" value="{{$website->schema}}" placeholder="Schema">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Canonical link</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="canonical_link" value="{{$website->canonical_link}}" placeholder="Canonical link">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header bg-info">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Website links</h4>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <input type="hidden" id="website_row_number" value="{{ rand(111, 999) }}">
                                                <button type="button" class="btn btn-sm btn-success" onclick="addNewAdditionalInfo()">
                                                    <i class="fa fa-plus"></i>
                                                    Add More Links
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mt-2">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th>Website Icon</th>
                                                            <th>Website Link</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </tbody>
                                                    <tbody id="show_row">
                                                        @php
                                                            $icon = explode("|",$website->icon);
                                                            $link = explode("|",$website->link);
                                                        @endphp
                                                        @foreach($icon as $key=>$icon)
                                                            <tr id="website_remove_row_{{$key}}">
                                                                <td>
                                                                    <input type="text" name="icon[]" value="{{$icon}}" class="form-control" placeholder="Icon form frontawsome">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="link[]" value="@if(isset($link[$key])){{$link[$key]}}@endif" class="form-control" placeholder="Website link like https://">
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" onclick="websiteRemovieRow(this)" id="{{$key}}" class="btn btn-danger">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-success m-b-0">Update Website</button>
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