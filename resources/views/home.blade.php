@extends('layouts.app')
@section('content-wrapper')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('veacha.dashboard')}}</h1>
            </div>
            {{-- <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
            --}}
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $commentCount ?? '0'}}</h3>
                    <p>{{ __('veacha.comments')}}</p>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box">
                <div class="inner">
                    <h3>{{ $logworkCount ?? '0' }}</h3>
                    <p>{{ __('veacha.log_work')}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-xs-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('veacha.number_of_users')}}</h5>
                </div>
                <div class="card-body" style="width: 500px">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="chart-responsive">
                                <canvas id="pie-chart-user" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xs-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('veacha.number_of_projects')}}</h5>
                </div>
                <div class="card-body" style="width: 500px">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="chart-responsive">
                                <canvas id="pie-chart-project" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
	//get the pie chart canvas
	var cData = JSON.parse(`<?php echo $chart_data_user; ?>`);
    var ctx = $("#pie-chart-user");
    //pie chart data
    var data = {
        labels: cData.label,
        datasets: [{
            label: "Users Count",
            data: cData.data,
            resize: true,
            backgroundColor: poolColors(cData.data.length),
            borderColor: "#FFFFFF",
            borderWidth: [1, 1, 1, 1, 1, 1, 1],
        }]
    };

    //options
    var options = {
        responsive: true,
        legend: {
            display: true,
            position: "right",
            labels: {
                fontColor: "#333",
                fontSize: 13
            }
        }
    };

    //create Pie Chart class object
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: options
    });

    var cData = JSON.parse(`<?php echo $chart_data_project; ?>`);
    var ctx = $("#pie-chart-project");

    //pie chart data
    var data = {
        labels: cData.label,
        resize: true,
        datasets: [{
            label: "Users Count",
            data: cData.data,
            backgroundColor: poolColors(cData.data.length),
            borderColor: "#FFFFFF",
            borderWidth: [1, 1, 1, 1, 1, 1, 1],
        }]
    };

    //options
    var options = {
        responsive: true,
        legend: {
            display: true,
            position: "right",
            labels: {
                fontColor: "#333",
                fontSize: 13
            }
        },
        tooltips: {
            enabled: true
        }
    };

    //create Pie Chart class object
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: options
    });

    // 1. dynamicColors() to generate random color
    function dynamicColors() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgba(" + r + "," + g + "," + b + ", 0.5)";
    }

    // 2. poolColors() to create array of colors
    function poolColors(a) {
        var pool = [];
        for (i = 0; i < a; i++) {
            pool.push(dynamicColors());
        }
        return pool;
    } 

</script>
@endsection