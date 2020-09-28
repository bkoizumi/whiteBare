
@extends('layouts.master')
@section('content')
<style type="text/css">
  ul.error-messages{
  padding: 0px;
}

ul.error-messages li {
    list-style: none;
    display: inline-block;
    margin: 4px 0 0 1px;
    font-weight: bold;
    color: #A94442;
}

table#example {

}

table#example tr th, table tr td {
    border: 1px solid #ddd !important;
    text-align: left;
    padding: 10px;
    font-size: 15px;
}

table#example tr th, td {
    cursor: text;
    width: 25%;
    word-break: break-all;
}

table#example tr th.sorting_asc span.glyphicon-chevron-down {
  color: red;
}
table#example tr th.sorting_desc span.glyphicon-chevron-up {
  color: red;
}

table#example tr th span.glyphicon{
  cursor: pointer;
}

.pagination > li > a, .pagination > li > span {
  padding: 8px 16px;

ul.error-messages{
  padding: 0px;
}

</style>
   <?php $base_url=Request::url();
   $fromIndex = count($admins->items()) > 0 ? ( ($admins->currentPage() - 1) * $admins->perPage() ) + 1  : 0;
         $toIndex = (($admins->currentPage() - 1) * $admins->perPage()) + count($admins->items());?>

{{--  {{Config::get('global.pagination_number')}} --}}
      <div class="main-right">
         <div class="x_title" style="background-color: #F5F5F5; margin-bottom: 0px;margin-bottom: 20px;">
          <h2 style="margin-left: 10px; position: relative; top: 4px;">{{trans('admin.path')}}  </h2>
          <div class="clearfix"></div>
        </div>
        <h1 style="font-size:20px;">{{trans('admin.sc_name')}} </h1>
        @if ($errors->any() > 0)
                      <ul class="error-messages">
                      <li>{{$errors->first()}}</li>
                      </ul>
                      @endif
        <div class="right-top">
        <div style="width:75%; height:80px; align: center;">
          <ul class="pagination">
          {{$admins->appends($page_appends)->render()}}
          </ul>
       <p style="font-size: 13px;"">@lang('website.listadmin_display_number_messages', ['total' => $admins->total(), 'from' => $fromIndex, 'to' => $toIndex])</p>
        </div>

        <div style="width:25%; height:80px; padding-top:20px">
        <div class="dropdown" style="border-radius: 3px; width:200px; height:50px; border-radius: 3px; border-color:#bdbdbd; vertical-align: middle; position:relative; float:right;">
            <button style="width:200px;" class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" style="width:80px; margin-right:10px;">{{trans('target.action')}} <i style="margin-left:15px" class="fa fa-angle-down" aria-hidden="true"></i></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
              <li role="presentation"><a role="menuitem" tabindex="-1" href="{{$base_url}}/create">{{trans('target.create_new')}}</a></li>
            </ul>
          </div>
       </div> </div>
      <div class="normal-table">
          <table id="example">
            <tr>
              <th {{ ($order == 'name') ? 'class=sorting_'. $dir : ''}}>{{trans('admin.table.name')}}
                 <a href="{{$base_url}}?page={{ $admins->currentPage() }}&order=name&dir=asc"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>
                 <a href="{{$base_url}}?page={{ $admins->currentPage() }}&order=name&dir=desc"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>
              </th>

              <th {{ ($order == 'type') ? 'class=sorting_'. $dir : ''}}>{{trans('admin.table.type')}}
                 <a href="{{$base_url}}?page={{ $admins->currentPage() }}&order=type&dir=asc"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>
                 <a href="{{$base_url}}?page={{ $admins->currentPage() }}&order=type&dir=desc"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>
              </th>

              <th {{ ($order == 'created_at') ? 'class=sorting_'. $dir : ''}}>{{trans('admin.table.created_at')}}
                 <a href="{{$base_url}}?page={{ $admins->currentPage() }}&order=created_at&dir=asc"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>
                 <a href="{{$base_url}}?page={{ $admins->currentPage() }}&order=created_at&dir=desc"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>
              </th>

               <th></th>
            </tr>
            @foreach ($admins as $row)
            @if(((\Auth::user()->id == 1) || (\Auth::user()->id != 1 && $row->id != 1)) && !$row->disable_flag)
            <tr>
              <td><?php echo $row->name;?></td>

              <?php if($row->type==0){?>
                <td > <a style="border-radius: 3px; background: #E1826B; color: #000000 ; padding: 5px ; font-size:14pt; width:250px; height:60px; text-decoration:none;">
                {{Helper::convertAdminType($row->type)}}</a></td>
             <?php } else {?>
                <td > <a style="border-radius: 3px; background: #526066; color: #000000 ; padding: 5px ; font-size:14pt; width:250px; height:60px; text-decoration:none;">
                {{ Helper::convertAdminType($row->type)}}</a></td>
              <?php }?>
              <td> <?php echo $row->created_at;?></td>
              <?php $admin_id =$row->id;?>
              <td><a style="margin-right:5px;" href="{{$base_url}}/{{$admin_id}}">{{trans('target.show')}}</a> <a href="{{$base_url}}/{{$admin_id}}/edit">
              {{ trans('target.edit')}}</a></td>
            </tr>
            @endif
            @endforeach
          </table>
          <br/>

          {{$admins->appends($page_appends)->render()}}
  </div>
      </div>
@endsection
