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
</head>
<body>

@if ( !Auth::client()->check() )
    <div class="register-modal clearfix">
    <div class="register-modal__header">
    </div>
    {!! Form::open(['id' => 'go_reg','class' => 'form-wizard-register']) !!}
    <div class="register-container text-center" >         
                <ul style="display:none">
                    <li><a href="#tab1" data-toggle="tab">First</a></li>
                    <li><a href="#tab2" data-toggle="tab">Second</a></li>
                    <li><a href="#tab3" data-toggle="tab">Third</a></li>
                </ul>
        <div class="clearfix" >
          <div class="register-modal__steps">
                <div class="header-steps">
                    <h1 class="step-name" >STEP 1: ACCOUNT INFO</h1>
                </div>
          </div> 
            <div class="register-from-area tab-content">
                 <!-- STEP1 -->
                <div class="text-center register-form tab-pane active"  id="tab1" >                        
                        <div class="clearfix row-register">
                           <div class="pull-left label-register ">NAME</div>
                           <input class="form-control form-input pull-left input-register"
                            type="text" name="name" value="" autocomplete="off"
                            placeholder="ENTER YOUR NAME">
                        </div>
                        <div class="clearfix row-register">
                           <div class="pull-left label-register ">PASSWORD</div>
                           <input class="form-control register-password form-input pull-left input-register"
                           type="password" name="password" value="" autocomplete="off"
                           placeholder="ENTER PASSWORD">
                        </div>
                        <div class="clearfix row-register">
                           <div class="pull-left label-register ">CONFIRM PASS</div>
                           <input class="form-control form-input pull-left input-register"
                           type="password" name="confirm_password" value="" autocomplete="off"
                           placeholder="ENTER PASSWORD">
                        </div>                                                                            
                        <div class="clearfix row-register">
                           <div class="pull-left label-register ">EMAIL</div>
                           <input class="form-control input-email-register form-input pull-left input-register"
                           type="text" name="email" value="" autocomplete="off"
                           placeholder="ENTER EMAIL">
                           <label class="error email_name_erorr" style="display: none;">Email Is already taken.</label>                                
                        </div>
                </div> 
                <!-- STEP1 -->
                <!-- STEP2-->
                <div class="text-center register-form tab-pane register-form--step2"  id="tab2" >                        
                    <div class="clearfix row-item row-item--register-modal">
                        <div class="pull-left label-register">HEIGHT</div>
                        <div class="row-item__content row-item__content--register-modal pull-left">
                            <div class="pull-left">
                                <select name="ft" class="form-input cs-select cs-skin-border"> 
                                    <option value=""></option>                                   
                                    <?php for ($i=1; $i <=6 ; $i++) { 
                                        echo "<option value='$i' >$i</option>";
                                    } ?>
                                </select>                                    
                            </div>
                            <div class="pull-left row-item__content-text row-item__content-text-ft">
                                <span class="reg-height-1-label">FT</span>                                  
                            </div>

                            <div class="pull-left">                                
                                   <select name="inch" class="form-input cs-select cs-skin-border">
                                      <option value=""></option>
                                      <?php for ($i=0; $i <=11 ; $i++) { 
                                          echo "<option value='$i' >$i</option>";
                                      } ?>
                                   </select>                                 
                            </div>
                            <div class="pull-left row-item__content-text ng-binding">
                                INCH
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row-item row-item--register-modal">
                        <div class="pull-left label-register">WEIGHT</div>
                        <div class="row-item__content row-item__content--register-modal pull-left">
                            <div class="pull-left">
                                   <select name="lbs" class="form-input cs-select cs-skin-border">
                                      <option value=""></option>
                                      <?php for ($i=0; $i <=350 ; $i++) { 
                                          echo "<option value='$i' >$i</option>";
                                      } ?>
                                   </select>                         
                            </div>
                            <div class="pull-left row-item__content-text row-item__content-text-ft">
                                LBS 
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row-item row-item--register-modal">
                        <div class="pull-left label-register">BODY FAT %</div>
                        <div class="row-item__content row-item__content--register-modal pull-left">
                            <div class="pull-left">
                               
                                   <select name="body_fat" class="form-input cs-select cs-skin-border">
                                      <option value=""></option>
                                      <?php for ($i=0; $i <=65 ; $i++) { 
                                          echo "<option value='$i' >$i</option>";
                                      } ?>
                                   </select>
                                                              
                            </div>
                            <div class="pull-left row-item__content-text row-item__content-text-ft">
                                % 
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row-item row-item--register-modal">
                        <div class="pull-left label-register">BIRTH DATE</div>
                        <div class="row-item__content row-item__content--register-modal pull-left">
                            <div class="pull-left">
                                   <select name="day" class="form-input cs-select cs-skin-border">
                                      <option value=""></option>
                                      <?php for ($i=1; $i <=31 ; $i++) { 
                                          echo "<option value='$i' >$i</option>";
                                      } ?>
                                   </select>             
                            </div>
                            <div class="pull-left mr-10 row-item__content-text row-item__content-text-ft ng-binding">
                                DAY
                            </div>
                            <div class="pull-left">                               
                                   <select name="month" class="form-input cs-select cs-skin-border">
                                      <option value=""></option>
                                      <?php for ($i=1; $i <13 ; $i++) { 
                                          echo "<option value='$i' >$i</option>";
                                      } ?>
                                   </select>
                            </div>
                            <div class="pull-left mr-10 row-item__content-text ng-binding">
                                MONTH
                            </div>

                            <div class="pull-left ">
                                   <select name="year" class="form-input cs-select cs-skin-border cs-select__year">                                     
                                      <option value=""></option>
                                      <?php for ($i=(date('Y')-90); $i <= (date('Y')-15) ; $i++) { 
                                          echo "<option value='$i' >$i</option>";
                                      } ?>
                                   </select>             
                            </div>
                            <div class="pull-left row-item__content-text ng-binding row-item--register-modal_year">
                                YEAR
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row-item row-item--register-modal">
                        <div class="pull-left label-register">GENDER</div>
                        <div class="row-item__content row-item__content--register-modal pull-left">
                            <div class="pull-left">
                                   <select name="gender" class="form-input cs-select cs-skin-border cs-select__gender">
                                      <option value=""></option>                                      
                                      <option value="m">MALE</option>                                      
                                      <option value="f">FEMALE</option>                                      
                                   </select>                         
                            </div>                            
                        </div>
                    </div>
                </div> 
                <!-- STEP2 -->   
                <!-- STEP3-->
                <div class="text-center register-form tab-pane register-form--step3"  id="tab3" >                        
                    <div class="clearfix row-register row-register--athlete-name">
                        <div class="col-md-12">
                            <div class="col-md-4 text-right lh-25">
                                ATHLETE NAME
                            </div>
                            <div class="col-md-4">
                                <input class="form-control input-athlete-register form-input pull-left input-athlete-name" type="text" name="athlete_name" value="" autocomplete="off" >
                                <label class="error athlete_name_erorr" style="display: none;">Is already taken.</label>                                
                            </div>   
                            <div class="col-md-4 text-left">
                                <button type="button" style="display:none" class="btn btn-st-2 btn-green register-modal__btn-available"  >AVAILABLE</button>
                            </div>  
                        </div>                                                
                    </div>
                    <div class="clearfix row-register row-register__athlete-list">
                        <div class="col-md-12 jcarousel-container">
                          <div class="jcarousel-wrapper">
                              <div class="jcarousel">
                                @if($cards)
                                    <ul>
                                    @foreach($cards as $key => $val)
                                      <li id="{{$val->id}}">                                          
                                         <img src="{{iconPath($val->path)}}" class="card_id_img_{{$val->id}} {{$key==1?'':'img-inactive'}} img-responsive" >
                                      </li>
                                    @endforeach
                                    </ul>
                                    <input type="hidden" class="card_id" name="card_id" value="{{isset($cards[1]->id)?$cards[1]->id:$cards[0]->id}}">
                                @endif 
                              </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row-register__athlete-list__nav"> 
                                <a href="#" class="jcarousel-control-prev icon__arrow icon__arrow--size-slider arrow__left_register"></a>                     
                                <button type="submit" class="btn btn-st-2 btn-green btn-select-step3" >SELECT</button>                               
                                <a href="#" class="jcarousel-control-next icon__arrow icon__arrow--size-slider arrow__right_register"></a>
                            </div>                            
                        </div>                                                
                    </div>
                </div> 
                <!-- STEP3 -->                                  

                <div class="text-center register-form register-form--next-btn-area ">                              
                    <div class="clearfix row-register">
                        <ul class="wizard">
                            <li class="next">
                                <a href="javascript:;" class="btn btn-st-2 btn-green register-modal__btn-next" >Next</a>
                                <!-- <a href="javascript:;" class="btn btn-st-2 btn-green register-modal__btn-next" >Next</a> -->
                            </li>                                                      
                        </ul>
                    </div>
                </div>
            </div> 
            <div class="register-modal__footer clearfix">
                <div class="container">
                <div class="register-modal__footer__step_progress register-footer">
                      <div class="pull-left left_ico">
                        <img src="/assets/img/ico_lock_steps.png"  class="img-responsive"  />
                      </div>
                      <div class="pull-left">                         
                          <div class="meter register-modal__footer__step_progress__merter_score progress-step1" style="display:block" >                                  
                                <span style="width: 10%;"></span> 
                                <i class="ng-binding" >0 / 3</i>          
                          </div>  
                          <div class="meter register-modal__footer__step_progress__merter_score progress-step2" style="display:none">                                                                     
                                <span style="width: 40%;"></span> 
                                <i class="ng-binding" >1 / 3</i>
                          </div>
                          <div class="meter register-modal__footer__step_progress__merter_score progress-step3" style="display:none">                                      
                                <span style="width: 70%;"></span> 
                                <i class="ng-binding" >2 / 3</i>                                  
                           </div>
                           <div class="register-modal__footer__step_progress__label text-center pad-l-0 mar-l-0">SIGNUP PROGRESS</div>
                      </div>
                </div>                   
                </div>
            </div>
        </div>            
       
    </div>
    {!! Form::close() !!}

