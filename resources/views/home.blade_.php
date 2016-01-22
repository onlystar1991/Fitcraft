<!DOCTYPE html>
<html lang="en" ng-app="appBike">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,300,400,600,700' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    {!! HTML::style('assets/css/jquery.jscrollpane.css') !!}
    {!! HTML::style('assets/css/bootstrap-progressbar-3.3.0.css') !!}
    @yield('css')
    {!! HTML::style('assets/css/perfect-scrollbar.min.css') !!}
    {!! HTML::style('assets/css/default.min.css') !!}
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
        input.ng-invalid {
          color: red;
          border: 1px red solid;
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
                    <div class="level__number">{{ $profile->level }}</div>
                </div>
            </div>
            <div class="profile__name">
                SPACEMUNKY
            </div>
            <div class="edit_avatar" ng-controller="ModalCtrl">
                <button class="btn btn-bk btn-green" ng-click="avatar()">PLAYER CARD</button>
            </div>
            <div class="last_trophy clearfix p-relative" >
                <div class="icon icon__10"></div>
                <span class="last_trophy__label">TROPHY CASE</span>
                <div class="icon__arrow arrow__down toggle-trophy-case" ng-class="{arrow__up:!trophy.toggle}" ng-click="trophy.toggle = !trophy.toggle"></div>
            </div>

            <div class="clearfix"  ng-hide="trophy.toggle">
                <div class="trophy clearfix" >
                    {{--@foreach( $trophies as $trophy)--}}
                    {{--<div class="icon icon__{{$trophy}}"></div>--}}
                    {{--@endforeach--}}
                </div>
                <div class="edit_trophy" ng-controller="ModalCtrl">
                    <button class="btn btn-bk btn-green" ng-click="trophy()">TROPHY CASE</button>
                </div>
            </div>
            <div class="last_trophy clearfix" ng-controller="ModalCtrl" >
                <div class="icon icon__20"></div><a href="" ng-click="ridelibrary()" ><span class="last_trophy__label">RIDE LIBRARY</span></a>
            </div>
            <div class="last_trophy clearfix" ng-controller="ModalCtrl" >
                <div class="icon icon__21"></div><a href="" ng-click="achievements()" ><span class="last_trophy__label">ACHIEVEMENTS</span></a>
            </div>
            <div class="last_trophy clearfix">
                <div class="icon icon__22"></div><a href=""><span class="last_trophy__label">RIVALS</span></a>
            </div>
            <div class="last_trophy border-bottom clearfix">
                <div class="icon icon__14"></div><a href=""><span class="last_trophy__label">TOURNAMENTS</span></a>
            </div>
            <div class="last_trophy border-bottom clearfix" ng-controller="ModalCtrl" >
                <div class="icon icon__objective"></div><a href="" ng-click="objectives()" ><span class="last_trophy__label">OBJECTIVES</span></a>
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
                    <div class="profile_statistics clearfix" ng-controller="LevelCtrl">
                        <div class="icon icon__level"></div>
                        <div class="pull-left">
                            <div class="profile_statistics__label">LEVEL</div>
                            <div class="meter">
                                <span ng-style="{ 'width' : progress + '%'  }" ></span> <i ng-init="level={{ $profile->level }}; progress={{ $progress_level }}" ng-bind="level">{{ $profile->level }}</i>
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
                                <span style="width:{{ $season['progress'] }}%"></span> <i>{{ $season['days'] }}</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="last30days" ng-controller="StatisticsCtrl"  >
                <div class="clearfix">
                    <div class="p-relative" >
                        <div class="last30days__header" data-toggle="dropdown" aria-expanded="false">
                           <% statistic_label %> <i class="icon__arrow arrow__down"></i>
                        </div>
                        <!-- <perfect-scrollbar class="scroller " wheel-propagation="true" wheel-speed="10" min-scrollbar-length="20"> -->
                            <ul class="dropdown-menu dropdown-last30days dropdown-custom" role="menu">
                               <li><a href="javascript:void(0)"  ng-click="getStatistics('0','TODAY')" >TODAY</a></li>
                               <li><a href="javascript:void(0)"  ng-click="getStatistics('7','LAST 7 DAYS')" >LAST 7 DAYS</a></li>
                               <li><a href="javascript:void(0)"  ng-click="getStatistics('30','LAST 30 DAYS')" >LAST 30 DAYS</a></li>
                               <li><a href="javascript:void(0)"  ng-click="getStatistics('60','LAST 60 DAYS')" >LAST 60 DAYS</a></li>
                               <li><a href="javascript:void(0)"  ng-click="getStatistics('90','LAST 90 DAYS')" >LAST 90 DAYS</a></li>
                               <li><a href="javascript:void(0)"  ng-click="getStatistics('120','LAST 120 DAYS')" >LAST 120 DAYS</a></li>
                               <li><a href="javascript:void(0)"  ng-click="getStatistics('180','LAST 6 MONTHS')" >LAST 6 MONTHS</a></li>
                               <li><a href="javascript:void(0)"  ng-click="getStatistics('360','LAST YEAR')" >LAST YEAR</a></li>
                               <li><a href="javascript:void(0)"  ng-click="getStatistics('all','ALL TIME')" >ALL TIME</a></li>
                            </ul>
                        <!-- </perfect-scrollbar> -->
                    </div>
                </div>
                <div class="clearfix">
                    <div class="col-md-6 p-none">

                        <div class="profile_statistics clearfix">
                            <div class="icon icon__power"></div>
                            <div class="pull-left">
                                <div class="profile_statistics__label">POWER</div>
                                <div class="meter">
                                    <span class="power" ng-style="{ 'width' : statistic.power_percent + '%'  }" ></span> <i ng-bind="statistic.power_percent" ></i>
                                </div>

                            </div>
                        </div>
                        <div class="profile_statistics clearfix">
                            <div class="icon icon__speed"></div>
                            <div class="pull-left">
                                <div class="profile_statistics__label">SPEED</div>
                                <div class="meter">
                                    <span class="speed"  ng-style="{ 'width' : statistic.speed_percent + '%'  }"></span> <i ng-bind="statistic.speed_percent"></i>
                                </div>
                            </div>  
                        </div>
                        <div class="profile_statistics clearfix">
                            <div class="icon icon__stamina"></div>
                            <div class="pull-left">
                                <div class="profile_statistics__label">STAMINA</div>
                                <div class="meter">
                                    <span class="stamina"  ng-style="{ 'width' : statistic.stamina_percent + '%'  }"></span> <i ng-bind="statistic.stamina_percent"></i>
                                </div>
                            </div>
                        </div>
                        <div class="profile_statistics clearfix">
                            <div class="icon icon__tenacity"></div>
                            <div class="pull-left">
                                <div class="profile_statistics__label">TENACITY</div>
                                <div class="meter">
                                    <span class="tenacity"  ng-style="{ 'width' : statistic.tenacity_percent + '%'  }" ></span> <i ng-bind="statistic.tenacity_percent"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 last30days__statistics">
                        <div class="clearfix">
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key" >TIME</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.time" >0</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG TIME PER RIDE</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.avg_time_per_ride" >0</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">TOP SPEED</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.top_speed" >0</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG SPEED</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.avg_speed" >0</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG DIST. PER RIDE</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.avg_dist_per_ride" >0</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">PEAK POWER</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.peak_power" >0</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG POWER</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.avg_power" >0</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG CADENCE</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.avg_cadence" >0</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG HEART RATE</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.avg_heart_rate" >0</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">CALORIES BURNED</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.calories_burned" >0</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG CALORIES PER RIDE</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.avg_calories_per_ride" >0</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">AVG EFFORT</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.avg_effort" >0</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">DAYS RIDDEN</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.days_ridden" >0</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">TOTAL RIDES</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.total_rides" >0</div>
                            </div>
                             <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">ELEVATION GAINED</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.elev_gained" >0</div>
                            </div>
                            <div class="last30days__statistics__label">
                                <div class="last30days__statistics__label_key">LARGEST CLIMB</div>
                                <div class="last30days__statistics__label_value" ng-bind="statistic.largest_climb" >0</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

             <div class="block-header">RANKINGS</div>
            <div class="users_rating clearfix" ng-controller="RankingsCtrl">

                <div class="users_rating__header">
                    <div class="filter__header">
                        <div class="p-relative filter__header filter__item avg">
                        <a href="" class="" data-toggle="dropdown" aria-expanded="false"><% ranking_avg_max_label %><i class="icon__arrow arrow__down"></i> </a>
                            <ul class="dropdown-menu dropdown-custom" role="menu">
                               <li><a href="javascript:void(0)" ng-click="selectFilter('ride','AVG','avg_max')" >AVG</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('max','MAX','avg_max')" >MAX</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('','TOTAL','avg_max')" >TOTAL</a></li>
                            </ul>
                        </div>
                        <div class="p-relative filter__header filter__item power">
                            <a href="" class="" data-toggle="dropdown" aria-expanded="false"><% ranking_avg_max_with_label %> <i class="icon__arrow arrow__down"></i> </a>
                             <ul class="dropdown-menu dropdown-custom" role="menu">
                               <li><a href="javascript:void(0)" ng-click="selectFilter('speed','SPEED','avg_max_with')" >SPEED</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('time','TIME','avg_max_with')" >TIME</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('power','POWER','avg_max_with')" >POWER</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('distance','DISTANCE','avg_max_with')" >DISTANCE</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('cadence','CADENCE','avg_max_with')" >CADENCE</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('heart_rate','HEART RATE','avg_max_with')" >HEART RATE</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('calories','CALORIES','avg_max_with')" >CALORIES</a></li>
                            </ul>
                        </div>
                        <div class="p-relative filter__header filter__item per_ride">
                            <a href="" class="" data-toggle="dropdown" aria-expanded="false"><span ng-bind="ranking_interval_label"><i class="icon__arrow arrow__down"></i> </a>
                             <ul class="dropdown-menu dropdown-custom" role="menu">
                               <li><a href="javascript:void(0)" ng-click="selectFilter('ride','PER RIDE','interval')"  >PER RIDE</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('week','PER WEEK','interval')" >PER WEEK</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('month','PER MONTH','interval')" >PER MONTH</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('season','PER SEASON','interval')" >PER SEASON</a></li>
                               <li><a href="javascript:void(0)" ng-click="selectFilter('','ALL TIME','interval')" >ALL TIME</a></li>
                            </ul>
                        </div>

                        <div class="p-relative filter__header filter__item last_30_days">
                            <a href="" class="" data-toggle="dropdown" aria-expanded="false"><% ranking_days_label %> <i class="icon__arrow arrow__down"></i> </a>
                             <ul class="dropdown-menu dropdown-custom" role="menu" >
                               <li><a href="javascript:void(0)" ng-hide="days.last1days"  ng-click="selectFilter('1','TODAY','days')" >TODAY</a></li>
                               <li><a href="javascript:void(0)" ng-hide="days.last7days" ng-click="selectFilter('7','LAST 7 DAYS','days')" >LAST 7 DAYS</a></li>
                               <li><a href="javascript:void0)" ng-hide="days.last30days"  ng-click="selectFilter('30','LAST 30 DAYS','days')" >LAST 30 DAYS</a></li>
                               <li><a href="javascript:void0)" ng-hide="days.last60days"  ng-click="selectFilter('60','LAST 60 DAYS','days')" >LAST 60 DAYS</a></li>
                               <li><a href="javascript:void0)" ng-hide="days.last90days"  ng-click="selectFilter('90','LAST 90 DAYS','days')" >LAST 90 DAYS</a></li>
                               <li><a href="javascript:void0)" ng-hide="days.last120days"  ng-click="selectFilter('120','LAST 120 DAYS','days')" >LAST 120 DAYS</a></li>
                               <li><a href="javascript:void0)" ng-hide="days.last180days"  ng-click="selectFilter('180','LAST 6 MONTHS','days')" >LAST 6 MONTHS</a></li>
                               <li><a href="javascript:void0)" ng-hide="days.last360days"  ng-click="selectFilter('360','LAST YEAR','days')" >LAST YEAR</a></li>
                               <li><a href="javascript:void0)" ng-hide="days.lastalldays"  ng-click="selectFilter('all','ALL TIME','days')" >ALL TIME</a></li>
                            </ul>
                        </div>


                    </div>
                    <div class="table__info clearfix">
                        <div class="left_table pt-35">
                            <div class="table__filter">
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false"><% ranking_age_label %> <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('','ANY AGE','age')" >ANY AGE</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('1','MY AGE','age')" >MY AGE</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('2','15 & UNDER','age')" >15 & UNDER</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('16-20','16-20','age')" >16-20</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('21-25','21-25','age')" >21-25</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('26-30','26-30','age')" >26-30</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('31-35','31-35','age')" >31-35</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('36-40','36-40','age')" >36-40</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('41-45','41-45','age')" >41-45</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('46-50','46-50','age')" >46-50</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('51-55','51-55','age')" >51-55</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('56-60','56-60','age')" >56-60</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('61-65','61-65','age')" >61-65</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('66-70','66-70','age')" >66-70</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('14','70 & UP','age')" >70 & UP</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false"><% ranking_height_label %> <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('','ANY HEIGHT','height')" >ANY HEIGHT</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('1','MY HEIGHT','height')" >MY HEIGHT</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('2','4’ & UNDER','height')" >4’ & UNDER</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('3','4’1” - 4’6”','height')" >4’1” - 4’6”</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('4','4’7” - 4’11”','height')" >4’7” - 4’11”</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('5','5’ - 5’3”','height')" >5’ - 5’3”</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('6','5’4” - 5’7”','height')" >5’4” - 5’7”</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('7','5’8” - 5’11”','height')" >5’8” - 5’11”</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('8','6’ - 6’3”','height')" >6’ - 6’3”</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('9','6’4” - 6’7”','height')" >6’4” - 6’7”</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('10','6’8” - 7’','height')" >6’8” - 7’</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('11','7’ & UP','height')" >7’ & UP</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false"><% ranking_weight_label %> <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('','ANY WEIGHT','weight')" >ANY WEIGHT</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('1','MY WEIGHT','weight')" >MY WEIGHT</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('2','100LBS & UNDER','weight')" >100LBS & UNDER</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('100-110','100LBS - 110LBS','weight')" >100LBS - 110LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('111-120','111LBS - 120LBS','weight')" >111LBS - 120LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('121-130','121LBS - 130LBS','weight')" >121LBS - 130LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('131-140','131LBS - 140LBS','weight')" >131LBS - 140LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('141-150','141LBS - 150LBS','weight')" >141LBS - 150LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('151-170','151LBS - 160LBS','weight')" >151LBS - 160LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('161-180','161LBS - 170LBS','weight')" >161LBS - 170LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('181-190','171LBS - 180LBS','weight')" >171LBS - 180LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('181-200','181LBS - 190LBS','weight')" >181LBS - 190LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('191-200','191LBS - 200LBS','weight')" >191LBS - 200LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('201-210','201LBS - 210LBS','weight')" >201LBS - 210LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('211-220','211LBS - 220LBS','weight')" >211LBS - 220LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('221-230','221LBS - 230LBS','weight')" >221LBS - 230LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('231-240','231LBS - 240LBS','weight')" >231LBS - 240LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('241-250','241LBS - 250LBS','weight')" >241LBS - 250LBS</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('3','250LBS & UP','weight')" >250LBS & UP</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false"><% ranking_gender_label %> <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('','ANY GENDER','gender')" >ANY GENDER</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('m','MALES','gender')" >MALES</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('f','FEMALES','gender')" >FEMALES</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false"><% ranking_zip_label %> <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('','EVERYWHERE','zip')" >EVERYWHERE</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('zip','MY ZIP CODE','zip')" >MY ZIP CODE</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('city','MY CITY','zip')" >MY CITY</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('state','MY STATE','zip')" >MY STATE</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('country','MY COUNTRY','zip')" >MY COUNTRY</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                    <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false"><% ranking_level_label %> <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('','ANY LEVEL','level')" >ANY LEVEL</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('1-10','LEVEL 1-10','level')" >LEVEL 1-10</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('11-20','LEVEL 11-20','level')" >LEVEL 11-20</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('21-30','LEVEL 21-30','level')" >LEVEL 21-30</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('31-40','LEVEL 31-40','level')" >LEVEL 31-40</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('41-50','LEVEL 41-50','level')" >LEVEL 41-50</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('51-60','LEVEL 51-60','level')" >LEVEL 51-60</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('61-70','LEVEL 61-7','level')" >LEVEL 61-70</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('71-80','LEVEL 71-80','level')" >LEVEL 71-80</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('81-90','LEVEL 81-90','level')" >LEVEL 81-90</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('91-100','LEVEL 91-100','level')" >LEVEL 91-100</a></li>
                                    </ul>
                                </div>
                                <div class="p-relative table__filter__item">
                                     <a href="" class="table__filter__item" data-toggle="dropdown" aria-expanded="false"><% ranking_cat_label %> <i class="icon__arrow arrow__down"></i></a>
                                     <ul class="dropdown-menu dropdown-custom" role="menu">
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('','ANY CAT','cat')" >ANY CAT</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('1','CATEGORY 5','cat')" >CATEGORY 5</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('2','CATEGORY 4','cat')" >CATEGORY 4</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('3','CATEGORY 3','cat')" >CATEGORY 3</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('4','CATEGORY 2','cat')" >CATEGORY 2</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('5','CATEGORY 1','cat')" >CATEGORY 1</a></li>
                                          <li><a href="javascript:void(0)" ng-click="selectFilter('6','ELITE','cat')" >ELITE</a></li>
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
                                  <div class="clearfix"  ng-repeat="(key, ranking) in rankings" >
                                    <?php $key = 0; ?>
                                    <div ng-class="{isactive:ranking.id == 51}" class="table__users__item clearfix">
                                        <div class="clearfix table__users_container">
                                            <div class="users_avatar"  ng-click="showDetails({{$key}})">
                                                <img src="/assets/img/user_1.png" alt="" class="img-responsive"/>
                                            </div>
                                            <div class="users__ridename"  ng-click="showDetails({{$key}})"><span ng-bind="ranking.name"></span></div>
                                            <div class="users__criteria"  ng-click="showDetails({{$key}})"><span ng-bind="ranking.criteria"></span></div>
                                            <div class="users__percentile"  ng-click="showDetails({{$key}})"><span ng-bind="ranking.percentile"></span></div>
                                            <div class="users__rank "  ng-click="showDetails({{$key}})"><% ranking.id %></div>
                                        </div>
                                        <div class="clearfix text-center ride_description">
                                            <i class="icon__arrow arrow__down users__arrow_down"></i>
                                        </div>
                                        <div class="clearfix ride_info">
                                            <div class="ride_info_level">
                                                <div class="ride_info_level_label">LEVEL</div>
                                                <div class="ride_info_level_number"><span ng-bind="ranking.level"></span></div>
                                            </div>
                                            <div class="ride_info_category">
                                                <div class="ride_info_category_label">CATEGORY</div>
                                                <div class="ride_info_category_number"><span ng-bind="ranking.cartegory"></span></div>
                                            </div>
                                            <div class="ride_info_power">
                                                <div class="ride_info_power_label">POWER</div><div class="ride_info_power_value"><span ng-bind="ranking.power"></span></div>
                                                <div class="ride_info_power_label">SPEED</div><div class="ride_info_power_value"><span ng-bind="ranking.speed"></span></div>
                                                <div class="ride_info_power_label">STAMINA </div><div class="ride_info_power_value"><span ng-bind="ranking.stamina"></span></div>
                                                <div class="ride_info_power_label">TENACITY</div><div class="ride_info_power_value"><span ng-bind="ranking.tenacity"></span></div>
                                            </div>
                                            <div class="ride_info_trophy">
                                                <div class="icon icon__7"></div>
                                                <div class="icon icon__8"></div>
                                                <div class="icon icon__9"></div>
                                            </div>
                                        </div>
                                    </div>
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
                </div>

            </div>

        </div>
    </div>


    <div class="footer">
        <div class="footer_in">
        </div>
    </div>
    <div class="modal fade" id="ajaxModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="icon__modal_close" data-dismiss="modal" aria-label="Close"></button>
            <h4 class="modal-title" id="myModalLabel"></h4>
          </div>
          <div class="modal-body  clearfix ">

          </div>
        </div>
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<!-- Tmp  -->
{!! HTML::script('assets/js/lib/jquery.jscrollpane.min.js') !!}
{!! HTML::script('assets/js/lib/jquery.mousewheel.js') !!}
<!-- TMP -->


<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
{!! HTML::script('assets/js/lib/upload/vendor/jquery.ui.widget.js') !!}
{!! HTML::script('assets/js/lib/upload/jquery.iframe-transport.js') !!}
{!! HTML::script('assets/js/lib/upload/jquery.fileupload.js') !!}
{!! HTML::script('assets/js/lib/bootstrap-datepicker.js') !!}

<script src="http://code.highcharts.com/highcharts.js"></script>



@yield('js')

{!! HTML::script('assets/js/ng/module/ui-bootstrap-tpls-0.12.1.min.js') !!}
{!! HTML::script('assets/js/ng/module/perfect-scrollbar.with-mousewheel.min.js') !!}
{!! HTML::script('assets/js/ng/module/angular-perfect-scrollbar.js') !!}
{!! HTML::script('assets/js/ng/module/ngMask.min.js') !!}
{!! HTML::script('assets/js/ng/module/wizValidation.js') !!}
{!! HTML::script('assets/js/ng/module/angular-dragdrop.js') !!}

{!! HTML::script('assets/js/ng/app.js') !!}

{!! HTML::script('assets/js/ng/controllers/ModalCtrl.js') !!}
{!! HTML::script('assets/js/ng/controllers/AccountModalCtrl.js') !!}

{!! HTML::script('assets/js/ng/controllers/UploadModalCtrl.js') !!}
{!! HTML::script('assets/js/ng/controllers/ObjectivesModalCtrl.js') !!}
{!! HTML::script('assets/js/ng/controllers/AchievementsModalCtrl.js') !!}
{!! HTML::script('assets/js/ng/controllers/RideLibraryModalCtrl.js') !!}
{!! HTML::script('assets/js/ng/controllers/StatisticsCtrl.js') !!}
{!! HTML::script('assets/js/ng/controllers/RankingsCtrl.js') !!}
{!! HTML::script('assets/js/ng/controllers/AvatarModalCtrl.js') !!}

{!! HTML::script('assets/js/custom.js') !!}
<script>

@if ( Session::get('stravaLogin') )
    $(function(){
        $('.account__menu_upload').trigger('click');
        $('[data-select-tab=tab-strava]').trigger('click');
    })
@endif

</script>

</body>
</html>
