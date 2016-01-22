<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="box-body">
    <div class="form-group">
        <label for="email">Name</label>
        <input type="text" name="title" class="form-control" id="email" value="{{ isset($achievement->title) ? $achievement->title : old('title') }}" placeholder="Name">
        @if ($errors->has('title'))<p style="color:red;">{!!$errors->first('title')!!}</p>@endif
    </div>
    <div class="form-group clearfix">
        <label for="full_name">Icon</label>
        <div class="clearfix">
            <div class="pull-left">
                <img src="{{ iconPath(isset($achievement) ? $achievement->icon : '') }}" alt="" class="icon-achievement"/>
                <div class="text-center"><a href="javascript:" class="btn-icon-remove {{ isset($achievement) && !empty($achievement->icon) ? 'show' : 'hide' }}" data-type="achievement">Remove</a></div>
            </div>
            <div class="fileUploadContainer btn btn-primary browse-icon">
                <span>Browse Image</span>
                <input class="fileupload upload" type="file" name="image" data-url="/admin/upload"  data-form-data='{"module": "achievement"}' >
                <input type="hidden" name="icon_achievement" value="{{ isset($achievement) ? $achievement->icon : '' }}"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-3 row">
                <label for="full_name">Difficulty</label>
                <select name="difficulty" class="form-control">
                   <option value=""></option>
                   @for ( $i = 1;  $i < 6; $i++ )
                       <option value="{{ $i }}" {{ isset($achievement) && $achievement->difficulty == $i ? 'selected="selected"' : '' }} >{{ $i }}</option>
                   @endfor
                </select>
                @if ($errors->has('difficulty'))<p style="color:red;">{!! $errors->first('difficulty') !!}</p>@endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-3 row">
                <label for="full_name">Category</label>
                <select name="category" class="form-control" id="achievement_category">
                    <option value=""></option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                        {{ isset($achievement) && $achievement->category_id == $category->id ? 'selected="selected"' : '' }}
                        >{{ $category->title }}</option>
                    @endforeach
                </select>
                @if ($errors->has('category'))<p style="color:red;">{!! $errors->first('category') !!}</p>@endif
            </div>

        </div>
    </div>
    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-3 row">
                <label for="full_name">Sub category</label>
                <select name="sub_category" class="form-control" id="achievement_sub_category">
                    @if ( isset($sub_categories) )
                        <option value=""></option>
                        @foreach($sub_categories as $category)
                        <option value="{{ $category->id }}"
                            {{ isset($achievement) && $achievement->subcategory_id == $category->id ? 'selected="selected"' : '' }}
                        > {{ $category->title }}</option>
                        @endforeach
                    @else
                        <option value=""></option>
                    @endif
                </select>
                @if ($errors->has('sub_category'))<p style="color:red;">{!! $errors->first('sub_category') !!}</p>@endif
            </div>

        </div>
    </div>

    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-3 row">
                <label for="full_name">Parent achievement</label>
                <select name="parent_achievement" class="form-control">
                    <option value="0"></option>
                    @foreach($achievements as $achievement_)
                        <option value="{{ $achievement_->id }}"
                                {{ isset($achievement) && $achievement->parent_achievement == $achievement_->id ? 'selected="selected"' : '' }}
                        >{{ $achievement_->title }}</option>
                    @endforeach
                </select>
                @if ($errors->has('parent_achievement'))<p style="color:red;">{!! $errors->first('parent_achievement') !!}</p>@endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-3 row">
                <label for="full_name">Points</label>
                <input class="form-control" type="text" name="points" value="{{ isset($achievement->points) ? $achievement->points : old('points') }}"/>
                @if ($errors->has('points'))<p style="color:red;">{!! $errors->first('points') !!}</p>@endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-6 row">
                <label for="full_name">Criteria text</label>
                <textarea name="criteria_text" cols="30" rows="5" class="form-control">{{ isset($achievement->criteria_text) ? $achievement->criteria_text : old('criteria_text') }}</textarea>
                @if ($errors->has('criteria_text'))<p style="color:red;">{!! $errors->first('criteria_text') !!}</p>@endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-6 row">
                <label for="full_name">Criteria</label>
                <select class="form-control" name="criteria" >
                    @foreach( $criteria as $item )
                        <option value="{{ $item->id }}"
                        {{ isset($achievement) && $achievement->criteria_id == $item->id ? 'selected="selected"' : '' }}
                        >{{ $item->title }}</option>
                    @endforeach
                </select>
                @if ($errors->has('criteria'))<p style="color:red;">{!! $errors->first('criteria') !!}</p>@endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-6 row">
                <label for="full_name">Criteria value</label>
                <input class="form-control" type="text" name="criteria_value" value="{{ isset($achievement->criteria_value) ? $achievement->criteria_value : old('criteria_value') }}"/>
                @if ($errors->has('criteria_value'))<p style="color:red;">{!! $errors->first('criteria_value') !!}</p>@endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-6 row">
                <label for="full_name">Criteria for show</label>
                <input class="form-control" type="text" name="criteria_show" value="{{ isset($achievement->criteria_show) ? $achievement->criteria_show : old('criteria_show') }}"/>
                @if ($errors->has('criteria_show'))<p style="color:red;">{!! $errors->first('criteria_show') !!}</p>@endif
            </div>
        </div>
    </div>

    <legend>
        Rewards
    </legend>
    <div class="clearfix">
        <div class="clearfix">
            <div class="col-md-8 row">
                <div class="form-group clearfix">
                    <label for="full_name">Player Card</label>
                    <div class="clearfix">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input class="form-control" type="text" value="{{ isset($cards->title) ? $cards->title : old('player_card_title') }}" name="player_card_title"/>
                        </div>
                        <!-- Big img -->
                        <div class="pull-left">
                            <div class="text-center">CARD ART</div>
                            <img src="{{ iconPath(isset($cards) ? $cards->path : '') }}" alt="" class="icon-path_player_card"/>
                            <div class="text-center"><a href="javascript:" class="btn-icon-remove {{ isset($cards) && !empty($cards->path) ? 'show' : 'hide' }}" data-type="path_player_card">Remove</a></div>
                        </div>

                        <div class="fileUploadContainer btn btn-primary browse-icon">
                            <span>Browse Image</span>
                            <input class="fileupload upload" type="file" name="image" data-url="/admin/upload"  data-form-data='{"module": "path_player_card"}' >
                            <input type="hidden" name="icon_path_player_card" value="{{ (isset($cards) ? $cards->path : '') }}"/>
                        </div>
                    </div>
                    <div class="clearfix">
                        <!-- little img -->
                        <div class="pull-left">
                            <div class="text-center">ICON</div>
                            <img src="{{ iconPath(isset($cards) ? $cards->icon : '') }}" alt="" class="icon-player_card"/>
                            <div class="text-center"><a href="javascript:" class="btn-icon-remove  {{ isset($cards) && !empty($cards->icon) ? 'show' : 'hide' }}" data-type="player_card">Remove</a></div>
                        </div>
                        <div class="fileUploadContainer btn btn-primary browse-icon">
                            <span>Browse Image</span>
                            <input class="fileupload upload" type="file" name="image" data-url="/admin/upload"  data-form-data='{"module": "player_card"}' >
                            <input type="hidden" name="icon_player_card" value="{{ (isset($cards) ? $cards->icon : '') }}"/>
                        </div>

                        {{--<!-- little img -->--}}
                        {{--<div class="pull-left ml-60">--}}
                            {{--<div class="text-center">ICON DISABLED</div>--}}
                            {{--<img src="{{ iconPath(isset($cards) ? $cards->icon_grey : '') }}" alt="" class="icon-player_card_grey"/>--}}
                            {{--<div class="text-center"><a href="javascript:" class="btn-icon-remove  {{ isset($cards) && !empty($cards->icon_grey) ? 'show' : 'hide' }}" data-type="player_card_grey">Remove</a></div>--}}
                        {{--</div>--}}
                        {{--<div class="fileUploadContainer btn btn-primary browse-icon">--}}
                            {{--<span>Browse Image</span>--}}
                            {{--<input class="fileupload upload" type="file" name="image" data-url="/admin/upload"  data-form-data='{"module": "player_card_grey"}' >--}}
                            {{--<input type="hidden" name="icon_player_card_grey" value="{{ (isset($cards) ? $cards->icon_grey : '') }}"/>--}}
                        {{--</div>--}}


                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"><hr/></div>
        <div class="clearfix">
         <div class="col-md-8 row">
            <div class="form-group clearfix">
                <label for="full_name">Gear</label>
                <div class="clearfix">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input class="form-control" type="text" value="{{isset($gear) ? $gear->title :''}}" name="trophy_title"/>
                    </div>
                    <div class="pull-left">
                        <div class="text-center">ICON</div>
                        <img src="{{ iconPath(isset($gear) ? $gear->icon :'') }}" alt="" class="icon-trophy"/>
                        <div class="text-center"><a href="javascript:" class="btn-icon-remove hide" data-type="trophy">Remove</a></div>
                    </div>
                    <div class="fileUploadContainer btn btn-primary browse-icon">
                        <span>Browse Image</span>
                        <input class="fileupload upload" type="file" name="image" data-url="/admin/upload"  data-form-data='{"module": "trophy"}' >
                        <input type="hidden" name="icon_trophy" value=""/>
                    </div>

                    {{--<div class="pull-left ml-60">--}}
                        {{--<div class="text-center">ICON DISABLED</div>--}}
                        {{--<img src="{{ iconPath(isset($gear) ? $gear->icon_grey :'') }}" alt="" class="icon-trophy_grey"/>--}}
                        {{--<div class="text-center"><a href="javascript:" class="btn-icon-remove hide" data-type="trophy_grey">Remove</a></div>--}}
                    {{--</div>--}}
                    {{--<div class="fileUploadContainer btn btn-primary browse-icon">--}}
                        {{--<span>Browse Image</span>--}}
                        {{--<input class="fileupload upload" type="file" name="image" data-url="/admin/upload"  data-form-data='{"module": "trophy_grey"}' >--}}
                        {{--<input type="hidden" name="icon_trophy_grey" value=""/>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
        </div>
    </div>


</div><!-- /.box-body -->

<div class="box-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>