<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="box-body">
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" name="email" class="form-control" id="email" value="{{ isset($user->email) ? $user->email : old('email') }}" placeholder="Email address">
        @if ($errors->has('email'))<p style="color:red;">{!!$errors->first('email')!!}</p>@endif
    </div>
    <div class="form-group">
        <label for="full_name">Full name</label>
        <input type="text" name="name" class="form-control" id="full_name" value="{{ isset($user->name) ? $user->name : old('name') }}" placeholder="Full name">
         @if ($errors->has('name'))<p style="color:red;">{!!$errors->first('name')!!}</p>@endif
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
</div><!-- /.box-body -->

<div class="box-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>