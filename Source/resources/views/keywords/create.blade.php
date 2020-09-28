@extends('layouts.master') @section('style')
<link rel="stylesheet" href="/plugins/flatpickr/themes/material_blue.css">
<link rel="stylesheet" href="/plugins/clockpicker/jquery-clockpicker.min.css">
<link rel="stylesheet" href="/dist/css/message.css">

@endsection @section('script')
<script src="/plugins/flatpickr/flatpickr.min.js" type="text/javascript"></script>
<script src="/plugins/flatpickr/l10n/ja.js" type="text/javascript"></script>
<script src="/plugins/jQuery/jquery.uploadThumbs.js" type="text/javascript"></script>
<script src="/dist/js/sendMessage.js" type="text/javascript"></script>

<script type="text/javascript">


</script>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{trans('keywords.sysName')}}</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home"></i><span>{{Lang::get('home.sysName')}}</span></a></li>
            <li><a href="/keywords"><i class="fa fa-envelope"></i>{{Lang::get('keywords.sysName')}}</a></li>
            <li class="active">{{trans('keywords.path.create')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('keywords.path.create')}}</h3>
                <div class="btn-group pull-right" role="group">
                    <button type="button" class="btn bg-orange  btn-sm " onClick="location.href='/keywords'">{{trans('keywords.path.index')}}</button>
                </div>
            </div>
            <!-- form start -->
            <form id="inputForm" action="/keywords/resist" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="box-body">

                    <!-- タイトル -->
                    <div class="form-group">
                        <label>{{Lang::get('keywords.item.managementTitle')}}</label> <input type="text" name="title" class="form-control" id="input1" placeholder="">
                    </div>

                    <!-- 期間 -->
                      <div class="form-group @if(!empty($errors->first('date'))) has-error @endif">
                        <label for="exampleInputFile">期間</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control dateRangePicker" name="date" value="{{old('date')}}" >
                        </div>
                    </div>

                    <!-- 受信メッセージ -->
                      <div class="form-group @if(!empty($errors->first('date'))) has-error @endif">
                        <label for="exampleInputFile">受信メッセージ</label>
                            <input type="text" class="form-control" name="receive_message" value="{{old('receive_message')}}">
                    </div>

                    @include('layouts.messageInput')


                    <!-- 備考 -->
                    <div class="form-group @if(!empty($errors->first('notes'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('target.item.notes')}}</label>
                        <textarea class="form-control" rows="3"  name="notes"  placeholder="">{{old('notes')}}</textarea>
                        <span class="help-block">{{$errors->first('notes')}}</span>
                    </div>


                    <!-- 状態 -->
                    <div class="form-group @if(!empty($errors->first('status'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('target.item.status')}}</label>
                        <div data-toggle="buttons">
                            <label class="btn btn-primary active"><input type="radio" name="status" value ="1" autocomplete="off" checked>{{trans('target.status.1')}}</label>
                            <label class="btn btn-primary"><input type="radio" name="status"  value ="0" autocomplete="off">{{trans('target.status.0')}}</label>
                        </div>
                        <span class="help-block">{{$errors->first('status')}}</span>
                    </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success " id="btn_create">{{trans('website.form.submit')}}</button>
              </div><!-- /.box-footer -->
            </form>
       </div><!-- /.box-primary -->
    </section><!-- /.content -->
</div>
@endsection