</div>
@endif
@include('template.header')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

{!! HTML::script('assets/js/lib/jquery.jscrollpane.min.js') !!}
{!! HTML::script('assets/js/lib/jquery.mousewheel.js') !!}


<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
{!! HTML::script('assets/js/lib/upload/vendor/jquery.ui.widget.js') !!}
{!! HTML::script('assets/js/lib/upload/jquery.iframe-transport.js') !!}
{!! HTML::script('assets/js/lib/upload/jquery.fileupload.js') !!}
{!! HTML::script('assets/js/lib/bootstrap-datepicker.js') !!}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- Tmp  -->
{!! HTML::script('assets/js/lib/jquery.jscrollpane.min.js') !!}
{!! HTML::script('assets/js/lib/jquery.mousewheel.js') !!}
<!-- TMP -->


<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
{!! HTML::script('assets/js/lib/upload/vendor/jquery.ui.widget.js') !!}
{!! HTML::script('assets/js/lib/upload/jquery.iframe-transport.js') !!}
{!! HTML::script('assets/js/lib/upload/jquery.fileupload.js') !!}
{!! HTML::script('assets/js/lib/bootstrap-datepicker.js') !!}

{!! HTML::script('assets/js/custom.js') !!}

<!-- boostraptwizard -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
{!! HTML::script('assets/js/lib/bwizard/jquery.validate.min.js') !!}
{!! HTML::script('assets/js/lib/bwizard/jquery.bootstrap.wizard.min.js') !!}
{!! HTML::script('assets/js/lib/bwizard/init.js') !!}

<!-- jcarousle  -->
{!! HTML::script('assets/js/lib/jcarousel/jquery.jcarousel.min.js') !!}
{!! HTML::script('assets/js/lib/jcarousel/jcarousel.responsive.js') !!}
{!! HTML::style('assets/js/lib/jcarousel/jcarousel.responsive.css') !!}
<!-- End jcarousle -->
<!-- customSelect  -->
{!! HTML::script('assets/js/lib/customSelect/classie.js') !!}
{!! HTML::script('assets/js/lib/customSelect/selectFx.js') !!}
{!! HTML::style('assets/js/lib/customSelect/cs-select.css') !!}
<script>
  (function() {
    [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {  
      new SelectFx(el);
    } );
  })();
</script>
<!-- End customSelect -->



</body>
</html>