@extends('layouts.master')

@section('style')
@endsection

@section('script')
@endsection

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{trans('target.sysName')}}</h1>
      <ol class="breadcrumb">
        <li><a href="/home"><span>{{Lang::get('home.sysName') }}</span></a></li>
        <li><a href="/target">{{Lang::get('target.sysName') }} </a></li>
        <li class="active">{{trans('target.path.index')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('target.path.index')}}</h3>
                    <div class="btn-group pull-right" role="group">
                      <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/target/create'">{{trans('target.path.create')}}</button>
                    </div>
                </div><!-- /.box-header -->
                
                
            </div><!-- /.box -->
        </div><!-- /.col -->
        </div><!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
