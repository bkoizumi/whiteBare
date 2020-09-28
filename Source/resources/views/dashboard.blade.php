@extends('layouts.master')

@section('style')
  <link rel="stylesheet" href="/bower_components/morris.js/morris.css">
@endsection

@section('script')
<!-- ChartJS 1.0.1 -->
<!-- <script src="/plugins/chartjs/Chart.min.js"></script> -->
<script src="/bower_components/chart.js/Chart.js"></script>

<script src="/bower_components/morris.js/morris.min.js"></script>
<script type="text/javascript">
$(function () {

  "use strict";
  /* Morris.js Charts */
  // Sales chart
  var bar = new Morris.Bar({
//     element: 'revenue-chart',
    element: 'bar-chart',
    resize: true,
    data: [
@foreach ($analyzeMonth as $row)
				{y: '{{$row->created_at}}', item1: '{{$row->new_friends}}',    item2: '{{$row->block_friends}}' },
@endforeach

    ],
    xkey: 'y',
    ykeys: ['item1', 'item2'],
    labels: ['新規', 'ブロック'],
    barColors: ['#00a65a', '#f56954'],
//     xLabels: 'day',
    hideHover: 'auto'
  });

});


//-------------
//- PIE CHART -
//-------------
// Get context with jQuery - using jQuery's .get() method.
var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
var pieChart = new Chart(pieChartCanvas);
var PieData = [
  {
    value: 700,
    color: "#f56954",
    highlight: "#f56954",
    label: "iPhone OS 9.2"
  },
  {
    value: 500,
    color: "#00a65a",
    highlight: "#00a65a",
    label: "iPhone OS 10.0.2"
  },
  {
    value: 400,
    color: "#f39c12",
    highlight: "#f39c12",
    label: "Android 5.0.2"
  },
  {
    value: 600,
    color: "#00c0ef",
    highlight: "#00c0ef",
    label: "iPhone OS 8.2"
  },
  {
    value: 300,
    color: "#3c8dbc",
    highlight: "#3c8dbc",
    label: "Android 6.0.1"
  },
  {
    value: 100,
    color: "#d2d6de",
    highlight: "#d2d6de",
    label: "Android 4.2.2"
  }
];
var pieOptions = {
  //Boolean - Whether we should show a stroke on each segment
  segmentShowStroke: true,
  //String - The colour of each segment stroke
  segmentStrokeColor: "#fff",
  //Number - The width of each segment stroke
  segmentStrokeWidth: 1,
  //Number - The percentage of the chart that we cut out of the middle
  percentageInnerCutout: 50, // This is 0 for Pie charts
  //Number - Amount of animation steps
  animationSteps: 100,
  //String - Animation easing effect
  animationEasing: "easeOutBounce",
  //Boolean - Whether we animate the rotation of the Doughnut
  animateRotate: true,
  //Boolean - Whether we animate scaling the Doughnut from the centre
  animateScale: false,
  //Boolean - whether to make the chart responsive to window resizing
  responsive: true,
  // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
  maintainAspectRatio: false,
  //String - A legend template
  legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
  //String - A tooltip template
  tooltipTemplate: "<%=value %> <%=label%> users"
};
//Create pie or douhnut chart
// You can switch between pie and douhnut using the method below.
pieChart.Doughnut(PieData, pieOptions);
//-----------------
//- END PIE CHART -
//-----------------
</script>

@endsection

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{trans('dashboard.sysName')}}</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <a href="/friends">
            <div class="inner">
              <h3>{{$all_friends}}<sub style="font-size: 20px">人</sub></h3>
              <p>{{trans('dashboard.newFriend')}}</p>
            </div>
            <div class="icon"><i class="ion ion-person-stalker"></i></div>
             &nbsp;</a>
          </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
              <a href="/friends">
            <div class="inner">
              <h3>{{$yesterdayFriends}}<sub style="font-size: 20px">人</sub></h3>
              <p>前日の登録数</p>
            </div>
            <div class="icon"><i class="ion ion-android-person-add"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
              <a href="/message/receive">
            <div class="inner">
              <h3>{{$receive_message}}<sub style="font-size: 20px">通</sub></h3>
              <p>{{trans('dashboard.sendMessage')}}</p>
            </div>
            <div class="icon"><i class="ion ion-chatbox-working"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
              <a href="/message">
            <div class="inner">
              <h3>{{$send_message}}<sub style="font-size: 20px">通</sub></h3>
              <p>送信メッセージ数</p>
            </div>
            <div class="icon"><i class="ion ion-paper-airplane"></i></div>
            &nbsp;</a>
          </div>
        </div>
      </div><!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="pull-left header"><i class="fa fa-inbox"></i>{{trans('dashboard.friendCount')}}</li>
            </ul>
<!--             <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart" style="height: 300px;"></div>
             </div> -->
             <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart" style="height: 300px;"></div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->


        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">


          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('dashboard.userAgent')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-7">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-5">
                  <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle-o text-red"></i>iPhone OS 9.2</li>
                    <li><i class="fa fa-circle-o text-green"></i>iPhone OS 10.0.2</li>
                    <li><i class="fa fa-circle-o text-yellow"></i>Android 5.0.22</li>
                    <li><i class="fa fa-circle-o text-aqua"></i>iPhone OS 8.2</li>
                    <li><i class="fa fa-circle-o text-light-blue"></i>Android 6.0.1</li>
                    <li><i class="fa fa-circle-o text-gray"></i>Android 4.2.2</li>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <!-- /.footer -->
          </div>
          <!-- /.box -->



        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
@endsection
