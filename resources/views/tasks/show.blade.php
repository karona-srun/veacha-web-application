@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('veacha.task')}}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @can('task-edit')
                    <li class="breadcrumb-item"><a href="{{ route('tasks.edit',$tickets->id) }}" class="btn btn-primary m-0 pull-left">{{ __('veacha.button_edit_task')}}</a>
                    </li>
                    @endcan
                    @can('task-list')
                    <li class="breadcrumb-item"><a href="{{ route('projects.show',$tickets->project_id) }}" class="btn btn-primary m-0 pull-left">{{ __('veacha.button_list_task')}}</a>
                    </li>
                    @endcan
                </ol>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 col-md-12 col-xs-12">
                <button type="button" class="btn btn-customize" data-toggle="modal" data-target="#modal-lg-comment">{{ __('veacha.comments')}}</button>
                <button type="button" class="btn btn-customize" data-toggle="modal" data-target="#modal-lg-log-work">{{ __('veacha.log_work')}}</button>
            </div>
        </div>
        <br>
    </div>
</div>

@endsection @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="">
                <div class="">
                    <div class="row">
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('veacha.task')}}: </dt>
                                <dd class="col-sm-8">{{ $tickets->task }}</dd>
                                <dt class="col-sm-4">{{ __('veacha.created_by')}}: </dt>
                                <dd class="col-sm-8">{{ $tickets->created_by}}</dd>
                                <dt class="col-sm-4">{{ __('veacha.created_at')}}: </dt>
                                <dd class="col-sm-8" style="text-transform:uppercase">{{ $tickets->created_at->format('d/m/Y h:m a') }}</dd>
                            </dl>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <dl class="row">
                                <dt class="col-md-5">{{ __('veacha.estimate_time')}}: </dt>
                                <dd class="col-md-7">{{ $data['estimate_time'] ?? '0'}} (h)</dd>
                                <dt class="col-md-5">{{ __('veacha.tracking_time')}}: </dt>
                                <dd class="col-md-7">{{ $data['tracking_time'] ?? '0'}} (h)</dd>
                                <dt class="col-md-6 text-red">{{ __('veacha.remaining_time')}}: </dt>
                                <dd class="col-md-6 text-red">{{ $data['remaining_time'] ?? '0'}} (h)</dd>
                            </dl>
                        </div>
                    </div>
                    <hr>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <dl class="row">
                                <dt class="col-sm-2">{{ __('veacha.description')}}: </dt>
                                <dd class="col-sm-8">{!! $tickets->description !!}</dd>
                            </dl>
                        </div>
                    <hr>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <dl class="row">
                            <dt class="col-sm-2">{{ __('veacha.attachment_files')}}: </dt>
                            {{-- {{ $tickets->getFileDownload($tickets->id) }} --}}
                            @foreach(($tickets->getFileDownload($tickets->id)) as $i => $value)
                            {{-- <dd class="col-sm-8">{{ $value->name }}</dd> --}}
                            <a href="{{ url('download-attachemnt',$value->name) }}" class="img img-thumbnail m-2"​​ title="Attachment file">
                                <span class="fas fa-paperclip"></span> Download
                            </a>
                            @endforeach
                        </dl>
                    </div>
                <hr>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12 col-sm-12 col-lg-12">
            <div class="card-body">
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">{{ __('veacha.comments')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">{{ __('veacha.log_work')}}</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                        @foreach($comments as $comment)
                        <div class="direct-chat-messages" id="comment_{{ $comment->comment_id }}">
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{ $comment->name }}</span>
                                    <span class="direct-chat-timestamp">{{ date('d/m/Y h:i A', strtotime($comment->created_at)) }} </span>
                                </div>
                                <img src="{{ URL::to('/') }}/photos/{{ $comment->photo }}" class="direct-chat-img img-circle img-size-50" alt="photo">
                                <div class="direct-chat-text">
                                    @if( Auth::user()->id == $comment->user_id)
                                    <span class="someicon float-right comment-removed" href="{{ url('commentremoved',$comment->comment_id) }}"><i class="fas fa-trash"></i> {{ __('veacha.button_delete')}}</span>
                                    <span class="someicon float-right comment-edit" href="{{ route('comments.edit',$comment->comment_id) }}" data-fileid="{{ $comment->file_id }}" data-id="{{ $comment->comment_id }}" data-file="{{ $comment->comment_image }}" data-comment="{{ $comment->comment }}" data-toggle="modal" data-target="#modal-lg-comment-edit" ><i class="fas fa-edit"></i> {{ __('veacha.button_edit')}}</span> 
                                    @endif 
                                    {!! nl2br(e($comment->comment)) !!}
                                    <div class="clearfix"></div>
                                    @if($comment->comment_image == "N/A" || $comment->comment_image == null)
                                    @else
                                    <a href="{{ url('download-comments',$comment->comment_image) }}" class=" img img-thumbnail"​​ title="Attachment file">
                                        <span class="fas fa-paperclip"></span> Attachment file
                                    </a>@endif
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                    @foreach($logworks as $logwork)
                        <div class="direct-chat-messages" id="logwork_{{ $logwork->logwork_id }}">
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{ $logwork->username }}</span>
                                    <span class="direct-chat-timestamp">{{ date('d/m/Y h:i A', strtotime($logwork->created_at)) }} </span>
                                </div>
                                <img src="{{ URL::to('/') }}/photos/{{ $logwork->photo }}" class="direct-chat-img img-circle img-size-50" alt="photo">
                                <div class="direct-chat-text">
                                    @if( Auth::user()->id == $logwork->user_id)
                                    <span class="someicon float-right logwork-removed" href="{{ url('logworkremoved',$logwork->logwork_id) }}"><i class="fas fa-trash"></i> Delete</span>
                                    <span class="someicon float-right logwork-edit" href="javascript:void(0)" data-id="{{ $logwork->logwork_id }}" data-fileid="{{ $logwork->file_id }}" data-id="{{ $logwork->logwork_id }}" data-file="{{ $logwork->logwork_image }}" data-elog="{{ $logwork->logwork }}" data-etime="{{ $logwork->time_spent }}" data-edate="{{ $logwork->current_date }}" data-toggle="modal" data-target="#modal-lg-log-work-edit"><i class="fas fa-edit"></i> Edit</span> 
                                    @endif 
                                    <span>Time spent: {{ $logwork->time_spent}}</span><br>
                                    <span>Log date: {{ $logwork->current_date}}</span>
                                    <hr>
                                    <div class="clearfix"></div>
                                    {!! nl2br(e($logwork->logwork)) !!}
                                    <div class="clearfix"></div>
                                    @if($logwork->logwork_image === "N/A" || $logwork->logwork_image === null)
                                    @else
                                    <a href="{{ url('download-logworks',$logwork->logwork_image) }}" class=" img img-thumbnail"​​ title="Attachment file">
                                        <span class="fas fa-paperclip"></span> Attachment file
                                    </a>
                                    @endif
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
</div>

    @include('tasks.modal')

    @endsection 
    @section('js')
    <script>
        $(function () {
            var found = {};
            $('div[id^=comment_]').filter(function() {
                var ending = this.id.replace("comment_","");
                if( found.hasOwnProperty( ending ) ) {
                    return this;
                } else {
                    found[ ending ] = ending;
                }
            }).remove(); 

            var found1 = {};
            $('div[id^=logwork_]').filter(function() {
                var ending = this.id.replace("logwork_","");
                if( found1.hasOwnProperty( ending ) ) {
                    return this;
                } else {
                    found1[ ending ] = ending;
                }
            }).remove(); 

            $(".save-comment").click(function () {
                location.reload();
            });
            $(".edit-comment").click(function () {
                location.reload();
            });
            $(".save-log").click(function () {
                location.reload();
            });
            $(".edit-log").click(function () {
                location.reload();
            });

            $('.logwork-removed').click(function(){
                window.location = $(this).attr('href');
                return false;
            });

            $('.comment-removed').click(function(){
                window.location = $(this).attr('href');
                return false;
            });

            $('body').on('click', '.comment-edit', function (e) {
                $('#comment').val($(this).data('comment'));
                $('#title-files').val($(this).data('file'));
                $('#files').val($(this).data('file'));
                $('#filename').val($(this).data('file'));
                $('#file_id').val($(this).data('fileid'));
                $('#modal-lg-comment-edit').modal('show');
            });

            $('body').on('click', '.logwork-edit', function (e) {
                $('#etime').val($(this).data('etime'));
                $('#edate').val($(this).data('edate'));
                $('#elogwork').val($(this).data('elog'));
                  
                $('#modal-lg-log-work-edit').modal('show');
            });

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                keyboardNavigation: false,
                today: '',
                clear: 'Clear selection',
                close: 'Cancel'
            });

        });

        $(document).on('click', '.browse', function() {
            var file = $(this).parent().parent().parent().find('.file');
            file.trigger('click');
        });

        $(document).on('change', '.file', function() {
            $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        });
        
    </script>
    @include('notification') @endsection