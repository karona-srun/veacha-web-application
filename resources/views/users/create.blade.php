@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.user')}}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="btn btn-primary m-0 pull-left">{{ __('veacha.button_list_user')}}</a>
                    </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-12">
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
            <div class="card">
                
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.name')}} <i class="text-red">*</i></strong>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-sm" placeholder="Enter name">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.email')}} <i class="text-red">*</i></strong>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-sm" placeholder="Enter email address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.phone_number')}} <i class="text-red">*</i></strong>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control form-control-sm" placeholder="Enter phone number">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.password')}} <i class="text-red">*</i></strong>
                                    <input type="password" name="password" value="{{ old('password') }}" class="form-control form-control-sm" placeholder="Enter password">
                                </div>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.confirm_password')}} <i class="text-red">*</i></strong>
                                    <input type="password" name="confirm-password" value="{{ old('confirm-password') }}"  class="form-control form-control-sm" placeholder="Enter confirm password">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.role')}} <i class="text-red">*</i></strong>
                                    <select name="roles[]" class="select2" multiple="multiple" class="form-control form-control-sm" data-placeholder="Select a role" style="width: 100%;">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.description')}} <i class="text-red">*</i> </strong> 
                                    <textarea class="form-control form-control-sm" rows="2" name="description" placeholder="Enter description">{{ old('description') }}</textarea>
                                </div>
                            </div>                            
                            <div class="col-xs-6 col-sm-6 col-md-6 text-center" style="display: inline-grid; padding-left: 150px;">
                                <img src="{{ asset('dist/img/user_default.png') }}" id="blah" class="img-thumbnail img-size-120" alt="user photo">
                                <input type='file' name="photo" class="btn col-3 btn-primary input-file" style="display: contents;" onchange="readURL(this);"/>
                                <button type="button" class="btn col-3 btn-primary button-photo" style="height: 35px; width: 500px;">{{ __('veacha.photo')}}</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-primary">{{ __('veacha.button_save')}}</button>
                            </div>  
                        </div>
                    </form>

                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </div>
</div>
@endsection