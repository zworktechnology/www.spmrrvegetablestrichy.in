@extends('layout.backend.auth')

@section('content')
    <div class="content">
      <script>
    @if (Session::has('error'))
    <div id="solid-warningToast" class="toast colored-toast bg-warning text-fixed-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-warning text-fixed-white">
            <strong class="me-auto">Toast</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
        {{ session('error') }}
        </div>zz
    </div>
    @endif
    </script>

        <div class="card">
            <div class="card-body">
                
            <div class="main-wrapper">
               <div class="account-content">
                  <div class="login-wrapper login-new">
                     <div class="login-content user-login">

                           <form autocomplete="off" method="POST" action="{{ route('settings.passwordupdate', ['id' => Auth::user()->id]) }}">
                              @method('PUT')
                              @csrf
                              <div class="login-userset">
                                 <div class="login-userheading">
                                    <h3>Reset password?</h3>
                                    <h4>Enter New Password & Confirm Password to get inside</h4>
                                 </div>
                                 <div class="form-login">
                                    <label> Old Password</label>
                                       <div class="pass-group">
                                          <input type="password" class="pass-input" value="{{$GetUser->password}}">
                                       </div>
                                 </div>
                                 <div class="form-login">
                                    <label>New Password</label>
                                    <div class="pass-group">
                                       <input type="password" class="pass-inputa" name="new_password">
                                    </div>
                                 </div>
                                 <div class="form-login">
                                    <label> New Confirm Passworrd</label>
                                    <div class="pass-group">
                                       <input type="password" class="pass-inputs" name="confirmnew_password">
                                    </div>
                                 </div>
                                 <div class="form-login">
                                    <button type="submit" class="btn btn-login">Change Password</button>
                                 </div>
                              </div>
                           </form>
                     </div>

                  </div>
               </div>
            </div>


            </div>
        </div>

       

    </div>
@endsection
