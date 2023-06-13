<div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"
                id="customerdeleteLargeModalLabel{{ $customertdata['unique_key'] }}">
                Destroy Customer</h5>
        </div>
        <div class="modal-body px-4 py-5 text-center">
            <div class="avatar-sm mb-4 mx-auto">
                <div
                    class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                    <i class="mdi mdi-trash-can-outline"></i>
                </div>
            </div>
            <p class="text-muted font-size-16 mb-4">Please confirm that you wish to
                remove the customer.</p>

            <div class="hstack gap-2 justify-content-center mb-0">
                <form autocomplete="off" method="POST"
                    action="{{ route('customer.delete', [$customertdata['unique_key']]) }}">
                    @method('PUT')
                    @csrf
                    <button type="submit" class="btn btn-danger">Yes, Delete it</button>
                </form>
                <a href="{{ route('customer.index') }}"><button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cancel</button></a>
            </div>
        </div>
    </div>
</div>