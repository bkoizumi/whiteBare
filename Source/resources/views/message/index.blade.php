@extends('layouts.master')

@section('style')
@endsection

@section('script')
<script type="text/javascript">
</script>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{trans('message.sysName')}}</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><span>{{Lang::get('home.sysName')}}</span></a></li>
            <li><a href="/message">{{Lang::get('message.sysName')}} </a></li>
            <li class="active">{{trans('message.path.index')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('message.path.index')}}</h3>
                    <div class="btn-group pull-right" role="group">
                        <button type="button" class="btn btn-info  btn-sm "  onClick="location.href='/message/'">{{trans('message.reload')}}</button>
                        <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/message/create'">{{trans('message.path.create')}}</button>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <table id="tableList" class="table table-bordered table-hover">
                                <thead>
                                <tr class="info">
                                  <th nowrap>No  @include('layouts.sortOrder', ['column' => 'id'])</th>
                                  <th nowrap>{{trans('message.item.messageTitle')}} </th>
                                  <th nowrap>{{trans('message.item.targetList')}} </th>
                                  <th nowrap>{{trans('message.item.send_time')}}    @include('layouts.sortOrder', ['column' => 'send_schedule'])</th>
                                  <th nowrap class="hidden-sm hidden-xs">{{trans('message.item.created_at')}}    @include('layouts.sortOrder', ['column' => 'created_at'])</th>
                                  <th nowrap class="hidden-sm hidden-xs">{{trans('message.item.updated_at')}}    @include('layouts.sortOrder', ['column' => 'updated_at'])</th>
                                </tr>
                                </thead>
                                <tbody>
@foreach ($Lists as $row)
                                <tr >
@if($row->status ==1)
                                    <td nowrap><a href="/message/edit/{{$row->id}}/"><i class="fa  fa-list-alt" title="{{trans('message.status.' . $row->status )}}"></i>{{$row->id}}</a></td>
@elseif($row->status ==2)
                                    <td nowrap><i class="fa fa-send" title="{{trans('message.status.' . $row->status )}}"></i>{{$row->id}}</td>
@elseif($row->status ==3)
                                  <td nowrap><a href="/message/edit/{{$row->id}}/"><i class="fa fa-inbox" title="{{trans('message.status.' . $row->status )}}"></i>{{$row->id}}</a></td>
@elseif($row->status ==99)
                                  <td nowrap><a href="/message/edit/{{$row->id}}/"><i class="fa fa-warning" title="{{trans('message.status.' . $row->status )}}"></i>{{$row->id}}</a></td>
@elseif($row->status ==0)
                                    <td nowrap><a href="/message/edit/{{$row->id}}/"><i class="fa fa-pencil" title="{{trans('message.status.' . $row->status )}}"></i>{{$row->id}}</a></td>
@else
                                  <td nowrap><a href="/message/edit/{{$row->id}}/"><i class="" title="{{trans('message.status.' . $row->status )}}"></i>{{$row->id}}</a></td>
@endif
                                  <td nowrap>{{$row->title }}</td>
                                  <td nowrap>@if($row->target_id ==0) 全員@else{{$row->name }}@endif</td>
                                  <td nowrap>{{date(trans('website.date_format'), strtotime($row->send_schedule))}}</td>
                                  <td nowrap class="hidden-sm hidden-xs">{{date(trans('website.date_format'), strtotime($row->created_at))}}</td>
                                  <td nowrap class="hidden-sm hidden-xs">{{date(trans('website.date_format'), strtotime($row->updated_at))}}</td>
                                </tr>
@endforeach
                                </table>
                            </div><!-- /.table-responsive -->
                        </div><!-- /.col -->
                     </div><!-- /.row -->
                 </div><!-- /.box-body -->
                <div class="box-footer">
                    <i class="fa fa-pencil"></i>{{trans('message.status.0' )}}&nbsp;&nbsp;
                    <i class="fa  fa-list-alt"></i>{{trans('message.status.1' )}}&nbsp;&nbsp;
                    <i class="fa fa-send"></i>{{trans('message.status.2' )}}&nbsp;&nbsp;
                    <i class="fa fa-inbox"></i>{{trans('message.status.3' )}}&nbsp;&nbsp;
                    <i class="fa fa-warning"></i>{{trans('message.status.99' )}}
                    <!-- Paginator -->{{-- $users->render() --}}<!-- /.Paginator -->
                </div><!-- /.box-footer-->
      </div><!-- /.box -->
      </div><!-- /.col-md-12 -->
    </section>
</div><!-- /.content-wrapper -->
@endsection
