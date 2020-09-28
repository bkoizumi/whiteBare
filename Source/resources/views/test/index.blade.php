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
                
               <div class="row">
                    <!-- col -->
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">ボックスタイトル左</h3>
                            </div>
                            <div class="box-body">
               <div class="row">
                    <!-- col -->
                    <div class="col-xs-7">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                              <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                              <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                              <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                            </ol>
                            <div class="carousel-inner">
                              <div class="item active">
                                <img src="/receipt/receipt01.jpg" alt="First slide">
                                <div class="carousel-caption">First Slide</div>
                              </div>
                              
                              <div class="item">
                                <img src="/receipt/receipt02.jpg" alt="Second slide">
                                <div class="carousel-caption">Second Slide</div>
                              </div>
                              
                              <div class="item">
                                <img src="/receipt/receipt03.jpg" alt="Third slide">
                                <div class="carousel-caption">Third Slide</div>
                              </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                              <span class="fa fa-angle-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                              <span class="fa fa-angle-right"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col-xs-5">
                            <p>ボックスボディー</p>
                    </div>





                    </div>


                            </div>
                        </div>
                    </div>



            </div><!-- /.box -->
        </div><!-- /.col -->
        </div><!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
