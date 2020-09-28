@extends('layouts.master')

@section('style')
@endsection

@section('script')
<script>
$('#btn_create').click(function(e) {
        e.preventDefault();
        $('#inputForm').submit();
    });
</script>
@endsection


@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>{{trans('admin.sysName')}}</h1>
      <ol class="breadcrumb">
        <li><a href="/home"><span>{{Lang::get('home.sysName') }}</span></a></li>
        <li><a href="/home">{{Lang::get('admin.sysName') }} </a></li>
        <li class="active">{{trans('admin.path.edit')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">{{trans('admin.path.edit')}}</h3>
                <div class="btn-group pull-right" role="group">
                    <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/admin/create'">{{trans('admin.path.create')}}</button>
                </div>
            </div>

@if ($systemCode ==  400)
        <div class="col-md-12">
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="icon fa fa-ban"></i>{{trans('website.systemCode.' . $systemCode )}}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
@foreach ($errorMeg as $error)
                {{ $error }}<br>
@endforeach
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
@elseif($systemCode == "200")
        <div class="col-md-12">
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="icon fa fa-check"></i>{{trans('website.systemCode.' . $systemCode )}}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
@else
@endif

            <!-- form start -->
            <form id="inputForm"  action="/admin/resist" method="post">
            <input type="hidden" name="id" value="{{$userInfo->id}}" >
            {{ csrf_field() }}
              <div class="box-body">
                    <!-- メールアドレス -->
                    <div class="form-group @if(!empty($errors->first('email'))) has-error @endif">
                        <label for="exampleInputEmail">{{trans('admin.item.email')}}</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="" value="{{$userInfo->email}}">
                        <span class="help-block">{{$errors->first('email')}}</span>
                    </div>

                    <!-- パスワード -->
                    <div class="form-group @if(!empty($errors->first('password'))) has-error @endif">
                        <label for="exampleInputPassword1">{{trans('admin.item.password')}}</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="" value="">
                        <span class="help-block">{{$errors->first('password')}}</span>
                    </div>

                    <!-- 氏名 -->
                    <div class="form-group @if(!empty($errors->first('name'))) has-error @endif">
                        <label for="exampleInputName">{{trans('admin.item.name')}}</label>
                        <input type="text" name='name' class="form-control" id="exampleInputName" placeholder="" value="{{$userInfo->name}}">
                        <span class="help-block">{{$errors->first('name')}}</span>
                    </div>



                    <!-- LID -->
                    <div class="form-group @if(!empty($errors->first('lid'))) has-error @endif">
                        <label for="exampleInputLid">{{trans('admin.item.lid')}}</label>
                        <input type="text" class="form-control" id="lid" name="lid" placeholder="" value="{{$userInfo->lid}}">
                        <span class="help-block">{{$errors->first('lid')}}</span>
                    </div>



                    <!-- 権限 -->
                    <div class="form-group @if(!empty($errors->first('authority'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('admin.item.authority')}}</label>
                        <select class="form-control" name="authority" >
                            @for ($i = 1; $i < 6; $i++)
                            <option value ="{{$i}}" @if($userInfo->authority== $i) selected @endif >{{trans('admin.authority.' . $i )}}</option>
                            @endfor
                        </select>
                        <span class="help-block">{{$errors->first('authority')}}</span>
                    </div>


                    <!-- 言語 -->
                    <div class="form-group @if(!empty($errors->first('locale'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('admin.item.locale')}}</label>
                        <div  data-toggle="buttons">
                            <label class="btn btn-primary @if($userInfo->locale== "ja") active @endif"><input type="radio" name="locale" value ="ja"  autocomplete="off" @if($userInfo->locale=='ja') checked  @endif>{{trans('admin.locale.ja')}}</label>
                            <label class="btn btn-primary @if($userInfo->locale== "en") active @endif"><input type="radio" name="locale" value ="en" autocomplete="off" @if($userInfo->locale=='en') checked   @endif>{{trans('admin.locale.en')}}</label>
                        </div>
                        <span class="help-block">{{$errors->first('locale')}}</span>
                    </div>


                    <!-- 状態 -->
                    <div class="form-group @if(!empty($errors->first('status'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('admin.item.status')}}</label>
                        <div data-toggle="buttons">
                            <label class="btn btn-primary  @if($userInfo->status== "1") active @endif"><input type="radio" name="status" value ="1" autocomplete="off"  @if($userInfo->status== "1") checked @endif >有効</label>
                            <label class="btn btn-primary @if($userInfo->status== "0") active @endif"><input type="radio" name="status"  value ="0" autocomplete="off" @if($userInfo->status== "0") checked @endif >無効</label>
                        </div>
                        <span class="help-block">{{$errors->first('status')}}</span>
                    </div>
              </div><!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success " id="btn_create">{{trans('website.form.submit')}}</button>
              </div><!-- /.box-footer -->
            </form>
          </div><!-- /.box -->
      </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
@endsection
