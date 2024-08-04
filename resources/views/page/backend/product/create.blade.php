<div class="card">
    <div class="card-body">
        <form autocomplete="off" method="POST" action="{{ route('productlist.store') }}">
            @csrf
            <div class="row">
                <div class="col-lg-12 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Name <span style="color: red;">*</span></label>
                        <input type="text" name="name" placeholder="Enter name" required>
                    </div>
                </div>
                <div class="col-lg-12 button-align">
                    <button type="submit" class="btn btn-submit me-2">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
