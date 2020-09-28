@extends('layouts.master')

@section('style')
@endsection

@section('script')
<script type="text/javascript"></script>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{trans('target.sysName')}}</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><span>{{Lang::get('home.sysName')}}</span></a></li>
            <li><a href="/admin">{{Lang::get('target.sysName')}} </a></li>
            <li class="active">{{trans('target.path.index')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('target.path.index')}}</h3>
                    <div class="btn-group pull-right" role="group">
                        <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/target/create'">{{trans('target.path.create')}}</button>
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
                  <th nowrap>{{trans('target.item.listname')}} </th>
                  <th nowrap>{{trans('target.item.parameters')}}</th>
                  <th nowrap>{{trans('target.item.created_at')}}    @include('layouts.sortOrder', ['column' => 'created_at'])</th>
                  <th nowrap>{{trans('target.item.updated_at')}}    @include('layouts.sortOrder', ['column' => 'updated_at'])</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($Lists as $row)
                @if($row->status ==0)
                <tr class="bg-gray disabled color-palette">
                @else
                <tr>
                @endif
                  <td nowrap><a href="/target/edit/{{$row->id}}/"><i class="fa fa-pencil"></i>{{$row->id}}</a></td>
                  <td nowrap>{{$row->name }}</td>
                  <td nowrap>{{trans('target.parameters' . '.' . $row->parameters)}}</td>
                  <td nowrap>{{date(trans('website.date_format'), strtotime($row->created_at))}}</td>
                  <td nowrap>{{date(trans('website.date_format'), strtotime($row->updated_at))}}</td>
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
    </section>
    <!-- /.content -->
</div>
@endsection
