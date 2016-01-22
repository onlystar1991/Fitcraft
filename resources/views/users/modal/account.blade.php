
<div class="ride_setup_item">
    <div class="ride_setup_col_2 ride_setup_col_2--account-label">
        <div class="pull-left">NAME</div>
    </div>
    <div class="ride_setup_col_2 ride_setup_col_2--account-input">
        <div class="form-control-container form-control-container__ridesetup form-control-container--account-setup">
            <input class="form-control " type="text" name="field[name]" value="{{$user->name}}" disabled>
        </div>
    </div>
    <div class="pull-left">
        <button class="btn btn-st-2 btn-grey btn-account-edit" data-field="name">EDIT</button>
    </div>
</div>
<div class="ride_setup_item">
                <div class="ride_setup_col_2 ride_setup_col_2--account-label">
                    <div class="pull-left">USERNAME</div>
                </div>
                <div class="ride_setup_col_2 ride_setup_col_2--account-input">
                    <div class="form-control-container form-control-container__ridesetup form-control-container--account-setup">
                        <input class="form-control" type="text" name="field[username]" value="{{$user->username}}" disabled>
                    </div>
                </div>
                <div class="pull-left">
                    <button class="btn btn-st-2 btn-grey btn-account-edit" data-field="username">EDIT</button>
                </div>
            </div>
<div class="ride_setup_item">
                <div class="ride_setup_col_2 ride_setup_col_2--account-label">
                    <div class="pull-left">PASSWORD</div>
                </div>
                <div class="ride_setup_col_2 ride_setup_col_2--account-input">
                    <div class="form-control-container form-control-container__ridesetup form-control-container--account-setup" >
                        <input class="form-control" type="field[password]" value="123456" disabled>
                    </div>
                </div>
                <div class="pull-left">
                    <button class="btn btn-st-2 btn-grey btn-account-edit" data-field="password">EDIT</button>
                </div>
            </div>
<div class="ride_setup_item">
                <div class="ride_setup_col_2 ride_setup_col_2--account-label">
                    <div class="pull-left">CONFIRM PASSWORD</div>
                </div>
                <div class="ride_setup_col_2 ride_setup_col_2--account-input">
                    <div class="form-control-container form-control-container__ridesetup form-control-container--account-setup" >
                        <input class="form-control" type="password" value="123456" disabled>
                    </div>
                </div>
            </div>
<div class="ride_setup_item">
                <div class="ride_setup_col_2 ride_setup_col_2--account-label">
                    <div class="pull-left">BIRTH DATE</div>
                </div>
                <div class="ride_setup_col_2 ride_setup_col_2--account-input">
                    <div class="form-control-container form-control-container__ridesetup form-control-container--account-setup">
                        <input class="form-control" type="text" name="field[dob]" value="{{date('m/d/-Y',strtotime($user->dob))}}" disabled>
                    </div>
                </div>
                <div class="pull-left">
                    <button class="btn btn-st-2 btn-grey btn-account-edit" data-field="dob">EDIT</button>
                </div>
            </div>
<div class="ride_setup_item">
                <div class="ride_setup_col_2 ride_setup_col_2--account-label">
                    <div class="pull-left">GENDER</div>
                </div>
                <div class="ride_setup_col_2 ride_setup_col_2--account-input">
                    <div class="form-control-container form-control-container__ridesetup form-control-container--account-setup">
                        <select class="form-control" name="field[gender]" disabled>
                            <option value=""></option>
                            <option value="m" {{($user->gender == 'm') ? 'selected="selected"' :''}}>MALE</option>
                            <option value="f" {{($user->gender == 'f') ? 'selected="selected"' :''}}>FEMALE</option>
                        </select>
                    </div>
                </div>
                <div class="pull-left">
                    <button class="btn btn-st-2 btn-grey btn-account-edit" data-field="gender">EDIT</button>
                </div>
            </div>
<div class="ride_setup_item">
                <div class="ride_setup_col_2 ride_setup_col_2--account-label">
                    <div class="pull-left">HOME ZIPCODE</div>
                </div>
                <div class="ride_setup_col_2 ride_setup_col_2--account-input">
                    <div class="form-control-container form-control-container__ridesetup form-control-container--account-setup">
                        <input class="form-control" type="text" name="field[zip]" disabled value="{{$user->zip}}">
                    </div>
                </div>
                <div class="pull-left">
                    <button class="btn btn-st-2 btn-grey btn-account-edit" data-field="zip">EDIT</button>
                </div>
            </div>
<div class="ride_setup_item">
                <div class="ride_setup_col_2 ride_setup_col_2--account-label">
                    <div class="pull-left">ACCOUNT STATUS</div>
                </div>
                <div class="ride_setup_col_2 ride_setup_col_2--account-input">
                    <div class="form-control-container--account-setup mt0">ACTIVE</div>
                </div>
                <div class="pull-left">
                    <button class="btn btn-st-2 btn-grey">EDIT</button>
                </div>
            </div>
<div class="ride_setup_item">
    <div class="ride_setup_col_2 ride_setup_col_2--account-label">
        <div class="pull-left">MEMBER SINCE</div>
    </div>
    <div class="ride_setup_col_2 ride_setup_col_2--account-input">
        <div class="form-control-container--account-setup mt0">MARCH 30, 2015</div>
    </div>
</div>
