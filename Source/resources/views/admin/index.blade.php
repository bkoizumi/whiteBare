@extends('layouts.master')

@section('style')
@endsection

@section('script')
<script></script>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{trans('admin.sysName')}}</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><span>{{Lang::get('home.sysName')}}</span></a></li>
            <li><a href="/admin">{{Lang::get('admin.sysName')}} </a></li>
            <li class="active">{{trans('admin.path.index')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('admin.path.index')}}</h3>
                    <div class="btn-group pull-right" role="group">
                        <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/admin/create'">{{trans('admin.path.create')}}</button>
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
                          <th nowrap class="hidden-sm hidden-xs">{{trans('admin.item.status')}}        @include('layouts.sortOrder', ['column' => 'status'])</th>
                          <th nowrap>{{trans('admin.item.name')}}          @include('layouts.sortOrder', ['column' => 'name'])</th>
                          <th nowrap >{{trans('admin.item.email')}}         @include('layouts.sortOrder', ['column' => 'email'])</th>
                          <th nowrap>{{trans('admin.item.authority')}}</th>
                          <th nowrap class="hidden-sm hidden-xs">{{trans('admin.item.locale')}}</th>
                          <th nowrap>{{trans('admin.item.created_at')}}    @include('layouts.sortOrder', ['column' => 'created_at'])</th>
                          <th nowrap class="hidden-sm hidden-xs">{{trans('admin.item.updated_at')}}</th>
                        </tr>
                </thead>
                <tbody>

                @foreach ($Lists as $row)
                @if($row->status ==0)
                <tr class="bg-gray disabled color-palette">
                @else
                <tr>
                @endif
                  <td nowrap><a href="/admin/edit/{{$row->id}}/"><i class="fa fa-pencil"></i>{{$row->id}}</a></td>
                  <td nowrap class="hidden-sm hidden-xs">{{trans('admin.status' . '.' . $row->status)}}</td>
                  <td nowrap>{{$row->name }}</td>
                  <td nowrap>{!! mb_strimwidth(nl2br(e($row->email)), 0, 20, "..."); !!}</td>
                  <td nowrap>{{trans('admin.authority' . '.' . $row->authority)}}</td>
                  <td nowrap class="hidden-sm hidden-xs">{{trans('admin.locale' . '.' . $row->locale)}}</td>
                  <td nowrap>{{date(Lang::get('website.date_format'), strtotime($row->created_at))}}</td>
                  <td nowrap class="hidden-sm hidden-xs">{{date(Lang::get('website.date_format'), strtotime($row->updated_at))}}</td>
                </tr>
                @endforeach
                        </table>
                      </div><!-- /.table-responsive -->
                     </div><!-- /.col -->
                   </div><!-- /.row -->
                </div><!-- /.box-body -->
             </div><!-- /.box -->
        </div><!-- /.col -->
    </section>
    <!-- /.content -->
</div>
@endsection
