@extends('admin')

@section('title', 'Users')
@section('subtitle', 'Add user')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="{{ url('/admin/') }}"><i class="fa fa-group"></i> Home</a></li>
        <li><a href="{{ url('/admin/users') }}">Users</a></li>
        <li class="active">Add</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">
                    <div class="box-body">
                        <form role="form" enctype="multipart/form-data" action="{{ url('admin/users/save') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ isset($user->email) ? $user->email : old('email') }}" placeholder="Email address">
                                    @if ($errors->has('email'))<p style="color:red;">{!!$errors->first('email')!!}</p>@endif
                                </div>

                                <div class="form-group">
                                    <label for="full_name">Full name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ isset($user->name) ? $user->name : old('name') }}" placeholder="Full name">
                                    @if ($errors->has('name'))<p style="color:red;">{!!$errors->first('name')!!}</p>@endif
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-md-3 row">
                                        <label for="full_name">Date of birth</label>
                                        <input type="text" name="dob" class="form-control" id="dob" value="{{ isset($user->dob) ? date('m/d/Y',strtotime($user->dob)) : old('dob') }}" placeholder="MM/DD/YYYY">
                                        @if ($errors->has('dob'))<p style="color:red;">{!!$errors->first('dob')!!}</p>@endif
                                    </div>
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
                                <div class="form-group">
                                    <div class="clearfix">
                                        <div class="col-md-3 row">
                                            <label for="full_name">Type of account</label>
                                            <select name="package" class="form-control">
                                                <option value=""></option>
                                                @foreach( $packages as $package )
                                                    <option value="{{ $package->id }}">{{ $package->title }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('package'))<p style="color:red;">{!! $errors->first('package') !!}</p>@endif
                                        </div>

                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section>
@endsection
