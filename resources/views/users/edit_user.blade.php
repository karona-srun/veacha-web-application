@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.button_edit_user')}}</h1>
            </div>
        </div>
    </div>
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
                <div class="card-body">
                    <form role="form" action="{{ url('updateUser', $user->id) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.name')}} <i class="text-red">*</i></strong>
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Enter name" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.email')}} <i class="text-red">*</i></strong>
                                    <input type="email" name="email" class="form-control form-control-sm" placeholder="Enter email address" value="{{$user->email}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.phone_number')}} <i class="text-red">*</i></strong>
                                    <input type="text" name="phone" class="form-control form-control-sm" placeholder="Enter phone number" value="{{$user->phone}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-primary">{{ __('veacha.button_update_user')}}</button>
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
        $(function () {
        });
    </script>
@include('notification') 
@endsection