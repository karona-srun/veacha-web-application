@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.task')}}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @can('role-create')
                    <li class="breadcrumb-item"><a href="{{ route('tasks.show',$task->id ) }}" class="btn btn-primary m-0 pull-left">{{ __('veacha.button_list_project')}}</a>
                    </li>
                    @endcan
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif   
            @if(session('success'))
            <div class="alert alert-success">
            {{ session('success') }}
            </div> 
            @endif         
            <div class="card">
                <div class="card-body table-responsive">
                    <form role="form" action="{{ route('tasks.update',$task->id) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>{{ __('veacha.task')}} <i class="text-red">*</i></strong>
                                    <input type="text" name="ticket" class="form-control form-control-sm" placeholder="Enter ticket" value="{{ $task->task }}">
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>{{ __('veacha.version')}} <i class="text-red">*</i></strong>
                                    <input type="text" name="version" class="form-control form-control-sm" placeholder="Enter version" value="{{ $task->version }}">
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>{{ __('veacha.estimate_time') }}<i class="text-red">* (h)</i></strong>
                                    <input type="number" name="estimate" class="form-control form-control-sm" placeholder="Enter estimate 1h" value="{{ $task->estimate }}">
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{ __('veacha.description')}} <i class="text-red">*</i></strong>
                                    <textarea class="form-control form-control-sm textarea" name="description" rows="10" placeholder="Place some text here">{{ $task->description }}</textarea>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6 col-sm-6 col-xl-6">
                                <strong>{{ __('veacha.attachment_files')}} <i class="text-red">*</i></strong>
                                <div class="input-group control-group increment" >
                                <input type="file" name="file[]" class="form-control form-control-sm" style="height: 36px;">
                                <div class="input-group-btn" style="margin-top: 5px;"> 
                                    <button class="btn btn-primary btn-add-files btn-sm" type="button" style="height: 35px; margin-left:10px;"><i class="fas fa-plus-circle"></i> {{ __('veacha.add_file')}}</button>
                                </div>
                                </div>
                                <div class="clone hide">
                                <div class="control-group input-group" style="margin-top:10px">
                                    <input type="file" name="file[]" class="form-control form-control-sm" style="height: 36px;">
                                    <div class="input-group-btn" style="margin-top: 5px;"> 
                                    <button class="btn btn-danger btn-sm" type="button" style="height: 35px; margin-left:10px;"><i class="fas fa-trash"></i> {{ __('veacha.remove_file')}}</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{ __('veacha.button_update_task')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
    $(".clone").hide();
      $(".btn-add-files").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });

    });
    </script>
    @include('notification')
@endsection