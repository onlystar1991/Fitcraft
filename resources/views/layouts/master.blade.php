<!DOCTYPE html>
<html lang="en" ng-app="appBike">
<head ng>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,300,400,600,700' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    {{ HTML::style('assets/css/jquery.jscrollpane.css') }}
    {{ HTML::style('assets/css/bootstrap-progressbar-3.3.0.css') }}
    @yield('css')
    {{ HTML::style('assets/css/default.min.css') }}
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        @media screen and (-webkit-min-device-pixel-ratio:0) {
            .profileSidebar {
                height: 1369px;
            }
           @media only screen
             and (min-width : 1350px) {
               .profileSidebar {
                 height: 1369px;
               }
           }
           @media only screen
                and (min-width : 1920px) {
                  .profileSidebar {
                    height: 1463px;
                  }
            }
            @media only screen
                and (min-width : 2556px) {
                  .profileSidebar {
                    height: 1925px;
                  }
            }
        }
    </style>

</head>

<body>
@include('template.header')




    <div class="container">
        <div class="col-md-2 p-none profile_sidebar__container">
            <div class="profileSidebar">
                <h2 class="category__level"><img src="/assets/img/cat_2_1920.png" alt="" class="img-responsive"/></h2>
                <div class="profile__photo">
                    <img src="/assets/img/profile-1.png" alt="" class="img-responsive"/>
                    <div class="profile__photo__placeholder">
                        <div class="level__label">Level</div>
                        <div class="level__number">{{ $user['level'] }}</div>
                    </div>
                </div>
                <div class="profile__name">
                    SPACEMUNKY
                </div>
                <div class="edit_avatar">
                    <a href="" class="edit_avatar__link" data-toggle="modal" data-target="#avatarModal">EDIT AVATAR</a>
                </div>
                <div class="last_trophy clearfix" >
                    <div class="icon icon__10"></div> <span class="last_trophy__label">TROPHY CASE</span>
                </div>
                <div class="trophy clearfix">
                    @foreach( $trophies as $trophy)
                    <div class="icon icon__{{$trophy}}"></div>
                    @endforeach
                </div>
                <div class="edit_trophy">
                    <a href="" class="edit_trophy__link" data-toggle="modal" data-target="#myModal">EDIT TROPHY CASE</a>
                </div>
                <div class="last_trophy clearfix">
                    <div class="icon icon__20"></div><a href="" data-toggle="modal" data-target="#rideLibraryModal"><span class="last_trophy__label">RIDE LIBRARY</span></a>
                </div>
                <div class="last_trophy clearfix">
                    <div class="icon icon__21"></div><a href="" data-toggle="modal" data-target="#achievementsModal"><span class="last_trophy__label">ACHIEVEMENTS</span></a>
                </div>
                <div class="last_trophy clearfix">
                    <div class="icon icon__22"></div><a href=""><span class="last_trophy__label">RIVALS</span></a>
                </div>
                <div class="last_trophy border-bottom clearfix">
                    <div class="icon icon__14"></div><a href=""><span class="last_trophy__label">TOURNAMENTS</span></a>
                </div>

            </div>

        </div>
        <div class="col-md-7 row-p-5 profile_center__container">
            <div class="rideprofile">ATHLETE PROFILE</div>
            <div class="clearfix">
                <div class="col-md-6 p-none">
                    <div class="profile_rating">
                        <div class="profile_rating__level"></div>
                    </div>
                    <div class="profile_statistics clearfix">
                        <div class="icon icon__level"></div>
                        <div class="pull-left">
                            <div class="profile_statistics__label">LEVEL</div>
                            <div class="meter">
                                <span style="width:{{ $user['level'] }}%"></span> <i>{{ $user['level'] }}</i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-none">
                    <div class="profile_rating">
                        <div class="profile_rating__level"></div>
                    </div>
                    <div class="profile_statistics clearfix">
                        <div class="icon icon__30"></div>
                        <div class="pull-left">
                            <div class="profile_statistics__label">SEASON</div>
                            <div class="meter meter--season">
                                <span style="width:75%"></span> <i>321</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="last30days">
                <div class="clearfix">
                    <div class="p-relative">
                        <div class="last30days__header" data-toggle="dropdown" aria-expanded="false">
                           LAST 30 DAYS <i class="icon__arrow arrow__down"></i>

                        </div>
                        <ul class="dropdown-menu dropdown-last30days dropdown-custom" role="menu">
                           <li><a href="#">TODAY</a></li>
                           <li><a href="#">LAST 7 DAYS</a></li>
                           <li><a href="#">LAST 30 DAYS</a></li>
                           <li><a href="#">LAST 60 DAYS</a></li>
                           <li><a href="#">LAST 90 DAYS</a></li>
                           <li><a href="#">LAST 120 DAYS</a></li>
                           <li><a href="#">LAST 6 MONTHS</a></li>
                           <li><a href="#">LAST YEAR</a></li>
                           <li><a href="#">ALL TIME</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix">
                    <div class="col-md-6 p-none">

                        <div class="profile_statistics clearfix">
                            <div class="icon icon__power"></div>
                            <div class="pull-left">
                                <div class="profile_statistics__label">POWER</div>
                                <div class="meter">
                                    <span class="power" style="width: {{ $user['power'] }}%"></span> <i>{{ $user['power'] }}</i>
                                </div>

                            </div>
                        </div>
                        <div class="profile_statistics clearfix">
                            <div class="icon icon__speed"></div>
                            <div class="pull-left">
                                <div class="profile_statistics__label">SPEED</div>
                                <div class="meter">
                                    <span class="speed" style="width: {{ $user['speed'] }}%"></span> <i>{{ $user['speed'] }}</i>
                                </div>
                            </div>
                        </div>
                        <div class="profile_statistics clearfix">
                            <div class="icon icon__stamina"></div>
                            <div class="pull-left">
                                <div class="profile_statistics__label">DISTANCE</div>
                                <div class="meter">
                                    <span class="stamina" style="width: {{ $user['distance'] }}%"></span> <i>{{ $user['distance'] }}</i>
                                </div>
                            </div>
                        </div>
                        <div class="profile_statistics clearfix">
                            <div class="icon icon__tenacity"></div>
                            <div class="pull-left">
                                <div class="profile_statistics__label">TIME</div>
                                <div class="meter">
                                    <span class="tenacity" style="width: {{ $user['time'] }}%"></span> <i>{{ $user['time'] }}</i>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6 last30days__statistics">
                        <div class="clearfix">
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">TIME</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['time'] }}</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG TIME PER RIDE</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['avg_time_per_ride'] }}</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">TOP SPEED</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['top_speed'] }}</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG SPEED</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['avg_speed'] }}</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG DIST. PER RIDE</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['avg_dist_per_ride'] }}</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">PEAK POWER</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['peak_power'] }}</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG POWER</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['avg_power'] }}</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG CADENCE</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['avg_cadence'] }}</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG HEART RATE</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['avg_heart_rate'] }}</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">CALORIES BURNED</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['calaroies_burned'] }}</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG CALORIES PER RIDE</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['avg_calories_per_ride'] }}</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG EFFORT</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['avg_effort'] }}</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">DAYS RIDDEN</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['days_ridden'] }}</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">TOTAL RIDES</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['total_rides'] }}</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">ELEVATION GAINED</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['elevation_gained'] }}</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">LARGEST CLIMB</div>
                                <div class="last30days__statistics__label_value">{{ $last_info['largest_climb'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="users_rating clearfix">
                <div class="users_rating__header">
                    <div class="filter__header">
                        <div class="p-relative filter__header filter__item avg">
                        <a href="" class="" data-toggle="dropdown" aria-expanded="false">AVG <i class="icon__arrow arrow__down"></i> </a>
                            <ul class="dropdown-menu dropdown-custom" role="menu">
                               <li><a href="#">AVG</a></li>
                               <li><a href="#">MAX</a></li>
                               <li><a href="#">TOTAL</a></li>
                            </ul>
                        </div>
                        <div class="p-relative filter__header filter__item power">
                            <a href="" class="" data-toggle="dropdown" aria-expanded="false">POWER <i class="icon__arrow arrow__down"></i> </a>
                             <ul class="dropdown-menu dropdown-custom" role="menu">
                               <li><a href="#">SPEED</a></li>
                               <li><a href="#">TIME</a></li>
                               <li><a href="#">POWER</a></li>
                               <li><a href="#">DISTANCE</a></li>
                               <li><a href="#">CADENCE</a></li>
                               <li><a href="#">HEART RATE</a></li>
                               <li><a href="#">CALORIES</a></li>
                            </ul>
                        </div>

                        <div class="p-relative filter__header filter__item per_ride">
                            <a href="" class="" data-toggle="dropdown" aria-expanded="false">PER RIDE <i class="icon__arrow arrow__down"></i> </a>
                             <ul class="dropdown-menu dropdown-custom" role="menu">
                               <li><a href="#">PER RIDE</a></li>
                               <li><a href="#">PER WEEK</a></li>
                               <li><a href="#">PER MONTH</a></li>
                               <li><a href="#">PER SEASON</a></li>
                               <li><a href="#">ALL TIME</a></li>
                            </ul>
                        </div>

                        <div class="p-relative filter__header filter__item last_30_days">
                            <a href="" class="" data-toggle="dropdown" aria-expanded="false">LAST 30 DAYS <i class="icon__arrow arrow__down"></i> </a>
                             <ul class="dropdown-menu dropdown-custom" role="menu">
                                  <li><a href="#">TODAY</a></li>
                                  <li><a href="#">LAST 7 DAYS</a></li>
                                  <li><a href="#">LAST 30 DAYS</a></li>
                                  <li><a href="#">LAST 60 DAYS</a></li>
                                  <li><a href="#">LAST 90 DAYS</a></li>
                                  <li><a href="#">LAST 120 DAYS</a></li>
                                  <li><a href="#">LAST 6 MONTHS</a></li>
                                  <li><a href="#">LAST YEAR</a></li>
                                  <li><a href="#">ALL TIME</a></li>
                            </ul>
                        </div>


                    </div>
                    <div class="table__info clearfix">
                        <div class="left_table pt-35">
                            <div class="table__filter">
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false">ANY AGE <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="#">ANY AGE</a></li>
                                          <li><a href="#">MY AGE</a></li>
                                          <li><a href="#">15 & UNDER</a></li>
                                          <li><a href="#">16-20</a></li>
                                          <li><a href="#">21-25</a></li>
                                          <li><a href="#">26-30</a></li>
                                          <li><a href="#">31-35</a></li>
                                          <li><a href="#">36-40</a></li>
                                          <li><a href="#">41-45</a></li>
                                          <li><a href="#">46-50</a></li>
                                          <li><a href="#">51-55</a></li>
                                          <li><a href="#">56-60</a></li>
                                          <li><a href="#">61-65</a></li>
                                          <li><a href="#">66-70</a></li>
                                          <li><a href="#">70 & UP</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false">ANY HEIGHT <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="#">ANY HEIGHT</a></li>
                                          <li><a href="#">MY HEIGHT</a></li>
                                          <li><a href="#">4’ & UNDER</a></li>
                                          <li><a href="#">4’1” - 4’6”</a></li>
                                          <li><a href="#">4’7” - 4’11”</a></li>
                                          <li><a href="#">5’ - 5’3”</a></li>
                                          <li><a href="#">5’4” - 5’7”</a></li>
                                          <li><a href="#">5’8” - 5’11”</a></li>
                                          <li><a href="#">6’ - 6’3”</a></li>
                                          <li><a href="#">6’4” - 6’7”</a></li>
                                          <li><a href="#">6’8” - 7’</a></li>
                                          <li><a href="#">7’ & UP</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false">ANY WEIGHT <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="#">ANY WEIGHT</a></li>
                                          <li><a href="#">MY WEIGHT</a></li>
                                          <li><a href="#">100LBS & UNDER</a></li>
                                          <li><a href="#">100LBS - 110LBS</a></li>
                                          <li><a href="#">111LBS - 120LBS</a></li>
                                          <li><a href="#">121LBS - 130LBS</a></li>
                                          <li><a href="#">131LBS - 140LBS</a></li>
                                          <li><a href="#">131LBS - 140LBS</a></li>
                                          <li><a href="#">131LBS - 140LBS</a></li>
                                          <li><a href="#">141LBS - 150LBS</a></li>
                                          <li><a href="#">151LBS - 160LBS</a></li>
                                          <li><a href="#">161LBS - 170LBS</a></li>
                                          <li><a href="#">171LBS - 180LBS</a></li>
                                          <li><a href="#">181LBS - 190LBS</a></li>
                                          <li><a href="#">191LBS - 200LBS</a></li>
                                          <li><a href="#">201LBS - 210LBS</a></li>
                                          <li><a href="#">211LBS - 220LBS</a></li>
                                          <li><a href="#">221LBS - 230LBS</a></li>
                                          <li><a href="#">231LBS - 240LBS</a></li>
                                          <li><a href="#">241LBS - 250LBS</a></li>
                                          <li><a href="#">250LBS & UP</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false">ANY GENDER <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="#">ANY GENDER</a></li>
                                          <li><a href="#">MALES</a></li>
                                          <li><a href="#">FEMALES</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false">MY ZIPCODE <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="#">EVERYWHERE</a></li>
                                          <li><a href="#">MY ZIP CODE</a></li>
                                          <li><a href="#">MY CITY</a></li>
                                          <li><a href="#">MY STATE</a></li>
                                          <li><a href="#">MY COUNTRY</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false">ANY LEVEL <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="#">ANY LEVEL</a></li>
                                          <li><a href="#">LEVEL 1-10</a></li>
                                          <li><a href="#">LEVEL 11-20</a></li>
                                          <li><a href="#">LEVEL 21-30</a></li>
                                          <li><a href="#">LEVEL 31-40</a></li>
                                          <li><a href="#">LEVEL 41-50</a></li>
                                          <li><a href="#">LEVEL 51-60</a></li>
                                          <li><a href="#">LEVEL 61-70</a></li>
                                          <li><a href="#">LEVEL 71-80</a></li>
                                          <li><a href="#">LEVEL 81-90</a></li>
                                          <li><a href="#">LEVEL 91-100</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                     <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false">ANY CAT <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="#">NO CATEGORY</a></li>
                                          <li><a href="#">CATEGORY 5</a></li>
                                          <li><a href="#">CATEGORY 4</a></li>
                                          <li><a href="#">CATEGORY 3</a></li>
                                          <li><a href="#">CATEGORY 2</a></li>
                                          <li><a href="#">CATEGORY 1</a></li>
                                          <li><a href="#">ELITE</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="right_table">

                                <div class="table__caption">
                                    <div class="caption__item ride__name">RIDER NAME</div>
                                    <div class="caption__item criteria">CRITERIA</div>
                                    <div class="caption__item percentile">PERCENTILE</div>
                                    <div class="caption__item rank">RANK</div>
                                </div>
                              <div class="table__users scroll-pane">
                                  @foreach( $users as $key=>$user )
                                      <div class="table__users__item clearfix {{($key==4) ? 'is-active' : ''}}">
                                        <div class="clearfix table__users_container">
                                          <div class="users_avatar">
                                            <img src="/assets/img/user_1.png" alt="" class="img-responsive"/>
                                          </div>
                                          <div class="users__ridename">{{ $user['name'] }}</div>
                                          <div class="users__criteria">{{ $user['criteria'] }}</div>
                                          <div class="users__percentile">{{ $user['percentile'] }}</div>
                                          <div class="users__rank ">{{ $user['rank'] }}</div>
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
                                  @endforeach
                              </div>
                        </div>



                    </div>

                </div>
            </div>
            <div class="users_rating clearfix table_objectives">
                <div class="users_rating__header">
                    <div class="filter__header text-center filter__header_objectives">OBJECTIVES</div>
                    <div class="clearfix">
                        <div class="left_table">
                            <ul class="objectives_menu">
                                <li class="objectives_li ">
                                    <a href="" class="active">ACTIVE</a>
                                </li>
                                <li class="objectives_li">
                                    <a href="">SPEED</a>
                                </li>
                                <li class="objectives_li">
                                    <a href="">POWER</a>
                                </li>
                                <li class="objectives_li">
                                    <a href="">SPEED</a>
                                </li>
                                <li class="objectives_li">
                                    <a href="">POWER</a>
                                </li>
                                <li class="objectives_li">
                                    <a href="">BONUS</a>
                                </li>
                            </ul>
                        </div>
                        <div class="right_table">
                            <div class="table__caption">
                                <div class="caption__item caption__objective_name">OBJECTIVE NAME</div>
                                <div class="w65 caption__item caption__item_number pull-right">#</div>
                            </div>
                            <div class="table__info clearfix">
                                <div class="table__users scroll-pane">
                                    @foreach( $users as $user )
                                        <div class="table__users__item table__users__item_objectives_item clearfix">
                                            <div class="clearfix">
                                                <div class="icon icon__objective"></div>
                                                <div class="objectives__item">SPEED OBJECTIVE</div>
                                                <div class="objectives__item objectives__item_number">#001</div>
                                            </div>
                                            <div class="clearfix text-center show_description">
                                                <i class="icon__arrow arrow__down objectives_arrow_down"></i>
                                            </div>

                                            <div class="clearfix objectives__info ">
                                                <div class="objectives__description ">RIDE AT LEAST 5MPH FOR A MINIMUM OF             10 MILES IN A SINGLE RIDE.	</div>
                                                <div class="ojbectives__reward">
                                                    <div class="reward__text">
                                                        <div>REWARD:</div>
                                                        <div class="reward__value">
                                                            3<span class="green">XP</span>
                                                        </div>

                                                    </div>
                                                    <div class="reward__icon">
                                                        <div class="icon icon__10 reward__icon_20"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>
        <div class="col-md-3 row-p-2 recent__activities">
            <div class="recent_activities">
                ACTIVITY FEED
            </div>
            <div class="recent_activities__filter">
                <a href="">ALL <i class="icon__arrow arrow__down"></i></a>
            </div>
            <div class="scroll-pane activities_feed_scroll">
                <div class="clearfix activities_feed">
                    @for ($i =1; $i<11; $i++)
                    <div class="clearfix  user_feed">
                        <div class="recent_feed_user clearfix ">
                            <div class="recent_feed_user_avatar pull-left">
                                <img src="/assets/img/user_1.png" alt="" class="img-responsive"/>
                            </div>
                            <div class="recent_feed_user_name pull-left {{($i==2) ? 'green' :''}}">
                                {{($i==2) ? 'YOUR NAME' : 'RIDER NAME'}}
                            </div>
                            <div class="recent_feed_user_date pull-left {{($i==2) ? 'green' :''}}">
                                DATE
                            </div>
                            <i class="icon__arrow arrow__down users__arrow_down feed_user_show_details"></i>
                        </div>
                        <div class="recent_feeed_user_info">
                            <div class="feed_user_info_item clearfix">
                                <div class="feed_user_info_label pull-left">
                                    <div>TIME</div>
                                    <div>DISTANCE</div>
                                    <div>AVG SPEED</div>
                                    <div>EFFORT</div>
                                </div>
                                <div class="feed_user_info_value pull-left">
                                    <div>54:21</div>
                                    <div>16.2 MI</div>
                                    <div>15.2 MPH</div>
                                    <div>103%</div>
                                </div>
                                <div class="feed_user_info_xp pull-left">
                                    <div class="feed_user_info_xp_value">100<span class="green">XP</span></div>
                                    <div class="feed_user_info_xp_label">EARNED</div>
                                </div>
                                <div class="pull-left">
                                    <div class="icon icon__20"></div>
                                </div>
                            </div>

                            <div class="feed_user_info_item clearfix">
                                <div class="feed_user_info_text pull-left">
                                    RIDER NAME HAS EARNED THE ACHIEVEMENT <span class="orange">BETTER LATE THAN NEVER</span>
                                </div>
                                <div class="feed_user_info_xp pull-left">
                                    <div class="feed_user_info_xp_value">100<span class="orange">AP</span></div>
                                    <div class="feed_user_info_xp_label">EARNED</div>
                                </div>
                                <div class="pull-left">
                                    <div class="icon icon__21"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix  user_feed">
                        <div class="recent_feed_user clearfix">
                            <div class="recent_feed_user_avatar pull-left">
                                <img src="/assets/img/user_1.png" alt="" class="img-responsive"/>
                            </div>
                            <div class="recent_feed_user_name pull-left">
                                RIDER NAME
                            </div>
                            <div class="recent_feed_user_date pull-left">
                                DATE
                            </div>
                            <i class="icon__arrow arrow__down users__arrow_down feed_user_show_details"></i>
                        </div>
                        <div class="recent_feeed_user_info">
                            <div class="feed_user_info_item clearfix">
                                <div class="feed_user_info_label pull-left">
                                    <div>TIME</div>
                                    <div>DISTANCE</div>
                                    <div>AVG SPEED</div>
                                    <div>EFFORT</div>
                                </div>
                                <div class="feed_user_info_value pull-left">
                                    <div>54:21</div>
                                    <div>16.2 MI</div>
                                    <div>15.2 MPH</div>
                                    <div>103%</div>
                                </div>
                                <div class="feed_user_info_xp pull-left">
                                    <div class="feed_user_info_xp_value">100<span class="green">XP</span></div>
                                    <div class="feed_user_info_xp_label">EARNED</div>
                                </div>
                                <div class="pull-left">
                                    <div class="icon icon__20"></div>
                                </div>
                            </div>

                            <div class="feed_user_info_item clearfix">
                                <div class="feed_user_info_text pull-left">
                                    RIDER NAME HAS EARNED <span class="green">LEVEL 85</span>
                                </div>
                                <div class="feed_user_info_xp pull-left">
                                    <div class="feed_user_info_xp_value"><span class="green">LVL</span>85</div>
                                    <div class="feed_user_info_xp_label">EARNED</div>
                                </div>
                                <div class="pull-left">
                                    <div class="icon icon__level"></div>
                                </div>
                            </div>
                            <div class="feed_user_info_item clearfix">
                                <div class="feed_user_info_text pull-left">
                                    RIDER NAME HAS EARNED THE AVATAR <span class="yellow">TRACK DEMON</span>
                                </div>
                                <div class="feed_user_info_xp pull-left">
                                    <div class="feed_user_info_xp_value"><span class="yellow">AVATAR</span></div>
                                    <div class="feed_user_info_xp_label">EARNED</div>
                                </div>
                                <div class="pull-left  recent_feed_user_avatar recent_feed_user_avatar__select">
                                    <img src="/assets/img/user_1.png" alt="" class="img-responsive"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix  user_feed">
                        <div class="recent_feed_user clearfix">
                            <div class="icon icon__14 pull-left">

                            </div>
                            <div class="recent_feed_user_name pull-left">
                                NEW TOURNAMENT IS AVAILABLE
                            </div>
                        </div>
                    </div>
                    <div class="clearfix  user_feed">
                        <div class="recent_feed_user clearfix">
                            <div class="icon icon__objective pull-left">

                            </div>
                            <div class="recent_feed_user_name pull-left">
                                NEW OBJECTIVE IS AVAILABLE
                            </div>
                        </div>
                    </div>
                    <div class="clearfix  user_feed">
                                            <div class="recent_feed_user clearfix">
                                                <div class="recent_feed_user_avatar pull-left">
                                                    <img src="/assets/img/user_1.png" alt="" class="img-responsive"/>
                                                </div>
                                                <div class="recent_feed_user_name pull-left">
                                                    RIDER NAME
                                                </div>
                                                <div class="recent_feed_user_date pull-left">
                                                    DATE
                                                </div>
                                                <i class="icon__arrow arrow__down users__arrow_down feed_user_show_details"></i>
                                            </div>
                                            <div class="recent_feeed_user_info">
                                                <div class="feed_user_info_item clearfix">
                                                    <div class="feed_user_info_label pull-left">
                                                        <div>TIME</div>
                                                        <div>DISTANCE</div>
                                                        <div>AVG SPEED</div>
                                                        <div>EFFORT</div>
                                                    </div>
                                                    <div class="feed_user_info_value pull-left">
                                                        <div>54:21</div>
                                                        <div>16.2 MI</div>
                                                        <div>15.2 MPH</div>
                                                        <div>103%</div>
                                                    </div>
                                                    <div class="feed_user_info_xp pull-left">
                                                        <div class="feed_user_info_xp_value">100<span class="green">XP</span></div>
                                                        <div class="feed_user_info_xp_label">EARNED</div>
                                                    </div>
                                                    <div class="pull-left">
                                                        <div class="icon icon__20"></div>
                                                    </div>
                                                </div>

                                                <div class="feed_user_info_item clearfix">
                                                    <div class="feed_user_info_text pull-left">
                                                        RIDER NAME HAS EARNED <span class="green">LEVEL 85</span>
                                                    </div>
                                                    <div class="feed_user_info_xp pull-left">
                                                        <div class="feed_user_info_xp_value"><span class="green">LVL</span>85</div>
                                                        <div class="feed_user_info_xp_label">EARNED</div>
                                                    </div>
                                                    <div class="pull-left">
                                                        <div class="icon icon__level"></div>
                                                    </div>
                                                </div>
                                                <div class="feed_user_info_item clearfix">
                                                    <div class="feed_user_info_text pull-left">
                                                        RIDER NAME HAS EARNED  A <span class="orange_light">TROPHY</span>
                                                    </div>
                                                    <div class="feed_user_info_xp pull-left">
                                                        <div class="feed_user_info_xp_value"><span class="orange_light">TROPHY</span></div>
                                                        <div class="feed_user_info_xp_label">EARNED</div>
                                                    </div>
                                                    <div class="pull-left  recent_feed_user_avatar recent_feed_user_avatar__select">
                                                        <img src="/assets/img/user_1.png" alt="" class="img-responsive"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    <div class="clearfix  user_feed">
                        <div class="recent_feed_user clearfix">
                            <div class="icon icon__22 pull-left">

                            </div>
                            <div class="recent_feed_user_name pull-left">
                                NEW RIVAL IS AVAILABLE
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>

            </div>

        </div>
    </div>





    <div class="footer">
        <div class="footer_in">
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
{{ HTML::script('assets/js/lib/jquery.jscrollpane.min.js') }}
{{ HTML::script('assets/js/lib/jquery.mousewheel.js') }}
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
@yield('js')
{{ HTML::script('assets/js/ng/module/ui-bootstrap-tpls-0.12.1.min.js') }}
{{ HTML::script('assets/js/ng/app.js') }}
{{ HTML::script('assets/js/custom.js') }}

</body>
</html>
