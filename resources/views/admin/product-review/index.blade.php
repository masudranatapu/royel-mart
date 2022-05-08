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
                                <h2>Customer <small class="badge bg-success text-white">{{ $reviews->count() }}</small></h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive">
                            <table id="simpletable" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">SL</th>
                                        <th>Name</th>
                                        <th class="">Phone</th>
                                        <th class="">Product</th>
                                        <th class="">Rating</th>
                                        <th class="">Comment</th>
                                        <th width="10%" class="">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $key => $review)
                                        <tr>
                                            <td class="text-center">{{ $key+1 }}</td>
                                            <td>{{ $review->name }}</td>
                                            <td>{{ $review->phone }}</td>
                                            <td>{{ product_name($review->product_id) }}</td>
                                            <td>{{ $review->rating }}</td>
                                            <td>{{ $review->opinion }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm waves-effect" data-toggle="modal" data-target="#review_replay_modal_{{$key}}">
                                                    <i class="fa fa-send"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm waves-effect" type="button" onclick="deleteData({{ $review->id }})">
                                                    <i class="fa fa-trash mr-1"></i>
                                                </button>
                                                <form id="delete-form-{{ $review->id }}" action="{{ route('admin.product-review-destroy', $review->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="review_replay_modal_{{$key}}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Replay Review</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true"> &times; </span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('admin.product-review-replay', $review->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label class="">Image</label>
                                                                <input type="file" class="form-control" name="image[]" multiple>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Comment</label>
                                                                <textarea class="form-control" name="replay_opinion" id="replay_opinion" cols="30" rows="3"></textarea>
                                                            </div>
                                                            <div class="form-group ">
                                                                <input type="submit" class="btn btn-success" value="Update Brand">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
