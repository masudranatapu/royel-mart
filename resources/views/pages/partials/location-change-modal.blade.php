<div class="modal fade" id="changeLocationModal" tabindex="-1" role="dialog" aria-labelledby="changeLocationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeLocationModalLabel">Change Location</h5>
                <button type="button" class="close-btn" data-dismiss="modal" onclick="closeChangeLocationModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="text-right">Division</label>
                    <select name="division_id" id="division_id" required class="form-control select2">
                        <option value="" disabled selected>Select One</option>
                        @foreach($divisions as $division)
                            <option value="{{$division->id}}" @if($division->id == $division_id) selected @endif>{{$division->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="text-right">District</label>
                    <select name="district_id" id="district_id" required class="form-control select2">
                        <option value="">Select One</option>
                        @foreach($districts as $district)
                            <option value="{{$district->id}}" @if($district->id == $district_id) selected @endif>{{$district->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="text-right">Area</label>
                    <select name="area_id" id="area_id" required class="form-control select2">
                        <option value="">Select One</option>
                        @foreach($areas as $area)
                            <option value="{{$area->id}}" @if($area->id == $area_id) selected @endif>{{$area->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="product-btn cart-btn" onclick="changeLocationDone()">Change</button>
                </div>
            </div>
        </div>
    </div>
</div>
