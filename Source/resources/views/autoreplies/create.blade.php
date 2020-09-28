@extends('layouts.master')

@section('style')
@endsection

@section('script')
@endsection

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{trans('autoreplies.sysName')}}</h1>
      <ol class="breadcrumb">
        <li><a href="/home"><span>{{Lang::get('home.sysName') }}</span></a></li>
        <li><a href="/autoreplies">{{Lang::get('autoreplies.sysName') }} </a></li>
        <li class="active">{{trans('autoreplies.path.create')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('autoreplies.path.create')}}</h3>
                    <div class="btn-group pull-right" role="group">
                      <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/autoreplies'">{{trans('autoreplies.path.index')}}</button>
                    </div>
                </div><!-- /.box-header -->


            </div><!-- /.box -->
        </div><!-- /.col -->
        </div><!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
