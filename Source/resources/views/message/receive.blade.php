@extends('layouts.master')

@section('style')
<link rel="stylesheet" href="/dist/css/message.css">
@endsection

@section('script')
<script src="/dist/js/jquery.textOverflowEllipsis.js" type="text/javascript"></script>
<script>
$(function() {
  $('.textOverflowReceiveMessage').textOverflowEllipsis({
    resize: true, // ウィンドウリサイズ時に追従するか
    numOfCharactersToReduce : 1, // 高さ計算するときに削る文字数
    suffix: '...' // 省略記号
  });
});
</script>
@endsection

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{trans('message.sysName')}}</h1>
      <ol class="breadcrumb">
        <li><a href="/home"><span>{{Lang::get('home.sysName') }}</span></a></li>
        <li><a href="/message">{{Lang::get('message.sysName') }} </a></li>
        <li class="active">{{trans('message.path.receive')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('message.path.receive')}}</h3>
                    <div class="btn-group pull-right" role="group">
                      <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/message/receive'">{{trans('message.path.receive')}}</button>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body">
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="table-responsive">
                        <table id="tableList" class="table table-bordered table-hover">
                        <thead>
                        <tr class="info">
                          <th nowrap>No</th>
                          <th nowrap>{{trans('message.item.nick_name')}}</th>
                          <th nowrap>{{trans('message.item.Meg')}} </th>
                          <th nowrap>{{trans('message.item.created_at')}} </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($Lists as $row)
                        <tr>
                            <td nowrap><a href='/message/receive/{{$row->lid}}'><i class="fa fa-inbox" aria-hidden="true"></i></a></td>
                            <td nowrap>{{$row->nick_name }}</td>
                            <td nowrap class="message">{!! mb_strimwidth(nl2br(e($row->message)), 0, 45, "..."); !!}</td>
                            <td nowrap>{{date(Lang::get('website.date_format'), strtotime($row->created_at))}}</td>
                        </tr>
                        @endforeach
                        </tfoot>
                        </table>
                      </div><!-- /.table-responsive -->
                     </div><!-- /.col -->
                   </div><!-- /.row -->
                </div><!-- /.box-body -->



            </div><!-- /.box -->
        </div><!-- /.col -->
        </div><!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
