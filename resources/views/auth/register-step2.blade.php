<!DOCTYPE html>
<html lang="en" ng-app="appBike">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,300,400,600,700' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
       @yield('css')
    {!! HTML::style('assets/css/default.min.css') !!}
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

@if ( !Auth::client()->check() )
    <div class="register-modal clearfix">
    <div class="register-modal__header">
    </div>
    <div class="register-container text-center">
        
        <div class="clearfix">        	
            <div class="register-modal__steps">
                <div class="header-steps ">
                    <h1>STEP 2: ATHLETE INFO</h1>
                </div>
            </div>            
            <div class="register-from-area">        
                <div class="text-center register-form register-form--step2">
                    {!! Form::open() !!}

                        <div class="clearfix row-item row-item--register-modal">
                            <div class="pull-left label-register">HEIGHT</div>
                            <div class="row-item__content row-item__content--register-modal pull-left">
                                <div class="pull-left">
                                    <input type="text" class="form-control form-input form-input--height-ft-inc ng-pristine ng-untouched ng-valid" mask="9" ng-model="user.height_ft" name="" ng-disabled="disabled.height" ng-hide="!showImperial" >
                                </div>
                                <div class="pull-left row-item__content-text row-item__content-text-ft ng-binding">FT <i class="icon__arrow icon__arrow--top-4 arrow__down" ng-click="unitsShow(true)"></i></div>

                                <div class="pull-left">
                                    <input type="text" class="form-control form-input form-input--height-ft-inc ng-pristine ng-untouched ng-valid" mask="99?" ng-model="user.height_inc" ng-disabled="disabled.height" ng-hide="!showImperial" >
                                </div>
                                <div class="pull-left row-item__content-text ng-binding">INCH<i class="icon__arrow icon__arrow--top-4 arrow__down" ng-click="unitsShow(true)"></i></div>
                            </div>
                        </div>
                        <div class="clearfix row-item row-item--register-modal">
                            <div class="pull-left label-register">WEIGHT</div>
                            <div class="row-item__content row-item__content--register-modal pull-left">
                                <div class="pull-left">
                                    <input type="text" class="form-control form-input form-input--height-ft-inc ng-pristine ng-untouched ng-valid" mask="9" ng-model="user.height_ft" name="" ng-disabled="disabled.height" ng-hide="!showImperial" >
                                </div>
                                <div class="pull-left row-item__content-text row-item__content-text-ft ng-binding">LBS <i class="icon__arrow icon__arrow--top-4 arrow__down" ng-click="unitsShow(true)"></i></div>
                            </div>
                        </div>
                        <div class="clearfix row-item row-item--register-modal">
                            <div class="pull-left label-register">BODY FAT %</div>
                            <div class="row-item__content row-item__content--register-modal pull-left">
                                <div class="pull-left">
                                    <input type="text" class="form-control form-input form-input--height-ft-inc ng-pristine ng-untouched ng-valid" mask="9" ng-model="user.height_ft" name="" ng-disabled="disabled.height" ng-hide="!showImperial" >
                                </div>
                                <div class="pull-left row-item__content-text row-item__content-text-ft ng-binding">% <i class="icon__arrow icon__arrow--top-4 arrow__down" ng-click="unitsShow(true)"></i></div>
                            </div>
                        </div>

                        <div class="clearfix row-item row-item--register-modal">
                            <div class="pull-left label-register">BIRTH DATE</div>
                            <div class="row-item__content row-item__content--register-modal pull-left">
                                <div class="pull-left">
                                    <input type="text" class="form-control form-input form-input--height-ft-inc ng-pristine ng-untouched ng-valid" mask="9" ng-model="user.height_ft" name="" ng-disabled="disabled.height" ng-hide="!showImperial" >
                                </div>
                                <div class="pull-left row-item__content-text row-item__content-text-ft ng-binding">DAY <i class="icon__arrow icon__arrow--top-4 arrow__down" ng-click="unitsShow(true)"></i></div>

                                <div class="pull-left">
                                    <input type="text" class="form-control form-input form-input--height-ft-inc ng-pristine ng-untouched ng-valid" mask="99?" ng-model="user.height_inc" ng-disabled="disabled.height" ng-hide="!showImperial" >
                                </div>
                                <div class="pull-left mr-20 row-item__content-text ng-binding">MONTH<i class="icon__arrow icon__arrow--top-4 arrow__down" ng-click="unitsShow(true)"></i></div>

                                <div class="pull-left ">
                                    <input type="text" class="form-control form-input form-input--register-year ng-pristine ng-untouched ng-valid" mask="99?" ng-model="user.height_inc" ng-disabled="disabled.height" ng-hide="!showImperial" >
                                </div>
                                <div class="pull-left row-item__content-text ng-binding">YEAR<i class="icon__arrow icon__arrow--top-4 arrow__down" ng-click="unitsShow(true)"></i></div>

                            </div>
                        </div>

                        <div class="clearfix row-item row-item--register-modal">
                            <div class="pull-left label-register">GENDER</div>
                            <div class="row-item__content row-item__content--register-modal pull-left">
                                <div class="pull-left">
                                    <input type="text" class="form-control form-input form-input--register-gender ng-pristine ng-untouched ng-valid" mask="9" ng-model="user.height_ft" name="" ng-disabled="disabled.height" ng-hide="!showImperial" >
                                </div>  
                                <div class="pull-left row-item__content-text ng-binding"><i class="icon__arrow icon__arrow--top-4 arrow__down" ng-click="unitsShow(true)"></i></div>                          
                            </div>
                        </div>


                        <div class="clearfix row-register">
                            <button type="button" class="btn btn-st-2 btn-green register-modal__btn-next register-modal__btn-next--step" >NEXT</button>
                        </div>

                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-custom">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                            </div>
                        @endif

                    {!! Form::close() !!}
                </div>
            </div>    
            <div class="register-modal__footer clearfix">
                <div class="container">
                      <div class="register-modal__footer__step_progress register-footer">
                          <div class="pull-left left_ico">
                            <img src="/public/assets/img/ico_lock_steps.png"  class="img-responsive"  />
                          </div>
                          <div class="pull-left">                             
                              <div class="meter register-modal__footer__step_progress__merter_score">
                                  <span ng-style="{ 'width' : statistic.score.progress + '%'  }" style="width: 10%;"></span> 
                                  <i ng-bind="statistic.score.completed" class="ng-binding">0 / 3</i>
                              </div>
                              <div class="register-modal__footer__step_progress__label text-center pad-l-0 mar-l-0">SIGNUP PROGRESS</div>
                          </div>
                      </div>                   
                </div>
            </div>
        </div>
    </div>

</div>
@endif
@include('template.header')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>
