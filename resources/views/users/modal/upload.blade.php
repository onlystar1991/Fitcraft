<div class="clearfix upload_file_modal">

              <div class="cleafix">
                  <div class="upload_file_modal_header">
                    <div class="left">
                        <ul class="upload__menu">
                            <li class="upload__menu_li"><a href="javascript:;" class="active tab-upload" data-tab="tab-device" >DEVICE</a></li>
                            <li class="upload__menu_li"><a href="javascript:;" class="tab-upload" data-tab="tab-file">FROM FILE</a></li>
                            <li class="upload__menu_li"><a href="javascript:;" class="tab-upload" data-tab="tab-strava">SYNC TO STRAVA</a></li>
                        </ul>
                    </div>
                    <div id="tab-device" class="upload_tab_item active">
                        <div class="center bg-phone">
                            <div class="device_container">
                                <div class="device__name">GARMIN 800</div>
                                <div class="device__id">DEVICE ID: 4567413249687</div>
                            </div>

                        </div>
                    </div>
                    <div id="tab-file" class="upload_tab_item">
                        {!! Form::open(['class'=>'form_upload_files','files'=>true]) !!}
                        <div class="center">
                            <div class="upload-file-container">
                                <input id="uploadFile" placeholder="Choose File" disabled="disabled" class="input-upload" />
                                <div class="fileUpload btn btn-upload-file">
                                    <span>BROWSE</span>
                                    <input id="uploadFileInput" type="file" name="file" class="upload" data-url="{{ URL::to('upload/file') }}"  />
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="tab-strava" class="upload_tab_item">
                        <div class="center">
                           <div class="form-group">
                            <label for="" class="text-center">LOGIN</label>
                            <div class="form-control-container">
                                <input class="form-control" type="text"/>
                            </div>
                           </div>
                           <div class="form-group">
                                <label for="" class="text-center">PASSWORD</label>
                                <div class="form-control-container">
                                    <input class="form-control" type="password"/>
                                </div>
                           </div>
                           <div class="form-group text-center">
                            <a href="{{$stravaLogin}}" class="btn btn-medium btn-green">SYNC RIDES</a>
                           </div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="label_progress">PROGRESS</div>
                        <div class="progress__container text-center">
                            <div class="progress vertical bottom">
                                <div class="progress-bar" role="progressbar" data-transitiongoal-backup="75" data-transitiongoal="75" aria-valuenow="75" style="height: 5%;"></div>
                            </div>
                        </div>
                        <a href="javascript:;" class="btn-upload text-center btn-upload-file-action">UPLOAD </a>
                    </div>
              </div>
              <div class="clearfix">
                <form action="" method="GET" class="form-upload-files-list">
                <table class="table-files">
                    <thead>
                        <tr>
                            <td width="50">
                                <input type="checkbox" id="c0" name="cc" class="check-all" />
                                <label for="c0"><span></span></label>
                            </td>
                            <td>STATUS</td>
                            <td>DATE</td>
                            <td width="150">TIME</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if ( !empty($files) )
                            @foreach($files as $file)
                            <tr>
                                <td><input type="checkbox" id="c{{$file->id}}" name="cc[]" value="{{ $file->id }}" />
                                     <label for="c{{$file->id}}"><span></span></label>
                                </td>
                                <td>{{($file->completed_all == 'Y') ? '' : 'NEW'}}</td>
                                <td>{{ \App\BikeCraft\Data::showDate($file->start) }}</td>
                                <td>{{ \App\BikeCraft\Data::sessionTimeStartEnd($file->start, $file->end) }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {!! Form::close() !!}
              </div>
              </div>

</div>
<script>
$('#uploadFileInput').fileupload({
        progress: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(".progress-bar").height(progress + '%');
        },
        done: function(e, data){
            var tmpl = $('#tmpl-upload-file').html();
            var compiledTmpl = _.template(tmpl);
            $('.table-files tbody').append( compiledTmpl({item:data.result}));
            $(".progress-bar").height('0%');
        }
    });
</script>
<script id="tmpl-upload-file" type="text/template">
 <tr>
    <td><input type="checkbox" id="c<%= item.id %>" name="cc[<%= item.id %>]" value="<%= item.id %>" />
         <label for="c<%= item.id %>"><span></span></label>
    </td>
    <td>NEW</td>
    <td><%= item.date %></td>
    <td><%= item.time %></td>
</tr>
</script>