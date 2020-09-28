
@extends('layouts.master')
@section('content')
  <div class="main-right">
  
  <div class="x_title" style="background-color: #F5F5F5; margin-bottom: 0px;margin-bottom: 20px;">
  <h2 style="margin-left: 10px; position: relative; top: 4px;"><?php  echo trans('admin.update.path_update'); ?></h2>
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
        <li><a href="{{ route($locale . 'admin.show', $admin->id) }}">@lang('website.show_detail')</a></li>
        <li class="divider"></li>
        <li><a href="{{ route($locale . 'admin.create') }}">@lang('website.create_new')</a></li>
      </ul></div></div> 
    </nav>
  <div class="main-right-title">{{trans('admin.update.title')}}</div>

  

   <div class="main-right-content">
     {!! Form::open(array('route' => [$locale .'admin.update', $admin->id],'method'=>'PUT')) !!}
        <div class="verticalLine" ><?php  echo trans('admin.create.name'); ?></div><br>
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group-name" >
                {!! Form::text('name',  $admin->name, array('placeholder' => '','class' => 'form-control')) !!}
            </div>
        </div>
        </div>

        <br><p ><div class="verticalLine" ><?php  echo trans('admin.create.email'); ?></div></p>
        <div class="form-group-name" >
            {!! Form::text('email',  $admin->email, array('placeholder' => '','class' => 'form-control')) !!}
         </div><br>

         <div class="verticalLine" ><?php  echo trans('admin.create.password'); ?></div><br>
        <div class="form-group-name" >
            {!! Form::password('password', null, array('placeholder' => '','class' => 'form-control')) !!}
         </div><br>

          <div class="verticalLine" ><?php  echo trans('admin.create.password_confirm'); ?></div><br>
        <div class="form-group-name" >
            {!! Form::password('password_confirmation', null, array('placeholder' => '','class' => 'form-control')) !!}
         </div><br>

        <div class="verticalLine" ><?php  echo trans('admin.create.type'); ?></div><br>
         <div class="form-group" >
          {!! Form::select('type', [0 => trans('admin.create.organizer'), 1 => trans('admin.create.manager')], $admin->type, [ 'class' => 'form-control', 'id' => 'admin_type', 'style' => 'border-radius:3px; width:250px' ]) !!}
        </div><br>


        <div class="verticalLine" ><?php  echo trans('admin.create.locale'); ?></div><br>
        <div class="form-group" >
          {!! Form::select('admin_lang', ['en' => trans('admin.create.en'), 'ja' => trans('admin.create.ja')], $admin->locale, [ 'class' => 'form-control', 'id' => 'admin_lang', 'style' => 'border-radius:3px; width:250px' ]) !!}
        </div><br>

        <div class="col-xs-12 col-sm-12 col-md-12 text-left">   
         <button type="submit" class="btn btn-primary">{{trans('target.create.update')}}</button>
         @if ($admin->id != 1 && \Auth::user()->id == 1) <a data-confirm="Are you sure?" class='btn btn-danger' id='delete_button'  href="{{ route($locale . 'admin.destroy', $admin->id) }}">{{trans('target.create.destroy')}}</a>@endif
        </div>
        </div><br>

     {!! Form::close() !!}
      </div>
  </div>
@endsection