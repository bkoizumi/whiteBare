@extends('layouts.master')



@section('style')
  <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css" rel="stylesheet" />
  <link href="/themes/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" />
@endsection

@section('script')
<script>
$('#reservationtime1').daterangepicker({
  timePicker: false,
  timePickerIncrement: 30,
  singleDatePicker: true,
  locale: {
      format: 'YYYY/MM/DD'
  }
});

$('#reservationtime2').daterangepicker({
    timePicker: false,
    timePickerIncrement: 30,
    locale: {
        format: 'YYYY/MM/DD'
    }
  });

    // //Flat red color scheme for iCheck
    // $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      // checkboxClass: 'icheckbox_flat-green',
      // radioClass: 'iradio_flat-green'
    // });
//
$(function(){
  $('#modalSubmit').click(function(){
    //
    // バリデーションチェックや、データの加工を行う。
    //
$('#staticModal').modal('hide');
    var selectVal = $("#targetList").val();

    $("#targetId").val(selectVal);

    $('#inputForm').submit();
  });
});


</script>

@endsection


@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{trans('friends.sysName')}}</h1>
      <ol class="breadcrumb">
        <li><a href="/home"><span>{{Lang::get('home.sysName') }}</span></a></li>
        <li><a href="/friends">{{Lang::get('friends.sysName') }} </a></li>
        <li class="active">{{trans('friends.path.index')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      {{--
          <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">検索</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">状態</label>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="checkbox" autocomplete="off" checked> 友だち
                        </label>
                        <label class="btn btn-primary">
                            <input type="checkbox" autocomplete="off"> ブロック
                        </label>
                    </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">LID</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="inputPassword3" placeholder="">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">ニックネーム</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="inputPassword3" placeholder="">
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">性別</label>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary">
                            <input type="checkbox" autocomplete="off"> 男性
                        </label>
                        <label class="btn btn-primary">
                            <input type="checkbox" autocomplete="off"> 女性
                        </label>
                    </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">生年月日</label>
                  <div class="col-sm-5">

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="reservationtime1">
                    </div>

                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">お友達登録日</label>
                  <div class="col-sm-5">

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="reservationtime2">
                    </div>

                  </div>
                </div>


              </div>
              <!-- /.box-body -->
              <div class="box-footer center-block">
                <div class="col-sm-3"></div>
                <div class="btn-group" role="group">
                  <button type="reset" class="btn btn-defaul ">リセット</button>
                </div>
                <div class="btn-group" role="group">
                  <button type="submit" class="btn btn-defaul ">検索</button>
                </div>
                <div class="btn-group pull-right" role="group">
                  <button type="submit" class="btn btn-success ">配信リスト登録</button>
                </div>
              </div>
          </div>
          <!-- /.box -->
      </div>
      --}}




      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{trans('friends.path.index')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="inputForm" action="/friends/resist" method="post" >
                <input type="hidden" name="targetId" id="targetId" />
            {{ csrf_field() }}

            <div class="box-body">

              <!-- Paginator -->
              <!-- /.Paginator -->

              <table  id="tableList" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>{{trans('friends.list.table.thumbnail')}}</th>
                  <th>{{trans('friends.list.table.userName')}}</th>
                  <th>{{trans('friends.list.table.created_at')}}  @include('layouts.sortOrder', ['column' => 'created_at'])</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($lists as $row)
                @if($row->status ==1)
                <tr class="bg-gray disabled color-palette">
                @else
                <tr>
                @endif
                  <td> {{$row->id}} </td>
                  <td> {{$row->receive_meg_type}} </td>
                  <td>{{ date(Lang::get('website.date_format'), strtotime($row->created_at)) }}</td>
                </tr>
                @endforeach

                </tbody>
              </table>

              <!-- Paginator -->
              {{-- $users->render() --}}
              <!-- /.Paginator -->

                <div class="btn-group pull-right" role="group">
                  <button class="btn bg-orange  btn-sm" type="button"  data-toggle="modal" data-target="#staticModal">配信リスト追加</button>
                </div>
            </div>
            <!-- /.box-body -->

          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->




    </section>
    <!-- /.content -->
  </div>
@endsection
