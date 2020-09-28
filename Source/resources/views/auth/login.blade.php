
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{Lang::get('website.sysName')}} - {{Lang::get('website.customerName')}} | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<meta property="og:locale" content="ja_JP">
<meta property="og:type" content="website">
<meta property="og:title" content="TCI-BBQ">
<meta property="og:description" content="TCI-BBQ">
<meta property="og:site_name" content="TCI-BBQ">
<meta property="og:url" content="https://lbc.whitebear.tk/login">
<meta property="og:image" content="https://lbc.whitebear.tk/images/og_image.png">


  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">{{Lang::get('website.sysName')}} - {{Lang::get('website.customerName')}}</div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">ログイン情報を記入してください</p>

    <form action="/auth/login" method="post">
{{ csrf_field() }}
      <div class="form-group has-feedback">
        <input type="text" name="email" class="form-control" placeholder="Email"  value="{{ old('email') }}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-7">
          <div class="checkbox icheck">
            <label><input type="checkbox"> 内容を記憶する</label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-5">
          <button type="submit" class="btn btn-primary btn-block btn-flat">サインイン</button>
        </div>
        <!-- /.col -->
      </div>
      <a href="{{-- route('reminder.index') --}}">パスワードを忘れてしまった</a><br>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
