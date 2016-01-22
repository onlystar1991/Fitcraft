<div class="header">
    <div class="header_in">
        <div class="container">
            @if (Auth::client()->check())
            <!-- left menu -->
            <ul class="menu_categories">
                 <li class="menu_categories_li">
                    <a href=""><i class="account__menu_icon account__menu_icon_bike"></i></a>
                 </li>
                 <li class="menu_categories_li">
                    <a href=""><i class="account__menu_icon account__menu_icon_swin"></i></a>
                 </li>
                 <li class="menu_categories_li">
                    <a href=""><i class="account__menu_icon account__menu_icon_run"></i></a>
                 </li>
            </ul>
            <!-- /left menu -->
            
            
            <!-- middle and right menu -->
            <ul class="account__menu" ng-controller="ModalCtrl">
                
                <li class="account__menu__li account__menu__li__dd">
                    <span class="account__menu__li__dd_name">OPTIONS</span>

                    <!-- dropdown -->
                    <div class="account__menu__li__dd_content">
                        <a href="javascript:;" ng-click="account()">ACCOUNT</a>
                    </div>
                    <!-- /dropdown -->
                </li>

                <li class="account__menu__li account__menu__li__dd">
                    <span class="account__menu__li__dd_name">FORUMS</span>

                    <!-- dropdown -->
                    <div class="account__menu__li__dd_content">
                        <a href="{{config('app.forum_url')}}index.php">FORUMS HOME</a>
                        <a href="{{config('app.forum_url')}}search.php?search_id=egosearch">MY POSTS</a>
                        <a href="{{config('app.forum_url')}}viewforum.php?f=2">MOD POSTS</a>
                    </div>
                    <!-- /dropdown -->
                </li>

                <li class="account__menu__li account__menu__li__dd" id="dd-help">
                    <span class="account__menu__li__dd_name">HELP</span>

                    <!-- dropdown -->
                    <div class="account__menu__li__dd_content">
                        <a href="#">FAQ</a>
                        <a href="{{config('app.forum_url')}}viewforum.php?f=2">HELP FORUM</a>
                        <a href="javascript:;" ng-click="report()">HELP CONTACT</a>
                        <a href="javascript:;" ng-click="report(true)">REPORT BUG</a>
                    </div>
                    <!-- /dropdown -->
                </li>

                
                <li class="account__menu__li account__menu__li__dd">
                    <a href="/logout"> LOGOUT</a>
                </li>
                


                 <li class="account__menu__li account__menu__li_upload">
                    <a href="javascript:;" ng-click="upload()" class="account__menu_upload"><i class="icon__add"></i>UPLOAD RIDE</a>
                </li>
            </ul>
            <!-- /middle and right menu -->
            @endif

        </div>
    </div>
</div>