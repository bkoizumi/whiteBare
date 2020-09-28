
@extends('layouts.master')
@section('content')
    <?php $base_url=URL::to('/');?>
      <div class="main-right">
         <div class="x_title" style="background-color: #F5F5F5; margin-bottom: 0px;margin-bottom: 20px;">
          <h2 style="margin-left: 10px; position: relative; top: 4px;"><?php  echo trans('admin.path');?>/ {{$admin->name}} </h2>
          <div class="clearfix"></div>
        </div>
        <nav class="actions row">            
          <div class="col-md-6 pull-right"><div class="btn-group pull-right">
          <button style="width:200px;margin-bottom: 20px;" aria-expanded="false" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">@lang('website.action')<span class="caret"></span></button>
          <ul class="dropdown-menu dropdown-menu-right" role="menu">
            <li><a href="{{ route($locale . 'admin.index') }}">@lang('website.back_to_index')</a></li>
            <li><a href="{{ route($locale . 'admin.edit', $admin->id) }}">@lang('website.edit')</a></li>
            <li class="divider"></li>
            <li><a href="{{ route($locale . 'admin.create') }}">@lang('website.create_new')</a></li>
          </ul></div></div> 
        </nav>
		    <div class="main-right-title">{{trans('admin.admin_info')}}</div>
        <div class="main-right-content">
          @if(!empty($admin) &&$admin!=null)
           <br><div>{{trans('admin.create.name')}}</div>
              {{$admin->name}} 
             <br><br><div>{{trans('admin.create.email')}}</div>
                {{$admin->email}} <br>
            <br><br> <div>{{trans('admin.create.type')}}</div>
               <?php if($admin->type==0){?>
                     <a style="border-radius: 3px; background: #E1826B; color: #000000 ; padding: 5px ; font-size:14pt; width:250px; height:60px; text-decoration:none;"> 
                    {{Helper::convertAdminType($admin->type)}}</a>
                 <?php } else {?>
                    <a style="border-radius: 3px; background: #526066; color: #000000 ; padding: 5px ; font-size:14pt; width:250px; height:60px; text-decoration:none;">  
                    {{Helper::convertAdminType($admin->type)}}</a>
               <?php }?>
             <br><br><div>{{trans('admin.table.created_at')}}</div>
                {{$admin->created_at}} 
            </div>
        @endif
      </div>
@endsection