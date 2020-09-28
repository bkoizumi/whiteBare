@extends('layouts.master')

@section('style')
@endsection

@section('script')
@endsection

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{trans('home.sysName')}}</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <a href="/dashboard">
            <div class="inner">
                <h3>&nbsp;</h3><p>ダッシュボード</p>
            </div>
            <div class="icon"><i class="ion ion-stats-bars"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <a href="/friends">
            <div class="inner">
                <h3>&nbsp;</h3><p>{{trans('friends.sysName')}}</p>
            </div>
            <div class="icon"><i class="ion ion-android-person-add"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <a href="/target">
            <div class="inner">
              <h3>&nbsp;</h3><p>{{trans('target.sysName')}}</p>
            </div>
            <div class="icon"><i class="ion ion-ios-calendar-outline"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <a href="/message">
            <div class="inner">
              <h3>&nbsp;</h3><p>{{trans('message.sysName')}}</p>
            </div>
            <div class="icon"><i class="ion ion-ios-email-outline"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->
      </div><!-- /.row -->



     <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <a href="/keywords">
            <div class="inner">
              <h3>&nbsp;</h3><p>{{trans('keywords.sysName')}}</p>
            </div>
            <div class="icon"><i class="ion ion-ios-paperplane-outline"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <a href="/event">
            <div class="inner">
              <h3>&nbsp;</h3><p>{{trans('event.sysName') }}</p>
            </div>
            <div class="icon"><i class="ion ion-flame"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <a href="/admin">
            <div class="inner">
              <h3>&nbsp;</h3><p>{{trans('admin.sysName')}}</p>
            </div>
            <div class="icon"><i class="ion ion-ios-gear"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <a href="/config">
            <div class="inner">
              <h3>&nbsp;</h3><p>{{trans('config.sysName')}}</p>
            </div>
            <div class="icon"><i class="ion ion-ios-gear"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->
      </div><!-- /.row -->

     <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <a href="/message/receive">
            <div class="inner">
              <h3>&nbsp;</h3><p>受信メッセージ</p>
            </div>
            <div class="icon"><i class="ion ion-ios-chatboxes-outline"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <a href="#">
            <div class="inner">
              <h3>&nbsp;</h3><p>マニュアル</p>
            </div>
            <div class="icon"><i class="ion ion-clipboard"></i></div>
            &nbsp;</a>
          </div>
        </div><!-- ./col -->

    </section>
  </div><!-- /.content-wrapper -->
@endsection
