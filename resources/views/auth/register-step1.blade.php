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
        		<h1>STEP 1: ACCOUNT INFO</h1>
        	</div>        
            <div class="text-center register-form">
                {!! Form::open() !!}
                    <div class="clearfix row-register">
                       <div class="pull-left label-register ">FIRST NAME</div>
                       <input class="form-control form-input pull-left input-register"
                       type="text" name="first_name" value="" autocomplete="off"
                       placeholder="ENTER YOUR FIRST NAME">
                    </div>
                    <div class="clearfix row-register">
                       <div class="pull-left label-register ">LAST NAME</div>
                       <input class="form-control form-input pull-left input-register"
                       type="text" name="last_name" value="" autocomplete="off"
                       placeholder="ENTER YOUR LAST NAME">
                    </div>
                    <div class="clearfix row-register">
                       <div class="pull-left label-register ">PASSWORD</div>
                       <input class="form-control form-input pull-left input-register"
                       type="password" name="password" value="" autocomplete="off"
                       placeholder="ENTER PASSWORD">
                    </div>
                    <div class="clearfix row-register">
                       <div class="pull-left label-register ">CONFIRM PASS</div>
                       <input class="form-control form-input pull-left input-register"
                       type="password" name="conf_password" value="" autocomplete="off"
                       placeholder="ENTER PASSWORD">
                    </div>                                                                            
                    <div class="clearfix row-register">
                       <div class="pull-left label-register ">EMAIL</div>
                       <input class="form-control form-input pull-left input-register"
                       type="text" name="email" value="" autocomplete="off"
                       placeholder="ENTER EMAIL">
                    </div>
                    
                    <div class="clearfix row-register">
                        <button type="submit" class="btn btn-st-2 btn-green register-modal__btn-next" >NEXT</button>
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
            <div class="register-modal__footer clearfix">
                <div class="container">
					  <div class="register-modal__footer__step_progress">
		                  <div class="pull-left">
		                  	<img src="/public/assets/img/ico_lock_steps.png" />
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
