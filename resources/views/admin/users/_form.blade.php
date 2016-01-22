<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="box-body">
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" name="email" class="form-control" id="email" value="{{ isset($user->email) ? $user->email : old('email') }}" placeholder="Email address">
        @if ($errors->has('email'))<p style="color:red;">{!!$errors->first('email')!!}</p>@endif
    </div>
    <div class="form-group">
        <label for="username">Nickname</label>
        <input type="text" name="nickname" class="form-control" id="nickname" value="{{ isset($user->nickname) ? $user->nickname : old('nickname') }}" placeholder="Nickname">
        @if ($errors->has('nickname'))<p style="color:red;">{!!$errors->first('nickname')!!}</p>@endif
    </div>
    <div class="form-group">
        <label for="full_name">First name</label>
        <input type="text" name="name" class="form-control" id="name" value="{{ isset($user->name) ? $user->name : old('name') }}" placeholder="First name">
        @if ($errors->has('name'))<p style="color:red;">{!!$errors->first('name')!!}</p>@endif
    </div>
    <div class="form-group">
        <label for="full_name">Last name</label>
        <input type="text" name="last_name" class="form-control" id="last_name" value="{{ isset($user->last_name) ? $user->last_name : old('last_name') }}" placeholder="Last name">
        @if ($errors->has('last_name'))<p style="color:red;">{!!$errors->first('last_name')!!}</p>@endif
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password" value="" placeholder="Password" autocomplete="no">
        @if ($errors->has('password'))<p style="color:red;">{!!$errors->first('password')!!}</p>@endif
        @if(isset($user))<p class="help-block">Leave blank to keep unchanged.</p>@endif
    </div>
    <div class="form-group">
        <label for="password2">Repeat password</label>
        <input type="password" name="password_confirmation" class="form-control" id="password2" value="" placeholder="Repeat password" autocomplete="no">
    </div>

    <div class="form-group clearfix">
        <div class="col-md-3 row">
            <label for="power">Gender</label>
            <select class="form-control" name="gender" >
                <option value=""></option>
                <option value="f" {{ $user->gender == 'f' ? 'selected="selected"' : '' }}>Female</option>
                <option value="m" {{ $user->gender == 'm' ? 'selected="selected"' : '' }}>Male</option>
            </select>
              @if ($errors->has('gender'))<p style="color:red;">{!!$errors->first('gender')!!}</p>@endif
        </div>
    </div>
    <div class="form-group clearfix">
        <div class="col-md-3 row">
            <label for="full_name">Zip Code</label>
            <input type="text" name="zip" class="form-control" id="zip" value="{{ isset($user->zip) ? $user->zip : old('zip') }}" placeholder="Zip Code">
            @if ($errors->has('zip'))<p style="color:red;">{!!$errors->first('zip')!!}</p>@endif
        </div>
    </div>
    <div class="form-group clearfix">
        <div class="col-md-3 row">
            <label for="full_name">Date of birth</label>
            <input type="text" name="dob" class="form-control" id="dob" value="{{ isset($user->dob) ? date('m/d/Y',strtotime($user->dob)) : old('dob') }}" placeholder="MM/DD/YYYY">
            @if ($errors->has('dob'))<p style="color:red;">{!!$errors->first('dob')!!}</p>@endif
        </div>
    </div>
    <div class="form-group clearfix">
        <div class="col-md-3 row">
            <label for="full_name">Level</label>
            <input type="text" name="level" class="form-control" id="level" value="{{ isset($user->level) ? $user->level : old('level') }}" placeholder="Level">
        </div>
        @if ($errors->has('level'))<p style="color:red;">{!!$errors->first('level')!!}</p>@endif
    </div>
    <div class="form-group">
        <div class="clearfix">
            <label for="full_name">Race category</label>
            {{ $race_category->title }}
        </div>
    </div>
    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-3 row">
                <label for="full_name">Type of account</label>
                <select name="package" class="form-control">
                    <option value=""></option>
                    @foreach($packages as $package)
                        <option value="{{ $package->id }}"  {{ ($package->id == $user->package_id) ? 'selected="selected"' : '' }} >{{ $package->title }}</option>
                    @endforeach

                </select>
                 @if ($errors->has('package'))<p style="color:red;">{!!$errors->first('package')!!}</p>@endif
            </div>

        </div>
    </div>

</div><!-- /.box-body -->

<div class="box-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>