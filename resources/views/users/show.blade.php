@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.users')}}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="btn btn-primary m-0 pull-left">{{ __('veacha.user_page')}}</a>
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
           <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="{{ asset('photos/'.$user->photo) }}" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->name}}</h3>
                @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                        <p class="text-muted text-center">{{ $v }}</p>
                    @endforeach
                @endif

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                  <b>{{ __('veacha.name')}}: </b> <a>{{ $user->name}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>{{ __('veacha.email')}}: </b> <a>{{ $user->email}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>{{ __('veacha.phone_number')}}: </b> <a>{{ $user->phone}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>{{ __('veacha.description')}}: </b> <a>{{ $user->description}}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>            
        </div>
    </div>
</div>
@endsection