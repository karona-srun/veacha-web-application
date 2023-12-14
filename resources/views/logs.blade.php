@extends('layouts.app')
@section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.activities_log')}}</h1>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
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
                        <input type="text" name="table_search" class="form-control float-right" id="searchLog" style="border: 0px;" placeholder="Search log ...">

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
                                <th>{{ __('veacha.user')}}</th>
                                <th>{{ __('veacha.type')}}</th>
                                <th>{{ __('veacha.description')}}</th>
                                <th>{{ __('veacha.created_at')}}</th>
                            </tr>
                        </thead>
                        <tbody id="log">
                            @foreach($logs as $log)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $log->log_name }}</td>
                                <td>{{ $log->user_name }}</td>
                                <td>{{ $log->activity_type }}</td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->created_at }}</td>
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
            $("#searchLog").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#log tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection