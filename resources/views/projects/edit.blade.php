@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.project')}}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @can('role-create')
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
            <div class="card">
                <div class="card-body table-responsive">
                    <form role="form" action="{{ route('projects.update',$project->id) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.key')}} <i class="text-red">*</i></strong>
                                <input type="text" name="key" class="form-control form-control-sm" style="text-transform:uppercase" placeholder="Enter key" value="{{ $project->key}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.project')}} <i class="text-red">*</i></strong>
                                    <input type="text" name="project" class="form-control form-control-sm" placeholder="Enter project name" value="{{ $project->project}}">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>{{ __('veacha.status')}} <i class="text-red">*</i></strong>
                                    <select name="status" class="select2" class="form-control form-control-sm" data-placeholder="Select members" style="width: 100%; display: block;">
                                        <option value="0" {{ $project->status === 0 ? 'selected' : '' }}>Todo</option>
                                        <option value="1" {{ $project->status === 1 ? 'selected' : '' }}>In-progress</option>
                                        <option value="2" {{ $project->status === 2 ? 'selected' : '' }}>Completed</option> 
                                    </select>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.member')}} <i class="text-red">*</i></strong>
                                    <select name="user_id[]" class="select2" multiple="multiple" class="form-control form-control-sm" data-placeholder="Select members" style="width: 100%; display: block;">
                                        @foreach ($userall as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $project->user_id ? 'selected' : '' }}>{{ $user['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.description') }} <i class="text-red">*</i></strong>
                                <textarea class="form-control form-control-sm" name="description" rows="3" placeholder="Place some text here">{{ $project->description}}</textarea>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="created_by" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="uid" value="{{ Auth::user()->id }}">
                                    <button type="submit" class="btn btn-primary">{{ __('veacha.button_update_project')}}</button>
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