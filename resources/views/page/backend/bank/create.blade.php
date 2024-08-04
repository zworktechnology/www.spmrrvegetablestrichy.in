<div class="card">
    <div class="card-body">
        <form autocomplete="off" method="POST" action="{{ route('bank.store') }}">
            @csrf
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label>Name <span style="color: red;">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Canxxx Baxx" required>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Details</label>
                        <textarea type="text" name="details" placeholder="Accxxxxx Nx : 00xx00xx00xx00"></textarea>
                    </div>
                </div>
                <div class="col-lg-12 button-align">
                    <button type="submit" class="btn btn-submit me-2">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
