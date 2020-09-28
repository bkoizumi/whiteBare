@extends('layouts.master')



@section('style')

@endsection

@section('script')
<script type="text/javascript">

$(function(){
    $('#modalSubmit').click(function(){
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
    <!-- form start -->
    <form id="inputForm" action="/friends/resist" method="post" >
        <input type="hidden" name="targetId" id="targetId" />
    {{ csrf_field() }}
      <!-- 検索結果表示 -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">{{trans('friends.path.index')}}</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-xs-12">
              <div class="table-responsive">

                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr class="info">
                  <th nowrap>{{trans('friends.list.table.thumbnail')}}</th>
                  <th nowrap>{{trans('friends.list.table.userName')}}</th>
                  <th nowrap class="hidden-sm hidden-xs">{{trans('friends.list.table.lid')}}</th>
                  <th nowrap>{{trans('friends.list.table.created_at')}}  @include('layouts.sortOrder', ['column' => 'created_at'])</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                @foreach ($users as $row)
                @if($row->relation_state ==1)
                <tr class="bg-gray disabled color-palette">
                @else
                <tr>
                @endif
                    <td nowrap>@if($row->relation_state ==0)<input type="checkbox" class="flat-red" name='check[]' value="{{$row->lid}}"  id="{{$row->lid}}">
                  @else <input type="checkbox" class="minimal" disabled="" style="position: absolute; opacity: 0;">
                  @endif
                        <label for="{{$row->lid}}">
                      @if($row->thumbnail_url == '' or ($row->relation_state ==1))<img src='/dist/img/avatar.png' height="30" width="30">
{{--                       @else <a href='{{$row->thumbnail_url}}'  target="_blank"><img src='{{$row->thumbnail_url}}'  height="30" width="30"></a> --}}
                      @else <img src='{{$row->thumbnail_url}}'  height="30" width="30">
                      @endif
                      </label>
                  <td nowrap>{{$row->nick_name}}</td>
                  <td nowrap class="hidden-sm hidden-xs">{{$row->lid}}</td>
                  <td nowrap>{{ date(Lang::get('website.date_format'), strtotime($row->created_at)) }}</td>
                </tr>
                @endforeach

                  </tbody>
                </table>
              </div><!-- /.table-responsive -->
          </div><!-- /.col -->
           </div><!-- /.row -->
          <div class="btn-group pull-right" role="group">
               <button class="btn bg-orange  btn-sm" type="button"  data-toggle="modal" data-target="#staticModal">配信リスト追加</button>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
              <!-- Paginator -->
              {{-- $users->render() --}}
              <!-- /.Paginator -->
        </div><!-- /.box-footer-->

     <!-- モーダルダイアログ -->
      <div class="modal" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
              </button>
              <h4 class="modal-title">{{Lang::get('message.item.targetList')}}</h4>
            </div><!-- /modal-header -->
            <div class="modal-body">
                <select class="form-control select2"  id="targetList">
                    <option>{{Lang::get('website.inputMessage.select.default')}}</option>
                    @foreach ($targetLists as $row)
                    <option value='{{$row->id}}'  @if($row->status ==0)  disabled="disabled" @endif >{{$row->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
              <button type="button" class="btn btn-primary" id="modalSubmit">変更を保存</button>
            </div>
          </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
      </div> <!-- /.modal -->
      </div><!-- /.box -->
</form>


    </section>
    <!-- /.content -->
  </div>
@endsection
