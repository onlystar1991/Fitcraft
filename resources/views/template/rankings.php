<div class="table__users__item clearfix {{($key==4) ? 'is-active' : ''}}">
    <div class="clearfix table__users_container">
        <div class="users_avatar"  ng-click="showDetails({{$key}})">
            <img src="/assets/img/user_1.png" alt="" class="img-responsive"/>
        </div>
        <div class="users__ridename"  ng-click="showDetails({{$key}})">{{ $user['name'] }}</div>
        <div class="users__criteria"  ng-click="showDetails({{$key}})">{{ $user['criteria'] }}</div>
        <div class="users__percentile"  ng-click="showDetails({{$key}})">{{ $user['percentile'] }}</div>
        <div class="users__rank "  ng-click="showDetails({{$key}})">{{ $user['rank'] }}</div>
    </div>
    <div class="clearfix text-center ride_description">
        <i class="icon__arrow arrow__down users__arrow_down"></i>
    </div>
    <div class="clearfix ride_info">
        <div class="ride_info_level">
            <div class="ride_info_level_label">LEVEL</div>
            <div class="ride_info_level_number">65</div>
        </div>
        <div class="ride_info_category">
            <div class="ride_info_category_label">CATEGORY</div>
            <div class="ride_info_category_number">3</div>
        </div>
        <div class="ride_info_power">
            <div class="ride_info_power_label">POWER</div><div class="ride_info_power_value">65</div>
            <div class="ride_info_power_label">SPEED</div><div class="ride_info_power_value">38</div>
            <div class="ride_info_power_label">STAMINA </div><div class="ride_info_power_value">75</div>
            <div class="ride_info_power_label">TENACITY</div><div class="ride_info_power_value">68</div>
        </div>
        <div class="ride_info_trophy">
            <div class="icon icon__7"></div>
            <div class="icon icon__8"></div>
            <div class="icon icon__9"></div>
        </div>
    </div>
</div>