@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.change_password')}}</h1>
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
                    <form role="form" method="POST" action="{{ url('updatePassword',$user->id) }}" novalidate>
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.new_password')}} <i class="text-red">*</i></strong>
                                <input type="password" name="password" class="form-control form-control-sm" id="password" placeholder="New password">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>{{ __('veacha.confirm_password')}} <i class="text-red">*</i></strong>
                                <input type="password" name="confirm-password" class="form-control form-control-sm" id="confirm-password" placeholder="Confirm password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-primary">{{ __('veacha.update_password')}}</button>
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