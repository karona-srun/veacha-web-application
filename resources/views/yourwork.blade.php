@extends('layouts.app') @section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('veacha.log_work')}}</h1>
            </div>
        </div>
    </div>
</div>
@endsection @section('content')
<div class="container-fluid">
<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $commentCount }}</h3>

                <p>{{ __('veacha.comments')}}</p>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box">
              <div class="inner">
                <h3>{{ $logworkCount }}</h3>

                <p>{{ __('veacha.log_work')}}</p>
              </div>
            </div>
          </div>
          <!-- ./col -->
          
        </div>
    
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="card">
                <div class="card-body table-responsive">                    
                <div class="input-group input-group-sm" style="width: 250px;border: 1px solid #ced4da;">
                                <input type="text" name="table_search" class="form-control float-right" id="searchProject" style="border: 0px;" placeholder="Search project ...">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="50px">{{ __('veacha.no')}}</th>
                            <th>{{ __('veacha.key')}}</th>
                            <th>{{ __('veacha.project')}}</th>
                            <th>{{ __('veacha.description')}}</th>
                            <th>{{ __('veacha.status')}}</th>
                        </tr>
                        </thead>
                        <tbody id="project">
                        @foreach ($projects as $key => $project)    
                        
                        <tr href="{{ route('projects.show',$project->project_id) }}">                            
                            <td>{{ ++$i }}</td>
                            <td style="text-transform:uppercase">{{ $project->key }}</td>
                            <td>{{ $project->project }}</td>
                            
                            <td>{{substr(strip_tags($project->description),0,50)}}...</td>  
                            <td>
                                @if($project->status === 0)
                                <span class="badge bg-primary">Open</span>
                                @elseif($project->status === 1)
                                <span class="badge bg-warning">Invalid</span>
                                @elseif($project->status === 2)
                                <span class="badge bg-success">Duplicate</span>
                                @else
                                <span class="badge bg-danger">Close</span>
                                @endif
                            </td>                                                     
                        </tr>
                        
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                    {!! $projects->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script>
        $(function () {
            $('table tbody tr').click(function(){
                window.location = $(this).attr('href');
                return false;
            });
            $('table tr').css('cursor', 'pointer');
            $("#searchProject").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#project tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    @include('notification')
@endsection