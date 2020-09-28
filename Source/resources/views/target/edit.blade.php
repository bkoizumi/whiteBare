@extends('layouts.master')

@section('style')
@endsection

@section('script')
<script type="text/javascript">
$('#btn_create').click(function(e) {
        e.preventDefault();
        $('#inputForm').submit();
    });
</script>
@endsection

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{trans('target.sysName')}}</h1>
      <ol class="breadcrumb">
        <li><a href="/home"><span>{{Lang::get('home.sysName') }}</span></a></li>
        <li><a href="/target">{{Lang::get('target.sysName') }} </a></li>
        <li class="active">{{trans('target.path.edit')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('admin.path.edit')}}</h3>
                <div class="btn-group pull-right" role="group">
                    <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/target'">{{trans('target.path.index')}}</button>
                </div>
            </div>


@if(count($errors) > 0)
        <div class="col-md-12">
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
        <div class="col-md-12">
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

<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">登録情報</a></li>
              <li><a href="#tab_2" data-toggle="tab">登録者</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
            <!-- form start -->
            <form id="inputForm" action="/target/resist" method="post"  enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{$listInfo->id}}" >
            {{ csrf_field() }}
              <div class="box-body">
                  <!--  CSVファイル添付  -->
                  <div class="form-group @if(!empty($errors->first('csvFile'))) has-error @endif">
                      <label for="exampleInputFile">{{trans('target.item.csvFile')}}</label>
                      <input type="file" name="csvFile">
                      <p class="help-block">{{trans('target.comment.csvFile')}}</p>
                      <span class="help-block">{{$errors->first('csvFile')}}</span>
                  </div>


                    <!--  リスト名称  -->
                    <div class="form-group @if(!empty($errors->first('listname'))) has-error @endif">
                        <label for="exampleInputEmail1">{{trans('target.item.listname')}}</label>
                        <input type="text" name="listname"  class="form-control" placeholder=""  value="{{$listInfo->name}}">
                        <span class="help-block">{{$errors->first('listname')}}</span>
                    </div>

                    <!-- パラメータ -->
                      <div class="form-group @if(!empty($errors->first('parameters'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('target.item.parameters')}}</label>
                        <div  data-toggle="buttons">
                            <label class="btn btn-primary @if($listInfo->parameters== "0") active @endif "><input type="radio" name="parameters" value ="0"  autocomplete="off" @if($listInfo->parameters=='0') checked  @endif>{{trans('target.parameters.0')}}</label>
                            <label class="btn btn-primary @if($listInfo->parameters== "1") active @endif "><input type="radio" name="parameters" value ="1" autocomplete="off" @if($listInfo->parameters=='1') checked  @endif>{{trans('target.parameters.1')}}</label>
                            <span class="help-block">{{$errors->first('parameters')}}</span>
                        </div>
                    </div>

                    <!-- 備考 -->
                    <div class="form-group @if(!empty($errors->first('notes'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('target.item.notes')}}</label>
                        <textarea class="form-control" rows="3"  name="notes"  placeholder="">{{$listInfo->notes}}</textarea>
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
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <table id="tableList" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>{{trans('friends.list.table.thumbnail')}}</th>
                  <th>{{trans('friends.list.table.userName')}}</th>
                  <th class="hidden-xs">{{trans('friends.list.table.lid')}}</th>
                  <th>{{trans('friends.list.table.created_at')}} </th>
                </tr>
                </thead>
                <tbody>

                @foreach ($targetList as $row)
                <tr>
                  <td><input type="checkbox" class="flat-red" name='check[]' value="{{$row->lid}}" id="{{$row->lid}}">
                      @if($row->thumbnail_url == '')<img src='/dist/img/avatar.png' height="30" width="30"> @else <img src='{{$row->thumbnail_url}}' height="30" width="30">@endif
                  <td> {{$row->nick_name}} </td>
                  <td class="hidden-xs">{{$row->lid}}</td>
                  <td>{{ date(Lang::get('website.date_format'), strtotime($row->created_at)) }}</td>
                </tr>
                @endforeach
                </tfoot>
                </table>
              </div>
              <!-- /.tab-pane -->

            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->


















          </div><!-- /.box -->
      </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
@endsection
