@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.button_new_project')}}</h1>
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
                    <form role="form" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>{{ __('veacha.key') }} <i class="text-red">*</i></strong>
                                    <input type="text" name="key" value="{{ old('key') }}" class="form-control form-control-sm" style="text-transform:uppercase" placeholder="Enter key">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>{{ __('veacha.project') }} <i class="text-red">*</i></strong>
                                    <input type="text" name="project" value="{{ old('project') }}" class="form-control form-control-sm" placeholder="Enter project name">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>{{ __('veacha.member')}} <i class="text-red">*</i></strong>
                                    <br>
                                    <select name="user_id[]" class="select2" multiple="multiple" class="form-control form-control-sm" data-placeholder="Select members" style="width: 100%; display: block;">
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>{{ __('veacha.description') }} <i class="text-red">*</i></strong>
                                    <textarea class="form-control form-control-sm" name="description" rows="3" placeholder="Place some text here">{{ old('description') }}</textarea>
                                    
                                </div>
                            </div>
                            {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description <i class="text-red">*</i></strong>
                                    <textarea class="textarea" name="description" rows="50" placeholder="Place some text here"
                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                </div>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="created_by" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="uid" value="{{ Auth::user()->id }}">
                                    <button type="submit" class="btn btn-primary">{{ __('veacha.button_save_project')}}</button>
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