@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.role')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @can('role-create')
                    <li class="breadcrumb-item"><a href="{{ route('roles.create') }}" class="btn btn-primary m-0 pull-left">{{ __('veacha.add_role')}}</a>
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
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            <div class="card">
                
                <div class="card-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <br>
                        <br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form role="form" action="{{ route('roles.update', $role->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="row">                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{ __('veacha.key')}} <i class="text-red">*</i></label>
                                    <input type="text" name="key" class="form-control form-control-sm col-5" id="exampleInputEmail1" value="{{ $role->key}}" placeholder="Enter key">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{ __('veacha.role')}} <i class="text-red">*</i></label>
                                    <input type="text" name="name" class="form-control form-control-sm col-5" id="exampleInputEmail1" value="{{ $role->name}}" placeholder="Enter role name">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{ __('veacha.description')}} <i class="text-red">*</i></label>
                                    <input type="text" name="description" class="form-control form-control-sm col-5" id="exampleInputEmail1" value="{{ $role->description}}" placeholder="Enter description">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{ __('veacha.permission') }}</strong>
                                    <br/>
                                    @foreach($permission as $value)
                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                        {{ $value->name }}</label><br/>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">{{ __('veacha.submit')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection