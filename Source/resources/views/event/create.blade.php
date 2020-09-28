@extends('layouts.master')

@section('style')
<link rel="stylesheet" href="/plugins/flatpickr/themes/material_blue.css">
<link rel="stylesheet" href="/plugins/clockpicker/jquery-clockpicker.min.css">

@endsection

@section('script')
<script src="/plugins/clockpicker/bootstrap-clockpicker.min.js"></script>
<script src="/plugins/flatpickr/flatpickr.min.js"></script>
<script src="/plugins/flatpickr/l10n/ja.js"></script>

<script type="text/javascript">
//カレンダーの表示
flatpickr('#event_date', {
    "locale": "ja",
    enableTime: true,
    time_24hr: true,
    minDate: "today"
});

//カレンダーの表示
flatpickr('#start_date', {
    "locale": "ja"
    ,dateFormat: "Y/m/d"
    //,enableTime: true
    //,time_24hr: true
    ,mode: "range"        //範囲指定
    ,minDate: "today"     //選択可能な最小の日付
    //,maxDate: "today"     //選択可能な最大の日付
});


$(".select2").select2();
</script>
@endsection

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{trans('event.sysName')}}</h1>
      <ol class="breadcrumb">
        <li><a href="/home"><span>{{Lang::get('home.sysName') }}</span></a></li>
        <li><a href="/event">{{Lang::get('event.sysName') }} </a></li>
        <li class="active">{{trans('event.path.create')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('admin.path.create')}}</h3>
                <div class="btn-group pull-right" role="group">
                    <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/event'">{{trans('event.path.index')}}</button>
                </div>
            </div>


@if(count($errors) > 0)
        <div class="col-xs-12">
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="icon fa fa-ban"></i>{{trans('website.systemCode.400' )}}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
@foreach ($errors->all() as $error)
                <span class="text-red">{{ $error }}<br /></span>
@endforeach
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
@elseif ( session('systemCode') == 200)
        <div class="col-xs-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="icon fa fa-check"></i>ssss</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
@else
@endif

            <!-- form start -->
            <form id="inputForm" action="/event/resist" method="post"  enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">

                    <!--  イベント名称  -->
                    <div class="form-group @if(!empty($errors->first('listname'))) has-error @endif">
                        <label for="exampleInputEmail1">{{trans('event.item.eventName')}}</label>
                        <input type="text" name="eventName"  class="form-control" placeholder=""  value="{{old('eventName')}}">
                        <span class="help-block">{{$errors->first('listname')}}</span>
                    </div>

                    <!--  イベント実施日  -->
                    <div class="form-group @if(!empty($errors->first('event_date'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('event.item.event_date')}}</label>
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" class="form-control datepicker" name="event_date"  value="{{old('event_date')}}"  id="event_date">
                                </div>
                    </div>

                    <!--  イベント開催地  -->
                    <div class="form-group @if(!empty($errors->first('event_place'))) has-error @endif">
                        <label for="exampleInputEmail1">{{trans('event.item.event_place')}}</label>
                        <input type="text" name="event_place"  class="form-control" placeholder=""  value="{{old('event_place')}}">
                        <span class="help-block">{{$errors->first('event_place')}}</span>
                    </div>

                    <!-- 開始日時 -->
                <div class="form-group @if(!empty($errors->first('send_date'))) has-error @endif">
                    <label for="exampleInputFile">{{trans('message.item.send_time')}}</label>
                           <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control datepicker" name="start_date" value="{{old('start_date')}}" id="start_date" >
                        </div>
                </div>

                    <!-- 配信リスト -->
                    <div class="form-group @if(!empty($errors->first('notes'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('event.item.target')}}</label>
                        <select class="form-control select2" style="width: 100%;" name="target">
                            @foreach ($Lists as $row)
                            <option value='{{$row->id}}'  @if($row->status ==0)  disabled="disabled" @endif >{{$row->name}}</option>
                            @endforeach
                        </select>
                    </div><!-- /.form group -->


                    <!-- 状態 -->
                    <div class="form-group @if(!empty($errors->first('status'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('event.item.status')}}</label>
                        <div data-toggle="buttons">
                            <label class="btn btn-primary active"><input type="radio" name="status" value ="1" autocomplete="off" checked>{{trans('event.status.1')}}</label>
                            <label class="btn btn-primary"><input type="radio" name="status"  value ="0" autocomplete="off">{{trans('event.status.0')}}</label>
                        </div>
                        <span class="help-block">{{$errors->first('status')}}</span>
                    </div>
              </div><!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success " id="btn_create">{{trans('website.form.submit')}}</button>
              </div><!-- /.box-footer -->
            </form>
          </div><!-- /.box -->
      </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
@endsection
