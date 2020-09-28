
@extends('layouts.master')
@section('content')

<script type="text/javascript">
(function($) {
  'use strict';
  $(function() {
    @if (old('type') != null)
    $('select#admin_type').val({{old('type')}});
    @endif

    @if (old('admin_lang') != null)
      @if (old('admin_lang') == 'en')
          $('select#admin_lang_id').val('en');
      @else {
        $('select#admin_lang_id').val('ja');
      }
      @endif
    @endif
  });
})(jQuery);
</script>

  <div class="main-right">

  <div class="x_title" style="background-color: #F5F5F5; margin-bottom: 0px;margin-bottom: 20px;">
  <h2 style="margin-left: 10px; position: relative; top: 4px;"><?php  echo trans('admin.create.path_create'); ?></h2>
  <div class="clearfix"></div>
  </div>
  @if(!empty($errors))
     <?php  if (array_key_exists('code', $errors)) { $code=$errors['code'];
      if($code==404){ ?>
             <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors['content'] as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
      <?php }else{ ?>
          <div class="alert alert-success">
            <p>Success</p>
        </div>
      <?php  }} ?>
  @endif

  <nav class="actions row">
      <div class="col-md-6 pull-right"><div class="btn-group pull-right">
      <button style="width:200px;margin-bottom: 20px;" aria-expanded="false" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">@lang('website.action')<span class="caret"></span></button>
      <ul class="dropdown-menu dropdown-menu-right" role="menu">
        <li><a href="{{ route($locale . 'admin.index') }}">@lang('website.back_to_index')</a></li>
      </ul></div></div>
    </nav>

  <div class="main-right-title">{{trans('admin.create.title')}}</div>
   <div class="main-right-content">
     {!! Form::open(array('route' => $locale .'admin.store','method'=>'POST','autocomplete' => 'off')) !!}
     {{ csrf_field() }}
        <div class="verticalLine" ><?php  echo trans('admin.create.name'); ?></div><br>
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group-name" >
                {!! Form::text('name', null, array('placeholder' => '','class' => 'form-control')) !!}
            </div>
        </div>
        </div>

        <br><p ><div class="verticalLine" ><?php  echo trans('admin.create.email'); ?></div></p>
        <div class="form-group-name" >
            {!! Form::text('email', null, array('placeholder' => '','class' => 'form-control')) !!}
         </div><br>

        <div class="verticalLine" ><?php  echo trans('admin.create.password'); ?></div><br>
        <div class="form-group-name" >
            {!! Form::password('password', array('placeholder' => '','class' => 'form-control','autocomplete' => 'off')) !!}
         </div><br>

          <div class="verticalLine" ><?php  echo trans('admin.create.password_confirm'); ?></div><br>
        <div class="form-group-name" >
            {!! Form::password('password_confirmation', array('placeholder' => '','class' => 'form-control','autocomplete' => 'off')) !!}
         </div><br>

        <div class="verticalLine" ><?php  echo trans('admin.create.type'); ?></div><br>
         <div class="form-group" >
        <!-- <label for="sel1">Select list:</label>  -->
          <select class="form-control" name="type" id="admin_type" style="border-radius:3px; width:250px">
            <option selected="selected" value="0">{{trans('admin.create.organizer')}}</option>
            <option value="1">{{trans('admin.create.manager')}}</option>
          </select>
        </div><br>


        <div class="verticalLine" ><?php  echo trans('admin.create.locale'); ?></div><br>
        <div class="form-group" >
        <!-- <label for="sel1">Select list:</label>  -->
          <select class="form-control" name="admin_lang" id="admin_lang_id" style="border-radius:3px; width:250px">
            <option selected="selected" value="en">{{trans('admin.create.en')}}</option>
            <option value="ja">{{trans('admin.create.ja')}}</option>
          </select>
        </div><br>

        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
           <button type="submit" class="btn btn-primary"><?php  echo trans('target.create.create'); ?></button>
        </div>
     {!! Form::close() !!}
      </div>
  </div>
@endsection
