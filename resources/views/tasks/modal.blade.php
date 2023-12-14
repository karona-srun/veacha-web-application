<!-- Modal Comment-->
<div class="modal fade" id="modal-lg-comment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="project_id" value="{{ $tickets->project_id }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="task_id" value="{{ $tickets->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">Create comment</h5>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <p>Comment <i class="text-red">*</i></p>
                                <textarea name="comment" class="form-control form-control-sm os-textarea" id="" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="input-group control-group increment">
                                    <p>Attachment<i class="text-red"></i></p>
                                    <button class="btn btn-primary btn-add-files btn-sm browse" type="button" style="height: 35px;margin-left:10px;margin-top: -5px;"><i class="fas fa-plus-circle"></i> Add file</button>
                                </div>

                                <input type="file" name="file" class="file">
                                <div class="input-group col-xs-12">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                    <input type="text" class="form-control form-control-sm" disabled placeholder="attachment file">
                                    <span class="input-group-btn">
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save-comment">Save comment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- / Modal Comment-->
<!-- Modal Log work-->
<div class="modal fade" id="modal-lg-log-work">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create log work</h5>
            </div>
            <div class="modal-body">
                <form role="form" action="{{ route('logworks.store') }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="task_id" value="{{ $tickets->id }}">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Time spent: <i class="text-red">*</i></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" name="time_spent" value="{{ old('time_spent') }}" placeholder="1h" value="{{ old('timespent') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <span>(1w = 1weeek, 1d = 1day, 1h = 1hour, 1m = 1minins)</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Date: <i class="text-red">*</i></label>
                                    <div class="col-sm-4">
                                        <input type="date" name="date" id="date" value="{{ old('date') }}" class="form-control form-control-sm date" placeholder="01/01/2020">
                                    </div>
                                    <div class="col-sm-6">
                                        <span>(dd/mm/yyy = 01/01/2020)</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p>Log work: <i class="text-red">*</i></p>
                                    <textarea name="logwork" value="{{ old('logwork') }}" class="form-control form-control-sm os-textarea" style="height: 150px !important;" id="" rows="10"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="input-group control-group increment">
                                        <p>Attachment<i class="text-red"></i></p>
                                        <button class="btn btn-primary btn-add-files btn-sm browse" type="button" style="height: 35px;margin-left:10px;margin-top: -5px;"><i class="fas fa-plus-circle"></i> Add file</button>
                                    </div>

                                    <input type="file" name="file" class="file">
                                    <div class="input-group col-xs-12">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                        <input type="text" class="form-control form-control-sm" disabled placeholder="attachment file">
                                        <span class="input-group-btn">
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save-log">Save log work</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal Log work -->

<!-- Modal Comment Edit-->
<div class="modal fade" id="modal-lg-comment-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" action="{{ route('comments.update',$comment->comment_id ?? '') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="project_id" value="{{ $tickets->project_id }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="task_id" value="{{ $comment->task_id ?? '' }}">
                <input type="hidden" name="file_id" id="file_id" value="{{ $comment->file_id ?? '' }}">
                <div class="modal-header">
                    <h5 class="modal-title">Edit comment</h5>
                    
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <p>Comment <i class="text-red">*</i></p>
                                <textarea name="comment" class="form-control form-control-sm os-textarea comment" id="comment" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="input-group control-group increment">
                                    <p>Attachment<i class="text-red"></i></p>
                                    <button class="btn btn-primary btn-add-files btn-sm browse" type="button" style="height: 35px;margin-left:10px;margin-top: -5px;"><i class="fas fa-plus-circle"></i> Add file</button>
                                </div>

                                <input type="file" name="file" class="file" id="files" value="">
                                <div class="input-group col-xs-12">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                    <input type="text" class="form-control form-control-sm" name="filename" id="title-files" placeholder="attachment file">
                                    <span class="input-group-btn">
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary edit-comment" id="button_action" >Update comment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- / Modal Comment Edit -->

<!-- Modal Log work Edit-->
<div class="modal fade" id="modal-lg-log-work-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit log work</h5>
            </div>
            <div class="modal-body">
                <form role="form" action="{{ route('logworks.update',$logwork->logwork_id ?? '') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="modal-body">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="task_id" value="{{ $tickets->id }}">
                        <input type="hidden" name="logwork_id" value="{{ $logwork->logwork_id ?? ''}}">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12"> 
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Time spent: <i class="text-red">*</i></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" id="etime" name="etime_spent" value="{{ old('time_spent') }}" placeholder="1h" value="{{ old('timespent') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <span>(1w = 1weeek, 1d = 1day, 1h = 1hour, 1m = 1minins)</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Date: <i class="text-red">*</i></label>
                                    <div class="col-sm-4">
                                        <input type="date" name="edate" id="edate" value="{{ old('date') }}" class="form-control form-control-sm " placeholder="01/01/2020">
                                    </div>
                                    <div class="col-sm-6">
                                        <span>(dd/mm/yyy = 01/01/2020)</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p>Log work: <i class="text-red">*</i></p>
                                    <textarea name="elogwork" value="{{ old('logwork') }}"  class="form-control form-control-sm os-textarea " id="elogwork" style="height: 150px !important;" rows="10"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="input-group control-group increment">
                                        <p>Attachment<i class="text-red"></i></p>
                                        <button class="btn btn-primary btn-add-files btn-sm browse" type="button" style="height: 35px;margin-left:10px;margin-top: -5px;"><i class="fas fa-plus-circle"></i> Add file</button>
                                    </div>

                                    <input type="file" name="file" class="file">
                                    <div class="input-group col-xs-12">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                        <input type="text" class="form-control form-control-sm" disabled placeholder="attachment file">
                                        <span class="input-group-btn">
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary edit-log">Update log work</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal log work edit -->