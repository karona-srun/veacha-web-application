@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.role_page') }}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @can('role-create')
                    <li class="breadcrumb-item"><a href="{{ route('roles.create') }}" class="btn btn-primary m-0 pull-left">{{ __('veacha.button_new_role')}}</a>
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
                <div class="card-body table-responsive">
                    <div class="input-group input-group-sm" style="width: 250px;border: 1px solid #ced4da;">
                        <input type="text" name="table_search" class="form-control float-right" id="searchRole" style="border: 0px;" placeholder="Search role ...">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th width="20px">{{ __('veacha.no')}}</th>
                            <th>{{ __('veacha.key')}}</th>
                            <th>{{ __('veacha.role')}}</th>
                            <th>{{ __('veacha.description')}}</th>
                            <th width="280px">{{ __('veacha.action')}}</th>
                        </tr>
                        </thead>
                        <tbody id="role">
                        @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $role->key }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                            @can('role-list')<a class="btn btn-outline-primary btn-sm" href="{{ route('roles.show',$role->id) }}" title="View"><i class="fas fa-folder"></i> </a>@endcan 
                            @can('role-edit')<a class="btn btn-outline-primary btn-sm" href="{{ route('roles.edit',$role->id) }}" title="Edit"><i class="fas fa-edit"></i></a>@endcan 
                            @can('role-delete')<form action="{{ route('roles.destroy',$role->id ) }}" method="POST" style="display:inline">
                                    {{ csrf_field() }} {{ method_field('DELETE') }}
                                    <button type="submit" class="btn-outline-danger btn-sm btn-delete" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>@endcan
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $roles->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(function () {
            $("#searchRole").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#role tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@include('notification') 
@endsection