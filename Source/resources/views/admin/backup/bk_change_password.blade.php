
@extends('layouts.master')
@section('content')
  <div class="main-right">
  
  <div class="x_title" style="background-color: #F5F5F5; margin-bottom: 0px;margin-bottom: 20px;">
  <h2 style="margin-left: 10px; position: relative; top: 4px;"><?php  echo trans('admin.password_update'); ?></h2>
  <div class="clearfix"></div>
  </div>
  @if (!empty($success))
    <div class="alert alert-success">
    {{$success}}
    </div>
  @endif

  @if(!empty($errors))
     <?php  if (array_key_exists('code', $errors)) { $code=$errors['code'];
      if($code==404){ ?>
             <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors['content'] as $error)
                            @if ($error == 'password is not match')
                              <li>{{trans('admin.password_is_not_match')}}</li>
                            @else 
                              <li>{{ $error }}</li>  
                            @endif                         
                        @endforeach
                    </ul>
                </div>
      <?php }else{ ?>
          <div class="alert alert-success">
            <p>{{trans('admin.success')}}</p>
        </div>
      <?php  }} ?>
  @endif
    
  <div class="main-right-title">{{trans('admin.change_password')}}</div>
   <div class="main-right-content">
     {!! Form::open(array('route' => $locale .'changePwd','method'=>'POST','autocomplete' => 'off')) !!}
     {{ csrf_field() }}
        
        <div class="verticalLine" ><?php  echo trans('admin.old_pass'); ?></div><br>
        <div class="form-group-name" >
            {!! Form::password('old_password', array('placeholder' => '','class' => 'form-control','autocomplete' => 'off')) !!}
         </div><br>

        <div class="verticalLine" ><?php  echo trans('admin.new_pass'); ?></div><br>
        <div class="form-group-name" >
            {!! Form::password('password', array('placeholder' => '','class' => 'form-control','autocomplete' => 'off')) !!}
         </div><br>

          <div class="verticalLine" ><?php  echo trans('admin.new_pass_conf'); ?></div><br>
        <div class="form-group-name" >
            {!! Form::password('password_confirmation', array('placeholder' => '','class' => 'form-control','autocomplete' => 'off')) !!}
         </div><br>
       

        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
           <button type="submit" class="btn btn-primary"><?php  echo trans('admin.update_pass'); ?></button>
        </div>
     {!! Form::close() !!}
      </div>
  </div>
@endsection