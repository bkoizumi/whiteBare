@extends('layouts.master')

@section('style')
@endsection

@section('script')
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
          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-primary direct-chat direct-chat-success">
            <div class="box-header with-border">
              <h3 class="box-title">{{$getUserInfo->nick_name}}</h3>
                    <div class="btn-group pull-right" role="group">
                      <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/message/receive'">{{trans('message.path.receive')}}</button>
                    </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
              
                  @foreach ($MegLists as $row)
                  @if($row->meg_type == 'receive')
                      @include('message.receiveMegDetailUser')
                  @else
                   @include('message.receiveMegDetailSystem')
                  @endif
                  @endforeach
              
              
              </div><!--/.direct-chat-messages-->


            </div><!-- /.box-body -->
            <div class="box-footer">
              <form action="/message/receive/send" method="post">
                <input type="hidden" name="lid" value="{{$getUserInfo->lid}}" >
                {{ csrf_field() }}
                <div class="input-group">
                  <textarea name="message" class="form-control" rows="1" placeholder="Type Message ..."></textarea>
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat">Send</button>
                      </span>
                </div>
              </form>
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>
        <!-- /.col -->









    </section>
    <!-- /.content -->
</div>
@endsection
