<section id="settings" class="mb-5">
        <form class="ps-5" method="POST" action="{{ route('editProfile', ['id' => $account->id]) }}">
            @method('PUT')
            @csrf
            <div class="row row-cols-2 border border-3 gx-0 py-4 px-3">
                <div class="col-12 col-lg-2">
                    <label for="name" class="form-label"><span class="align-middle">Name</span></label>
                </div>
                <div class="col-12 col-lg-10">
                    <input type="name" name="name" id="inputName" class="form-control" aria-describedby="nameHelpBlock" value="{{$account->name}}">
                    <div id="nameHelpBlock" class="form-text pe-2">Change your password</div>
                    @if ($errors->has('name'))
                    <span class="error text-danger">
                        {{ $errors->first('name') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="row row-cols-3 border border-3 gx-0 py-4 px-3">
                <div class="col-12 col-lg-2">
                    <label for="inputUsername5" class="form-label"><span class="align-middle">Description</span></label>
                </div>
                <div class="col-12 col-lg-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="description" id="floatingTextarea2" style="height: 300px">{{$account->description}}</textarea>
                        <div id="nameHelpBlock" class="form-text pe-2">Must not exceed 200 characters</div>
                        @if ($errors->has('description'))
                            <span class="error text-danger">
                            {{ $errors->first('description') }}
                            </span>
                        @endif
                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary btn-lg float-end">Save Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
</section>