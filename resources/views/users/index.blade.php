@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.user_page')}}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ url('users.export') }}" class="btn btn-primary m-0 pull-left">Export</a>
                    </li> -->
                    <li class="breadcrumb-item"><a href="{{ route('users.create') }}" class="btn btn-primary m-0 pull-left">{{ __('veacha.button_new_user')}}</a>
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
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            <div class="card">

                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <div class="input-group input-group-sm" style="width: 250px;border: 1px solid #ced4da;">
                        <input type="text" name="table_search" class="form-control float-right" id="searchUser" style="border: 0px;" placeholder="Search user ...">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered table-hover display nowrap datatable" id="example" >
                        <thead>
                            <tr>
                                <th>{{ __('veacha.no')}}</th>
                                <th>{{ __('veacha.name')}}</th>
                                <th>{{ __('veacha.photo')}}</th>
                                <th>{{ __('veacha.email')}}</th>
                                <th>{{ __('veacha.role')}}</th>
                                <th width="280px">{{ __('veacha.action')}}</th>
                            </tr>
                        </thead>
                        <tbody id="user">
                            @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $user->name }}</td>
                                <td><img src="{{ URL::to('/') }}/photos/{{ $user->photo }}" class="img-circle img-size-50" alt="" title=""></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(!empty($user->getRoleNames())) @foreach($user->getRoleNames() as $v)
                                    <span class="badge bg-success">{{ $v }}</span>
                                    @endforeach @endif
                                </td>
                                <td>
                                @can('user-edit')<a class="btn btn-outline-primary btn-sm" href="{{ url('changePassword',$user->id) }}" title="Change password"><i class="fas fa-key"></i> </a>@endcan
                                    @if($user->status == 0)
                                    @can('user-edit')<a class="btn btn-outline-danger btn-sm" href="{{ url('userBlock',$user->id) }}" title="Block & Unblock"><i class="fas fa-toggle-off"></i></a>@endcan
                                    @else
                                    @can('user-edit')<a class="btn btn-outline-primary btn-sm" href="{{ url('userBlock',$user->id) }}" title="Block & Unblock"><i class="fas fa-toggle-on"></i></a>@endcan
                                    @endif
                                    @can('user-list')<a class="btn btn-outline-primary btn-sm" href="{{ route('users.show',$user->id) }}" title="Show user"><i class="fas fa-eye"></i></a>@endcan
                                    @can('user-edit')<a class="btn btn-outline-primary btn-sm" href="{{ route('users.edit',$user->id) }}" title="Edit user"><i class="fas fa-edit"></i></a>@endcan
                                    @if(Auth::User()->id == 1)
                                        @can('user-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                        <button type="submit" class="btn-outline-danger btn-sm btn-delete"><i class="fas fa-trash"></i></button>
                                        {!! Form::close() !!}
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(function () {
            $("#searchUser").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#user tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@include('notification') 
@endsection