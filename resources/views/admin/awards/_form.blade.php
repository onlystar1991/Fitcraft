<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="box-body">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" value="{{ isset($award->title) ? $award->title : old('title') }}" placeholder="Title">
        @if ($errors->has('title'))<p style="color:red;">{!!$errors->first('title')!!}</p>@endif
    </div>
    <div class="form-group">
        <label for="achievement_id">Achievement id</label>
        <input type="number" name="achievement_id" class="form-control" id="achievement_id" value="{{ isset($award->achievement_id) ? $award->achievement_id : old('achievement_id') }}">
        @if ($errors->has('achievement_id'))<p style="color:red;">{!!$errors->first('achievement_id')!!}</p>@endif
    </div>

    <div class="form-group">
        <div class="clearfix">
            <div class="col-md-3 row">
                <label for="source">Source</label>
                <select name="source" class="form-control">
                    @foreach ($sources as $val=>$source)
                        <option value="{{ $val }}" {{ isset($award) && $award->source == $val ? 'selected=selected' : '' }} >{{ $source }}</option>
                    @endforeach
                </select>
                @if ($errors->has('source'))<p style="color:red;">{!! $errors->first('source') !!}</p>@endif
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
                        <option value="{{ $i }}" {{ isset($award) && $award->difficulty == $i ? 'selected="selected"' : '' }} >{{ $i }}</option>
                    @endfor
                </select>
                @if ($errors->has('difficulty'))<p style="color:red;">{!! $errors->first('difficulty') !!}</p>@endif
            </div>
        </div>
    </div>
    <div class="form-group clearfix">
        <label for="icon_award">Icon</label>
        <div class="clearfix">
            <div class="pull-left">
                <img src="{{ iconPath(isset($award) ? $award->icon : '') }}" alt="" class="icon-award"/>
                <div class="text-center"><a href="javascript:" class="btn-icon-remove {{ isset($award) && !empty($award->icon) ? 'show' : 'hide' }}" data-type="award">Remove</a></div>
            </div>
            <div class="fileUploadContainer btn btn-primary browse-icon">
                <span>Browse Image</span>
                <input class="fileupload upload" type="file" name="image" data-url="/admin/upload"  data-form-data='{"module": "award"}' >
                <input type="hidden" name="icon_award" value="{{ isset($award) ? $award->icon : '' }}"/>
            </div>
        </div>
    </div>
    {{--<div class="form-group clearfix">--}}
        {{--<label for="icon_award-grey">Icon disabled</label>--}}
        {{--<div class="clearfix">--}}
            {{--<div class="pull-left">--}}
                {{--<img src="{{ iconPath(isset($award) ? $award->icon_grey : '') }}" alt="" class="icon-award-grey"/>--}}
                {{--<div class="text-center"><a href="javascript:" class="btn-icon-remove {{ isset($award) && !empty($award->icon_grey) ? 'show' : 'hide' }}" data-type="award-grey">Remove</a></div>--}}
            {{--</div>--}}
            {{--<div class="fileUploadContainer btn btn-primary browse-icon">--}}
                {{--<span>Browse Image</span>--}}
                {{--<input class="fileupload upload" type="file" name="image" data-url="/admin/upload"  data-form-data='{"module": "award-grey"}' >--}}
                {{--<input type="hidden" name="icon_award-grey" value="{{ isset($award) ? $award->icon_grey : '' }}"/>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</div><!-- /.box-body -->

<div class="box-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>