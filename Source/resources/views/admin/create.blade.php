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
        <li class="active">{{trans('admin.path.create')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">{{trans('admin.path.index')}}</h3>
                <div class="btn-group pull-right" role="group">
                    <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='/admin'">{{trans('admin.path.index')}}</button>
                </div>
            </div>

@if(count($errors) > 0)
        <div class="col-md-12">
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="icon fa fa-ban"></i>{{trans('website.systemCode.400' )}}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
@foreach ($errors->all() as $error)
                <span class="text-red">{{ $error }}<br /></span>
@endforeach
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
@elseif ( session('systemCode') == 200)
        <div class="col-md-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="icon fa fa-check"></i>ssss</h3>
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
            <form id="inputForm"  action="resist" method="post">
            {{ csrf_field() }}
              <div class="box-body">
                    <!-- 氏名 -->
                    <div class="form-group @if(!empty($errors->first('name'))) has-error @endif">
                        <label for="exampleInputEmail1">{{trans('admin.item.name')}}</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder=""  value="{{old('name')}}">
                        <span class="help-block">{{$errors->first('name')}}</span>
                    </div>

                    <!-- パスワード -->
                    <div class="form-group @if(!empty($errors->first('password'))) has-error @endif">
                        <label for="exampleInputPassword1">{{trans('admin.item.password')}}</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder=""  value="">
                    </div>

                    <!-- メールアドレス -->
                    <div class="form-group @if(!empty($errors->first('email'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('admin.item.email')}}</label>
                        <input type="text" class="form-control" id="title" name="email" placeholder="" value="{{old('email')}}">
                        <span class="help-block">{{$errors->first('email')}}</span>
                    </div>

                    <!-- LID -->
                    <div class="form-group @if(!empty($errors->first('lid'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('admin.item.lid')}}</label>
                        <input type="text" class="form-control" id="lid" name="lid" placeholder="" value="{{old('lid')}}">
                        <span class="help-block">{{$errors->first('lid')}}</span>
                    </div>

                    <!-- 言語 -->
                    <div class="form-group @if(!empty($errors->first('locale'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('admin.item.locale')}}</label>
                        <div  data-toggle="buttons">
                            <label class="btn btn-primary active"><input type="radio" name="locale" value ="ja"  autocomplete="off" @if(old('locale')=='ja') checked @elseif(old('locale')=='') checked  @endif>{{trans('admin.locale.ja')}}</label>
                            <label class="btn btn-primary"><input type="radio" name="locale" value ="en" autocomplete="off" @if(old('locale')=='en') checked  @endif>{{trans('admin.locale.en')}}</label>
                            <span class="help-block">{{$errors->first('locale')}}</span>
                        </div>
                    </div>

                    <!-- 権限 -->
                    <div class="form-group @if(!empty($errors->first('authority'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('admin.item.authority')}}</label>
                        <select class="form-control" name="authority" >
                            @for ($i = 1; $i < 6; $i++)
                            <option value ="{{$i}}" @if(old('authority') == $i) selected @endif >{{trans('admin.authority.' . $i )}}</option>
                            @endfor
                        </select>
                        <span class="help-block">{{$errors->first('authority')}}</span>
                    </div>

                    <!-- 状態 -->
                    <div class="form-group @if(!empty($errors->first('status'))) has-error @endif">
                        <label for="exampleInputFile">{{trans('admin.item.status')}}</label>
                        <div data-toggle="buttons">
                            <label class="btn btn-primary active"><input type="radio" name="status" value ="1" autocomplete="off" checked>有効</label>
                            <label class="btn btn-primary"><input type="radio" name="status"  value ="0" autocomplete="off">無効</label>
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
