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
    <div class="login-modal clearfix">
    <div class="login-modal__header">
    </div>
    <div class="login-container text-center">
        
        <div class="clearfix">
            <div class="text-center login-form">
                {!! Form::open() !!}
                    <div class="clearfix row-login">
                       <div class="pull-left label-login ">NAME</div>
                       <input class="form-control form-input pull-left input-login"
                       type="text" name="name" value="" autocomplete="off"
                       placeholder="ENTER YOUR NAME">
                    </div>
                    <div class="clearfix row-login">
                       <div class="pull-left label-login ">PASSWORD</div>
                       <input class="form-control form-input pull-left input-login"
                       type="password" name="password" value="" autocomplete="off"
                       placeholder="ENTER PASSWORD">
                    </div>
                    <div class="clearfix row-login">
                       <div class="pull-left label-login ">CONFIRM PASS</div>
                       <input class="form-control form-input pull-left input-login"
                       type="password" name="conf_password" value="" autocomplete="off"
                       placeholder="ENTER PASSWORD">
                    </div>                                                                            
                    <div class="clearfix row-login">
                       <div class="pull-left label-login ">EMAIL</div>
                       <input class="form-control form-input pull-left input-login"
                       type="text" name="email" value="" autocomplete="off"
                       placeholder="ENTER EMAIL">
                    </div>
                    
                    <div class="clearfix row-login">
                        <button type="submit" class="pull-left btn btn-st-2 btn-green btn-login" >NEXT</button>
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
            <div class="login-modal__footer clearfix">
                <div class="container">
                    <div class="login-modal__footer-item">
                        <div class="icon icon__level"></div>
                        <div class="clearfix label-text">LEVEL</div>
                    </div>
                    <div class="login-modal__footer-item">
                        <div class="icon icon__21"></div>
                        <div class="clearfix label-text">ACHIEVE</div>
                    </div>
                    <div class="login-modal__footer-item">
                        <div class="icon icon__collect"></div>
                        <div class="clearfix label-text">COLLECT</div>
                    </div>
                    <div class="login-modal__footer-item">
                        <div class="icon icon__22"></div>
                            <div class="clearfix label-text">COMPETE</div>
                    </div>
                    <div class="login-modal__footer-item">
                        <div class="icon icon__14"></div>
                        <div class="clearfix label-text">RANK</div>
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
