<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <title>登録メンバー一覧</title>

  <!-- Tell the browser to be responsive to screen width -->
  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="/dist/css/icon.css">
  <link rel="stylesheet" href="/dist/css/override.css">

</head>
<body>
<table id="example2" class="table table-bordered table-hover">
  <thead>
  <tr class="info">
  <th nowrap>{{trans('friends.list.table.userName')}}</th>
  <th nowrap>{{trans('friends.list.table.created_at')}}</th>
  </tr>
  </thead>
  <tbody>
  <tr>
@foreach ($users as $row)
@if($row->relation_state ==0)
<tr>
  <td nowrap>
                          <label for="{{$row->lid}}">
                      @if($row->thumbnail_url == '' or ($row->relation_state ==1))<img src='/dist/img/avatar.png' height="30" width="30" class="line-icon">
                      @else <img src='{{$row->thumbnail_url}}'  height="30" width="30" class="line-icon">
                      @endif
                      </label>
  {{$row->nick_name}}</td>
  <td nowrap>{{ date(Lang::get('website.date_format'), strtotime($row->created_at)) }}</td>
</tr>
@else
@endif
@endforeach

  </tbody>
</table>

</body>
</html>

