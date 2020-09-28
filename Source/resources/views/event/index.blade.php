@extends('layouts.master')

@section('style')
@endsection

@section('script')
@endsection

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{trans('event.sysName')}}</h1>
      <ol class="breadcrumb">
        <li><a href="/home"><span>{{Lang::get('home.sysName') }}</span></a></li>
        <li><a href="/event">{{Lang::get('event.sysName') }} </a></li>
        <li class="active">{{trans('event.path.index')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('event.path.index')}}</h3>
                    <div class="btn-group pull-right" role="group">
                      <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/event/create'">{{trans('event.path.create')}}</button>
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
                                  <th nowrap>{{trans('event.item.eventName')}}        @include('layouts.sortOrder', ['column' => 'status'])</th>
                                  <th nowrap>{{trans('event.item.start_session')}}          @include('layouts.sortOrder', ['column' => 'name'])</th>
                                  <th nowrap>{{trans('event.item.end_session')}}         @include('layouts.sortOrder', ['column' => 'email'])</th>
                                  <th nowrap>{{trans('event.item.target')}}</th>
                                  <th nowrap>{{trans('event.item.updated_at')}}    @include('layouts.sortOrder', ['column' => 'updated_at'])</th>
                                </tr>
                                </thead>
                                <tbody>

                @foreach ($Lists as $row)
                <tr>
                  <td nowrap><a href="/event/edit/{{$row->id}}/"><i class="fa fa-pencil"></i>{{$row->id}}</a></td>
                  <td nowrap>{{$row->event_name }}</td>
                  <td nowrap>{{date(Lang::get('website.date_format_home'), strtotime($row->event_start))}}</td>
                  <td nowrap>{{date(Lang::get('website.date_format_home'), strtotime($row->event_end))}}</td>
                  <td nowrap>{{$row->target_id }}</td>
                  <td nowrap>{{date(Lang::get('website.date_format'), strtotime($row->updated_at))}}</td>
                </tr>
                @endforeach
                                </table>
                            </div><!-- /.table-responsive -->
                        </div><!-- /.col -->
                     </div><!-- /.row -->
                 </div><!-- /.box-body -->
                <div class="box-footer">
                    <!-- Paginator -->{{-- $users->render() --}}<!-- /.Paginator -->
                </div><!-- /.box-footer-->
      </div><!-- /.box -->
      </div><!-- /.col-md-12 -->
    </section>
</div><!-- /.content-wrapper -->
@endsection
