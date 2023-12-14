@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('veacha.project')}}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @can('project-edit')
                    <li class="breadcrumb-item"><a href="{{ route('projects.edit',$project->id) }}" class="btn btn-primary m-0 pull-left">{{ __('veacha.button_edit_project')}}</a>
                    </li>
                    @endcan
                    @can('project-list')
                    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="btn btn-primary m-0 pull-left">{{ __('veacha.button_list_project')}}</a>
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
            <div class="">
                <div class="">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('veacha.project_name') }}: </dt>
                                <dd class="col-sm-8">{{ $project->project }}</dd>
                                <dt class="col-sm-4">{{ __('veacha.key')}}: </dt>
                                <dd class="col-sm-8" style="text-transform:uppercase">{{ $project->key}}</dd>
                                <dt class="col-sm-4">{{ __('veacha.created_by')}}: </dt>
                                <dd class="col-sm-8">{{ $project->created_by}}</dd>
                                <dt class="col-sm-4">{{ __('veacha.created_at')}}: </dt>
                                <dd class="col-sm-8" style="text-transform:uppercase">{{ $project->created_at->format('d/m/Y h:i A') }}</dd>
                            </dl>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <dl class="row">
                                <dt class="col-auto" style="margin-top: 5px;">{{ __('veacha.status')}}: </dt>
                                <dd class="col-sm-10 float-right">
                                    <button type="button" class="btn btn-primary dropdown-toggle col-sm-4" data-toggle="dropdown">
                                        @if($project->status === 0) Open
                                        @elseif($project->status === 1) Invalid
                                        @elseif($project->status === 2) Duplicate
                                        @else Close @endif
                                    </button>
                                    @can('user-edit')
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ url('changestatusproject/0',$project->id) }}">Open</a>
                                        <a class="dropdown-item" href="{{ url('changestatusproject/1',$project->id) }}">Invalid</a>
                                        <a class="dropdown-item" href="{{ url('changestatusproject/2',$project->id) }}">Duplicate</a>
                                        <a class="dropdown-item" href="{{ url('changestatusproject/3',$project->id) }}">Close</a>
                                    </div>
                                    @endcan
                                </dd>
                            </dl>
                            <div class="form-group">
                                <strong>{{ __('veacha.member')}}</strong>
                                <div class="clearfix" style="margin-bottom: 5px;"></div>
                                @foreach ($users as $user)
                                <img src="{{ URL::to('/') }}/photos/{{ $user->photo }}" class="img-circle img-size-32" alt="photo" title="{{ $user->name }}"> @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                    <dl class="row">
                        <dt class="col-auto">{{ __('veacha.description')}}: </dt>
                        <dd class="col-sm-8">{{ $project->description}}</dd>
                    </dl>
                </div>
            </div>

            <hr>
            <br>
            <div class="row">
                <div class="col-12 col-md-12 col-xs-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('veacha.task_list') }}</h3>
                            <div class="float-right">
                            @can('task-create')<a href="{{ url('create-task',$project->id) }}" class="btn btn-sm btn-primary">{{ __('veacha.button_new_task') }}</a>@endcan
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="input-group input-group-sm" style="width: 250px;border: 1px solid #ced4da;">
                                <input type="text" name="table_search" class="form-control float-right" id="searchTask" style="border: 0px;" placeholder="Search task ...">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            
                            <br>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="50px">{{ __('veacha.no')}}</th>
                                        <th>{{ __('veacha.task')}}</th>
                                        {{-- <th>{{ __('veacha.status')}}</th> --}}
                                        <th>{{ __('veacha.created_by')}}</th>
                                        <th>{{ __('veacha.created_at')}}</th>
                                    </tr>
                                </thead>
                                <tbody id="task">
                                    @foreach ($tasks as $i => $ticket)

                                    <tr href="{{ route('tasks.show',$ticket->id) }}">
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $ticket->task }}</td>
                                        {{-- <td>{{ $ticket->status }}</td> --}}
                                        <td>{{ $ticket->created_by }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('js')
@include('notification') 
<script>
    $(function () {
        $('table tbody tr').click(function(){
            window.location = $(this).attr('href');
            return false;
        });
        $('table tr').css('cursor', 'pointer');
        $("#searchTask").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#task tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $('.dropdown-item').click(function(){
            //alert($(this).attr('href'));
            window.location = $(this).attr('href');
            return false;
        });
    });
</script>
@endsection