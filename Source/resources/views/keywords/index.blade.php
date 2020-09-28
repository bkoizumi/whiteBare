@extends('layouts.master')



@section('style')
  <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css" rel="stylesheet" />
  <link href="/themes/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" />
@endsection

@section('script')
<script>
$('#reservationtime1').daterangepicker({
  timePicker: false,
  timePickerIncrement: 30,
  singleDatePicker: true,
  locale: {
      format: 'YYYY/MM/DD'
  }
});

$('#reservationtime2').daterangepicker({
    timePicker: false,
    timePickerIncrement: 30,
    locale: {
        format: 'YYYY/MM/DD'
    }
  });

    // //Flat red color scheme for iCheck
    // $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      // checkboxClass: 'icheckbox_flat-green',
      // radioClass: 'iradio_flat-green'
    // });
//
$(function(){
  $('#modalSubmit').click(function(){
    //
    // バリデーションチェックや、データの加工を行う。
    //
$('#staticModal').modal('hide');
    var selectVal = $("#targetList").val();

    $("#targetId").val(selectVal);

    $('#inputForm').submit();
  });
});


</script>

@endsection


@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{trans('keywords.sysName')}}</h1>
      <ol class="breadcrumb">
        <li><a href="/home"><span>{{Lang::get('home.sysName') }}</span></a></li>
        <li><a href="/keywords">{{Lang::get('keywords.sysName') }} </a></li>
        <li class="active">{{trans('keywords.path.index')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">




      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{trans('keywords.path.index')}}</h3>
                <div class="btn-group pull-right" role="group">
                    <button type="button" class="btn bg-orange  btn-sm "  onClick="location.href='./keywords/create'">{{trans('keywords.path.create')}}</button>
                </div>

            </div>
            <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <table id="tableList" class="table table-bordered table-hover">
                                <thead>
                                <tr class="info">
                                  <th nowrap>{{trans('keywords.list.table.id')}}  @include('layouts.sortOrder', ['column' => 'id'])</th>
                                  <th nowrap>{{trans('keywords.list.table.title')}}</th>
                                  <th nowrap>{{trans('keywords.list.table.meg_type')}}  @include('layouts.sortOrder', ['column' => 'meg_type'])</th>
                                  <th nowrap>{{trans('keywords.list.table.meg_body')}}</th>
                                  <th nowrap>{{trans('keywords.list.table.created_at')}}  @include('layouts.sortOrder', ['column' => 'created_at'])</th>
                                </tr>
                                </thead>
                                <tbody>
                @foreach ($lists as $row)
                @if($row->status ==0)
                <tr class="bg-gray disabled color-palette">
                @else
                <tr>
                @endif
                  <td nowrap nowrap><a href="/keywords/edit/{{$row->id}}/">{{$row->id}}</a></td>
                  <td nowrap> {{$row->title}} </td>
                  <td nowrap> {{$row->receive_meg_type}} </td>
                  <td nowrap> {{$row->receive_meg_body}} </td>
                  <td nowrap>{{ date(Lang::get('website.date_format'), strtotime($row->created_at)) }}</td>
                </tr>
                @endforeach
                                </table>
                            </div><!-- /.table-responsive -->
                        </div><!-- /.col -->
                     </div><!-- /.row -->
                 </div><!-- /.box-body -->
                <div class="box-footer">
                    <!-- Paginator -->{{-- $users->render() --}}<!-- /.Paginator -->
                </div><!-- /.box-footer-->
      </div><!-- /.box -->
      </div><!-- /.col-md-12 -->
    </section>
</div><!-- /.content-wrapper -->
@endsection
