@extends('layouts.master') @section('style')
<link rel="stylesheet" href="/plugins/flatpickr/themes/material_blue.css">
<link rel="stylesheet" href="/plugins/clockpicker/jquery-clockpicker.min.css">
<link rel="stylesheet" href="/dist/css/message.css">

@endsection @section('script')
<script src="/plugins/flatpickr/flatpickr.min.js" type="text/javascript"></script>
<script src="/plugins/flatpickr/l10n/ja.js" type="text/javascript"></script>
<script src="/plugins/jQuery/jquery.uploadThumbs.js" type="text/javascript"></script>
<script src="/dist/js/sendMessage.js" type="text/javascript"></script>


<script type="text/javascript">


// 編集用
var textCount=0;
var imgCount=0;
var imgmapCount=0;
var confirmCount=0;

@foreach ($listDetailInfo as $row)
addInput('input_{{$row->type}}');

@if ($row->type =='text')
    var longString = "{{$row->rtext}}";
    val = longString.replace(/#br#/g, "\r\n");
    var va = val.split("rn");
    //va.each(function(str,i){va[i]=str.unescapeHTML();});
    val = va.join("rn")

    $('.textarea').eq(textCount).val(val);
    textCount++;

@elseif  ($row->type =='image')
    $('input:file').uploadThumbs(uploadThumbsOptions);
    $('.thumb').eq(imgCount).attr('src','{{$row->preview_image_url}}');
    imgCount++;

@elseif ($row->type =='confirm')
    $('.inputConfirmTitle').eq(confirmCount).val('{{$row->text}}');
    $('.inputAltText').eq(confirmCount).val('{{$row->alt_text}}');
    $('.inputActionCharYes').eq(confirmCount).val('{{$row->action_char01}}');
    $('.inputActionCharNo').eq(confirmCount).val('{{$row->action_char02}}');

    $('.inputActionTextYes').eq(confirmCount).val('{{$row->act_type01}}');
    $('.inputActionTextNo').eq(confirmCount).val('{{$row->act_type02}}');


    confirmCount++;
@endif

@endforeach


</script>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{trans('message.sysName')}}</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home"></i><span>{{Lang::get('home.sysName')}}</span></a></li>
            <li><a href="/message"><i class="fa fa-envelope"></i>{{Lang::get('message.sysName')}}</a></li>
            <li class="active">{{trans('message.path.edit')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('message.path.edit')}}</h3>
                <div class="btn-group pull-right" role="group">
                    <button type="button" class="btn bg-orange  btn-sm " onClick="location.href='/message'">{{trans('message.path.index')}}</button>
                </div>
            </div>
            <!-- form start -->
            <form id="inputForm" action="/message/resist" method="post" enctype="multipart/form-data">
            <input type="hidden" name="messageId" value="{{$listInfo->id}}">
                {{ csrf_field() }}

                <div class="box-body">

                    <!-- タイトル -->
                    <div class="form-group">
                        <label>{{Lang::get('message.item.messageTitle')}}</label>
                        <input type="text" name="main_title" class="form-control" id="input1" placeholder="" value="{{$listInfo->title}}">
                    </div>

                    <!-- 配信リスト -->
                    <div class="form-group">
                        <label>{{Lang::get('message.item.targetList')}}</label>
                        <div class="input-group">
                            <input type="text" class="form-control"  readonly id='inputTargetCSV'> <label class="input-group-btn"> <span class="btn btn-primary"> <i class="fa fa-folder-open-o"></i>
                                    <input type="file" name="csvfile" id='lefile' style="display: none">
                            </span>
                            </label>
                        </div>
                        <select class="form-control select2" name="target">
                            <option value="">{{Lang::get('website.inputMessage.select.default')}}</option>
                            <option value='0'  @if($listInfo->target_id == 0) selected @endif>全員</option>
                             @foreach ($targetLists as $row)
                            <option value='{{$row->id}}' @if($row->status ==0) disabled="disabled" @endif @if($row->id ==$listInfo->target_id) selected @endif>{{$row->name}}</option>
                            @endforeach

                        </select>
                    </div>
                    <!-- /.form group -->
                    @include('layouts.messageInput')


                        <!-- 配信日時 -->
                        <div class="form-group @if(!empty($errors->first('send_date'))) has-error @endif">
                            <label for="exampleInputFile">{{trans('message.item.send_time')}}</label>
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control timepicker" name="send_date" value="{{$listInfo->send_schedule}}" id="send_date">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="resist" value="" id="resist">
                            <div class="btn-group" data-toggle="buttons">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <button type="submit" class="btn btn-block btn-primary" id="btnDraft">下書き保存</button>
                                    </div>
                                    <div class="col-xs-4">
                                        <button type="submit" class="btn btn-block btn-warning" id="btnPreview">プレビュー</button>
                                    </div>
                                    <div class="col-xs-4">
                                        <button type="submit" class="btn btn-block btn-danger" id="btnResist">配信登録</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.form group -->

                    </div>
                    <!-- /.box-body -->
            </form>
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
@endsection
