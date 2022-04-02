<div class="modal fade" id="custom-order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="edit-form">
                <form action="{{ route('custom-order-submit') }}" method="POST" class="address" enctype="multipart/form-data">
                    @csrf
                    <div class="address-wrapper">
                        <div class="single-input">
                            <label for="name">Name </label>
                            <input id="name" class="form-control" type="text" name="name" value=" @auth {{ Auth::user()->name }} @endauth " required placeholder="Name">
                        </div>
                        <div class="single-input">
                            <label for="phone">Email Address </label>
                            <input id="phone" class="form-control" type="text" name="email" value=" @auth {{ Auth::user()->email }} @endauth " placeholder="email">
                        </div>
                        <div class="single-input">
                            <label for="phone">Phone Number </label>
                            <input id="phone" class="form-control" type="text" name="phone" value=" @auth {{ Auth::user()->phone }} @endauth " required placeholder="Phone">
                        </div>
                        <div class="single-input">
                            <label for="Address">Address</label>
                            <textarea class="form-control" name="address" id="address" placeholder="Address" required cols="30" rows="1">@auth {{ Auth::user()->address }} @endauth</textarea>
                        </div>
                        <div class="single-input">
                            <label for="image">Bazar List Image </label>
                            <input id="image" class="form-control" type="file" required name="image">
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="save-address">save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
