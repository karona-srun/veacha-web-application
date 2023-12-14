@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.role') }}</h1>
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
                    <form role="form" action="{{ route('roles.store') }}" method="POST">
                         {{csrf_field()}}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{ __('veacha.key')}} <i class="text-red">*</i></label>
                                    <input type="text" name="key" class="form-control form-control-sm col-5" id="exampleInputEmail1" placeholder="Enter key">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{ __('veacha.role')}} <i class="text-red">*</i></label>
                                    <input type="text" name="name" class="form-control form-control-sm col-5" id="exampleInputEmail1" placeholder="Enter role name">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{ __('veacha.description')}} <i class="text-red">*</i></label>
                                    <input type="text" name="description" class="form-control form-control-sm col-5" id="exampleInputEmail1" placeholder="Enter description">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{ __('veacha.permission')}} </strong>
                                    <br/> 
                                    @foreach($permission as $value)
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="permission[]" id="{{ $value->id }}" value="{{ $value->id }}">
                                        <label for="{{ $value->id }}" class="custom-control-label">{{ $value->name }}</label>
                                    </div>
                                    <br/>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">{{ __('veacha.submit')}}</button>
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection