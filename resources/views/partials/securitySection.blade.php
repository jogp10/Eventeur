<section id="security" class="visually-hidden mb-5">
        <form class="ps-5" method="POST" action="{{ route('editProfilePassword', ['id' => $account->id]) }}">
            @method('PUT')
            @csrf
            <div class="row row-cols-2 border border-3 gx-0 py-4 px-3">
                <div class="col-12 col-lg-2">
                    <label for="password" class="form-label"><span class="align-middle">Old Password</span></label>
                </div>
                <div class="col-12 col-lg-10 pb-3">
                    <input type="password" name="oldPassword" id="inputName" class="form-control" aria-describedby="nameHelpBlock">
                    @if ($errors->has('oldPassword'))
                    <span class="error">
                        {{ $errors->first('oldPassword') }}
                    </span>
                    @endif
                </div>
                <div class="col-12 col-lg-2">
                    <label for="password" class="form-label"><span class="align-middle">New Password</span></label>
                </div>
                <div class="col-12 col-lg-10 pb-3">
                    <input type="password" name="newPassword" id="inputName" class="form-control" aria-describedby="nameHelpBlock">
                    @if ($errors->has('newPassword'))
                    <span class="error">
                        {{ $errors->first('newPassword') }}
                    </span>
                    @endif
                </div>
                <div class="col-12 col-lg-2">
                    <label for="password" class="form-label"><span class="align-middle">Confirm Password</span></label>
                </div>
                <div class="col-12 col-lg-10">
                    <input type="password" name="password_confirmation" id="inputName" class="form-control" aria-describedby="nameHelpBlock">
                    @if ($errors->has('password_confirmation'))
                    <span class="error">
                        {{ $errors->first('password_confirmation') }}
                    </span>
                    @endif
                </div>
                <div class="col-12 mt-2 ">
                    <div class="form-floating">
                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary liveAlertBtn btn-lg float-end">Save Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form class="ps-5" method="POST" action="{{ route('editProfileEmail', ['id' => $account->id]) }}">
            @method('PUT')
            @csrf
            <div class="row row-cols-2 border border-3 gx-0 py-4 px-3">
                <div class="col-12 col-lg-3">
                    <label for="email" class="form-label"><span class="align-middle">New Email Address</span></label>
                </div>
                <div class="col-12 col-lg-9 pb-3">
                    <input type="email" name="newEmail" id="inputName" class="form-control" aria-describedby="nameHelpBlock">
                    @if ($errors->has('newEmail'))
                    <span class="error">
                        {{ $errors->first('newEmail') }}
                    </span>
                    @endif
                </div>
                <div class="col-12 col-lg-3">
                    <label for="email" class="form-label"><span class="align-middle">Confirm Email Address</span></label>
                </div>
                <div class="col-12 col-lg-9">
                    <input type="email" name="confirmedEmail" id="inputName" class="form-control" aria-describedby="nameHelpBlock">
                    @if ($errors->has('confirmedEmail'))
                    <span class="error">
                        {{ $errors->first('confirmedEmail') }}
                    </span>
                    @endif
                </div>
                <div class="col-12 mt-2">
                    <div class="form-floating">
                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary btn-lg liveAlertBtn float-end">Save Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="Row mt-2 pt-3 pb-4">
        <div class="Col position-relative">
            <button id="open-popup" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-danger position-absolute bottom-0 end-0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>Delete Account</button>
        
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure you want to delete your account?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('Delete', $account->id) }}" id="open-popup" type="button" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>Delete Account
                    </a>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>