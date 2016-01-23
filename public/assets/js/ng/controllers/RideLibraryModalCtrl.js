//Modal RideLibrary
app.controller('RideLibraryModalCtrl',function($scope, $http, $modalInstance, $timeout,id,userTooltipService){

    $scope.map = [];
    $scope.mapBox = [];
    $scope.currentPoint = [];
    $scope.currentPointMapBox = [];

    $scope.user_id = id;



    $scope.favoriteTrophies = [
        {},
        {},
        {},
        {},
        {},
        {},
    ]
    $scope.topTrophies = [
        {},
        {},
        {},
    ]


    

    userTooltipService.getTooltip('ride_library_next')==0?$scope.tooltip_shown=false:$scope.tooltip_shown=true;

    $scope.exit_tutorial = function(){
        userTooltipService.saveTooltip('ride_library_next');
        userTooltipService.saveTooltip('ride_library_btn');
        $scope.tooltip_shown=true;
        $modalInstance.close();
        userTooltipService.checkForPopup();
    }

    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    $('#dpd1').datepicker();
    var checkin = $('#dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
        }
        checkin.hide();
        $('#dpd2')[0].focus();
    }).data('datepicker');
    var checkout = $('#dpd2').datepicker({
        onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');


  $scope.search = {};
  $scope.search.user_id = $scope.user_id;

  $scope.close = function(){
    $modalInstance.close();
  }

   //get Files
   $scope.profile_level  = 0;
   $scope.progress_level = 0;
   $scope.season = { progress:0, days:0 };

    $scope.getRides = function(){
        $http.post('/ride',{'user_id':$scope.search.user_id}).
            success(function(data, status, headers, config) {
               $scope.rides            = data.rides;
               $scope.progress_level   = data.progress_level;
               $scope.levels_count     = data.levels_count;
               $scope.season           = data.season;
               $scope.achievements     = data.achievements;
               $scope.profile          = data.profile;
               $scope.nickname         = data.nickname;
               $scope.trophies         = data.trophies;

               $scope.collectionTrophies = data.trophies;
                //set favourites and top
                angular.forEach($scope.collectionTrophies, function(val, key){
                    if ( val.top == 1 ) {

                        var order=val.order;

                        if(order<3){ //if top
                            $scope.topTrophies[order]=val;
                        } else { //if favs
                            $scope.favoriteTrophies[order-3]=val;
                        }
                        $scope.collectionTrophies[key]={};
                    }
                });

               //sort and show top trophies 

               var topTrophArr=[];

               angular.forEach($scope.trophies,function(value, key) {

                    if($scope.trophies[key].top==0){ //remove if not top
                        $scope.trophies.splice(key,1);
                    }

                });

                //sort by order
                $scope.sorterArray = function(item){
                    return item.order;
                }

                $scope.season.percent_round = Math.round($scope.season.progress);
                $scope.profile.level_percent_round = Math.round(parseInt($scope.profile.level,10)/$scope.levels_count*100);
                $scope.achievements.percent_round = Math.round($scope.achievements.progress);
                

            }).
            error(function(data, status, headers, config) {

            });
    }

    $scope.getRides();

    $scope.initSearch = function() {


        $scope.distance_label           = 'GREATER THAN';
        $scope.search.distance_filter   = '>=';

        $scope.avg_power_label          = 'LESS THAN';
        $scope.search.avg_power_filter  = '<=';

        $scope.time_label               = 'EQUAL TO';
        $scope.search.time_filter       = '=';

        $scope.elv_gain_label           = 'LESS THAN';
        $scope.search.elv_gain_filter   = '<=';

        $scope.avg_speed_label           = 'LESS THAN';
        $scope.search.avg_speed_filter   = '<=';

        $scope.effort_lvl_label           = 'GREATER THAN';
        $scope.search.effort_lvl_filter   = '>=';

        $scope.max_speed_label           = 'GREATER THAN';
        $scope.search.max_speed_filter   = '>=';

        $scope.max_power_label           = 'EQUAL TO';
        $scope.search.max_power_filter   = '=';

        $scope.avg_heart_rate_label           = 'LESS THAN';
        $scope.search.avg_heart_rate_filter   = '<=';
    }

    $scope.initSearch();

    $scope.doSearch = function() { //!!!!SEARCH

        $http.post('/ride',$scope.search)
            .success(function(data, status, headers, config){
                $scope.rides = data.rides;
            }).
            error(function(data, status, headers, config){
                return data;
            });

    }

    $scope.selectFilter = function(field, filter, label) {

        if ( field == 'distance' ) {
            $scope.distance_label  = label;
            $scope.search.distance_filter = filter;
        }

        if ( field == 'avg_power' ) {
            $scope.avg_power_label          = label;
            $scope.search.avg_power_filter  = filter;
        }

        if ( field == 'time' ) {
            $scope.time_label          = label;
            $scope.search.time_filter  = filter;
        }

        if ( field == 'elv_gain' ) {
            $scope.elv_gain_label          = label;
            $scope.search.elv_gain_filter  = filter;
        }

        if ( field == 'avg_speed' ) {
            $scope.avg_speed_label          = label;
            $scope.search.avg_speed_filter  = filter;
        }

        if ( field == 'effort_lvl' ) {
            $scope.effort_lvl_label          = label;
            $scope.search.effort_lvl_filter  = filter;
        }

        if ( field == 'max_speed' ) {
            $scope.max_speed_label          = label;
            $scope.search.max_speed_filter  = filter;
        }

        if ( field == 'max_power' ) {
            $scope.max_power_label          = label;
            $scope.search.max_power_filter  = filter;
        }

        if ( field == 'avg_heart_rate' ) {
            $scope.avg_heart_rate_label          = label;
            $scope.search.avg_heart_rate_filter  = filter;
        }

    }
    var  maps = [];

    $scope.rideDetails = function(id) {
        $scope.getMap(id);
        $scope.getChart(id);
    }

    

    $scope.getMap = function(id) {

        //init mapbox
        $scope.mapBox[id] = L.mapbox.map('ride_mapbox_map_'+id, 'fitcraftmaps.bugfd2t9');

        $.post('/ride/map',{id:id},function(response){
            var flightPlanCoordinates = [];

            //draw line mapbox
            var polyline_options = {
                opacity: .9,         
                weight: 4,
                color: '#e84143'
            };
            var polyline = L.polyline(response, polyline_options).addTo($scope.mapBox[id]);
            var boundsMapBox=polyline.getBounds();


            //set start marker
            var markerStart = L.marker([response[0][0], response[0][1]], {
                    icon: L.icon({
                            iconUrl: '/public/assets/img/pin_start.png',
                            iconSize: [25, 38],
                            iconAnchor: [12, 36],
                            popupAnchor: [0, 0]
                        })
                    });
            markerStart.addTo($scope.mapBox[id]);



            //set fin marker
            var markerFin = L.marker([response[response.length - 1][0], response[response.length -1 ][1]], {
                    icon: L.icon({
                            iconUrl: '/public/assets/img/pin_end.png',
                            iconSize: [25, 38],
                            iconAnchor: [12, 36],
                            popupAnchor: [0, 0]
                        })
                    });
            markerFin.addTo($scope.mapBox[id]);



            //add current pin
            $scope.currentPointMapBox[id] = L.marker([response[0][0], response[0][1]], {
                    icon: L.icon({
                            iconUrl: '/public/assets/img/pin_current.png',
                            iconSize: [25, 38],
                            iconAnchor: [12, 36],
                            popupAnchor: [0, 0]
                        })
                    });
            $scope.currentPointMapBox[id].addTo($scope.mapBox[id]);


            //mapbox set bounds
            var southWest = L.point(boundsMapBox._southWest.lat, boundsMapBox._southWest.lng),
                northEast = L.point(boundsMapBox._northEast.lat, boundsMapBox._northEast.lng),
                boundsMB = L.latLngBounds(boundsMapBox);
            $scope.mapBox[id].fitBounds(boundsMB);

            maps[id] = true;

        },'JSON')
    }

    $scope.getChart = function(id) {

        $http.get('/ride/chart/'+id).success(function(data, status, headers, config){
          
            $.each(data.charts,function(index, value) {
               var maxYAxis = 0;
                if ( index == 'speed' ) {
                    maxYAxis = data.max_speed
                } else if ( index == 'elevation') {
                    maxYAxis = data.max_elevation
                } else if ( index == 'heart' ) {
                    maxYAxis = data.max_heart_rate
                } else if ( index == 'power' ) {
                    maxYAxis = data.max_power
                } else if ( index == 'cadence' ) {
                    maxYAxis = data.max_cadence
                }
                $('.chart-'+index+'-'+id).highcharts({
                    chart: {
                        backgroundColor:'#111'
                    },
                    title: '',
                    credits: {
                        enabled: false
                    },
                    rangeSelector : {
                        selected : 1
                    },
                    gridLineWidth: 0,
                    yAxis: {
                        min: 0,
                        max: maxYAxis,
                        //remove grid
                        tickLength: 0,
                        tickWidth: 0,
                        lineWidth:0,
                        gridLineWidth: 0,
                        minorGridLineWidth: 0,
                        gridLineColor: 'transparent',
                        labels: {
                            "enabled": false
                        },
                        title : ''
                    },
                    xAxis: {
                        min: 0,
                        endOnTick: false,
                        max: data.max_distance,
                        // remove grid
                        tickLength: 0,
                        tickWidth: 0,
                        lineWidth:0,
                        gridLineWidth: 0,
                        minorGridLineWidth: 0,
                        gridLineColor: 'transparent',
                        labels: {
                            "enabled": false
                        },
                        title : ''
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            marker: {
                                enabled: false
                            },
                            states: {
                                hover: {
                                    enabled: false
                                }
                            }
                        },
                        area: {
                            stacking: 'normal',
                            lineColor: '#73cf15',
                            fillColor:'#73cf15',
                            lineWidth: 0,
                            marker: {
                                lineWidth: 0
                            }
                        }
                    },
                    tooltip: {
                        positioner: function (labelWidth, labelHeight, point) {
                            var tooltipX, tooltipY;
                            if (point.plotX + labelWidth > this.chart.plotWidth-70) {
                                tooltipX = point.plotX + this.chart.plotLeft - labelWidth - 20;
                            } else {
                                tooltipX = point.plotX + this.chart.plotLeft + 20;
                            }
                            tooltipY = point.plotY + this.chart.plotTop - 20;
                            return {
                                x: tooltipX,
                                y: tooltipY
                            };
                        },                                                         
                        formatter: function () {
                            return '<div class="tooltip"><b>'+this.point.time+'</b><br/><b>' + (this.point.x *   0.000621371192).toFixed(2) + ' MILES </b></div>';
                        },
                        // remove tootip
                        enabled: true,                       
                        crosshairs: {
                            color: 'white',
                            dashStyle: 'solid',
                            zIndex: 999
                        }
                    },
                    series: [{
                        type: 'area',
                        turboThreshold: 0,
                        point: {
                            events: {
                                mouseOver: function () {
                                    // moveMarker($scope.map[id], $scope.currentPoint[id], this.lat, this.lng );
                                    moveMarker($scope.mapBox[id], $scope.currentPointMapBox[id], this.lat, this.lng );

                                    $('.chart-current-bmp-'+id).html(this.bmp);
                                    $('.chart-current-speed-'+id).html(this.speed);
                                    $('.chart-current-elevation-'+id).html(this.elevation);
                                    $('.chart-current-power-'+id).html(this.power);
                                    $('.chart-current-cadence-'+id).html(this.cadence);                                    
                                }
                            }
                        },
                        events: {
                            mouseOut: function () {

                            }
                        },
                        data: value

                    }
                    ]
                });

            });


        }).
        error(function(data, status, headers, config) {

        });



    }
    var styles = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}];

    $scope.doResetAdvanced = function() {

        $scope.max_speed_label          = 'GREATER THAN';
        $scope.search.max_speed_filter  = '>=';
        $scope.search.max_speed         = '';

        $scope.max_power_label           = 'EQUAL TO';
        $scope.search.max_power_filter   = '=';
        $scope.search.max_power          = '';

        $scope.avg_heart_rate_label             = 'LESS THAN';
        $scope.search.avg_heart_rate_filter     = '<=';
        $scope.search.avg_heart_rate            = '';

        $scope.search.date_start    = '';
        $scope.search.date_end      = '';
        $scope.search.ride_name     = '';
        $scope.search.zip_code      = '';

    }

    $scope.athleteCommunication = function(type,uid,rid) {

        var data;

        if(!rid){ //if user
            data={ type: type, user_id: uid};
        } else { //if ride
            data={ type: type, user_id: uid, ride_id:rid};
        }

        $.ajax({
          type: "POST",
          url: "/flag",
          data: data,
          success: function(msg) {
            alert('Thank You for reporting');
          }
        });

    }

    $scope.doReset = function() {

        $scope.distance_label           = 'GREATER THAN';
        $scope.search.distance_filter   = '>=';
        $scope.search.distance          = '';

        $scope.avg_power_label          = 'LESS THAN';
        $scope.search.avg_power_filter  = '<=';
        $scope.search.avg_power         = '';

        $scope.time_label               = 'EQUAL TO';
        $scope.search.time_filter       = '=';
        $scope.search.time              = '';

        $scope.elv_gain_label           = 'LESS THAN';
        $scope.search.elv_gain_filter   = '<=';
        $scope.search.elv_gain          = '';

        $scope.avg_speed_label           = 'LESS THAN';
        $scope.search.avg_speed_filter   = '<=';
        $scope.search.avg_speed          = '';

        $scope.effort_lvl_label           = 'GREATER THAN';
        $scope.search.effort_lvl_filter   = '>=';
        $scope.search.effort_lvl          = '';

        $scope.doSearch();

    }

    $scope.tabs = {
        elevation: [],
        speed:   [],
        heart: [],
        power: []
    }

    $scope.setTab = function(type, id) {
        angular.forEach($scope.tabs,function(value, key) {
            $scope.tabs[key][id] = false;
        })
        $scope.tabs[type][id] = true;
    }

    // FOR USER DETAILS FROM RANKING
    $scope.statistic = {};

    //get Statistics by Days
    $scope.getStatistics = function(filter,label){
        $http.post('/statistics',{'filter':filter,'user_id':$scope.user_id}).
            success(function(data, status, headers, config) {
               $scope.statistic = data;  
               $scope.statistic_label  = label;         
            }).
            error(function(data, status, headers, config) {

            });
    }

    $scope.getStatistics(30,'LAST 30 DAYS');


    $scope.getFooUndef = function(foo){
        return ( foo === undefined );
    }


})

    .directive('onLastRepeat', function() {
        return function(scope, element, attrs) {
            if (scope.$last) setTimeout(function(){
                scope.$emit('onRepeatLast', element, attrs);                                           
                   $('.arrow_detail_ride_time').first().trigger('click');  
                                   
            }, 1);
        };
    });

function moveMarker( map, marker, lat, lng ) {
    // marker.setPosition( new google.maps.LatLng( lat, lng ) );
    // map.panTo( new google.maps.LatLng( lat, lng ) );

    var ll = marker.getLatLng();

      ll.lat = lat;
      ll.lng = lng;
      marker.setLatLng(ll);
};

