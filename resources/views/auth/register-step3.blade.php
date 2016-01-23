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
                <div class="header-steps header-steps--step3">
                    <h1>STEP 3: NAME AND PLAYER CARD</h1>
                </div>
            </div>            
            <div class="register-from-area">                    
                <div class="text-center register-form register-form--step3">
                    {!! Form::open() !!}
                        <div class="clearfix row-register row-register--athlete-name">
                            <div class="col-md-12">
                                <div class="col-md-4 text-right lh-25">
                                    ATHLETE NAME
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control form-input pull-left input-athlete-name" type="text" name="name" value="" autocomplete="off" >
                                </div>   
                                <div class="col-md-4 text-left">
                                    <button type="submit" class="btn btn-st-2 btn-green register-modal__btn-available" >AVAILABLE</button>
                                </div>  
                            </div>                                                
                        </div>

                        <div class="clearfix row-register row-register__athlete-list">
                            <div class="col-md-12">
                                <ul class="bxslider">
                                  <li>
                                    <a href="">
                                        <img src="/public/assets/img/cards/PC_Roadette_grey.png" class="img-responsive" >   
                                    </a>
                                  </li>
                                  <li>
                                    <a href="">
                                        <img src="/public/assets/img/cards/PC_Roadie_grey.png" class="img-responsive" >
                                    </a>
                                  </li>
                                  <li>
                                    <a href="">
                                        <img src="/public/assets/img/cards/PC_theMessenger_grey.png" class="img-responsive" >    
                                    </a>
                                   </li>
                                </ul>                                                                           
                            </div>
                            <div class="col-md-12">
                                <div class="row-register__athlete-list__nav"> 
                                   <i class="nav-next"></i>                        
                                   <button type="button" class="btn btn-st-2 btn-green btn-select-step3" >SELECT</button>
                                   <i class="nav-prev"></i>
                                </div>                            
                            </div>                                                
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
<!-- Bxslider  -->
{!! HTML::script('assets/js/lib/bxslider/jquery.bxslider.js') !!}
{!! HTML::style('assets/js/lib/bxslider/jquery.bxslider.css') !!}
<script>
    $('.bxslider').bxSlider({    
        minSlides: 3,
        maxSlides: 3,
        slideWidth: 250,
        slideMargin: 10,
        pager:false,
        nextSelector: '.nav-next',
        prevSelector: '.nav-prev',
        nextText: '',
        prevText: '',
        onSliderLoad: function () {
            $('.bx-next').addClass('icon__arrow icon__arrow--size-slider arrow__left');
            $('.bx-prev').addClass('icon__arrow icon__arrow--size-slider arrow__right');
        }             
    });    
</script>
<!-- Bxslider -->

</body>
</html>
