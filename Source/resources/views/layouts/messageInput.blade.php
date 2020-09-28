<div class="box">
    <div class="box-header">
        <h3 class="box-title">送信メッセージ形式</h3>
    </div>
    <div class="box-body">
        <p>ボタンで追加（５つまで）</p>
        <div class="margin">
            <div class="btn-group">
                <button type="button" class="btn btn-block btn-primary" onclick="addInput('input_text');">{{Lang::get('message.inputText.title')}}</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-block btn-primary" onclick="addInput('input_image');">{{Lang::get('message.inputImage.title')}}</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-block btn-warning" onclick="addInput('input_imagemap');">{{Lang::get('message.inputImageMap.title')}}</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-block btn-primary" onclick="addInput('input_confirm');">{{Lang::get('message.inputConfirm.title')}}</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-block btn-warning" onclick="addInput('input_carousel');">{{Lang::get('message.inputCarousel.title')}}</button>
            </div>
        </div>
    </div>
</div>

<div id="sendMessageArea"></div>


<div style="display: none"><!-- -->

    <!-- カルーセル -->
    <div class="form-group" id="input_carousel">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Lang::get('message.inputCarousel.title')}}{{Lang::get('message.item.Meg')}}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" onclick="delInput('input_carousel');">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <textarea name="textMeg[]" class="textarea" placeholder="{{Lang::get('message.inputText.placeholder')}}"
                        style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" cols="" rows=""></textarea>
                    <p class="help-block">{{Lang::get('message.inputCarousel.warning')}}</p>
                </div>
            </div>
        </div>
    </div>





    <!-- テキスト -->
    <div class="form-group" id="input_text">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Lang::get('message.inputText.title')}}{{Lang::get('message.item.Meg')}}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" onclick="delInput('input_text');">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <textarea name="textMeg[]" class="textarea" placeholder="{{Lang::get('message.inputText.placeholder')}}"
                        style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" cols="" rows=""></textarea>
                    <p class="help-block">{{Lang::get('message.inputText.warning')}}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- イメージ -->
    <div class="form-group" id="input_image">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Lang::get('message.inputImage.title')}}{{Lang::get('message.item.Meg')}}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" onclick="delInput('input_image');">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                <img class="thumb" src="">
                    <input type="file" name="img[]" id="selectImg1" accept="image/*">
                    <p class="help-block">{{Lang::get('message.inputImage.warning')}}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- イメージマップ -->
    <div class="form-group" id="input_imagemap">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Lang::get('message.inputImageMap.title')}}{{Lang::get('message.item.Meg')}}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" onclick="delInput('input_imagemap');">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="file" name="imgMap[]" accept="image/*">
                    <p class="help-block">{{Lang::get('message.inputImageMap.warning')}}</p>
                    <div class="col-sm-2">
                        <label>代替文字</label>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="altText[]" placeholder="代替文字">
                    </div>

                    <label>レイアウト</label>
                    <div class="row">
                        <div class="col-sm-3">
                            <input type="radio" name="mapLayout" onclick="mapLayoutChange('1');" id="mapType01" value=" mapType01"> <label for="mapType01"><img src="/images/line/mapType01.png"
                                width="80%" height="80%">mapType01</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="radio" name="mapLayout" onclick="mapLayoutChange('2');" id="mapType02" value=" mapType02"> <label for="mapType02"><img src="/images/line/mapType02.png"
                                width="80%" height="80%">mapType02</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="radio" name="mapLayout" onclick="mapLayoutChange('2');" id="mapType03" value=" mapType03"> <label for="mapType03"><img src="/images/line/mapType03.png"
                                width="80%" height="80%">mapType03</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="radio" name="mapLayout" onclick="mapLayoutChange('3');" id="mapType04" value=" mapType04"> <label for="mapType04"><img src="/images/line/mapType04.png"
                                width="80%" height="80%">mapType04</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <input type="radio" name="mapLayout" onclick="mapLayoutChange('4');" id="mapType05" value=" mapType05"> <label for="mapType05"><img src="/images/line/mapType05.png"
                                width="80%" height="80%">mapType05</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="radio" name="mapLayout" onclick="mapLayoutChange('3');" id="mapType06" value=" mapType06"> <label for="mapType06"><img src="/images/line/mapType06.png"
                                width="80%" height="80%">mapType06</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="radio" name="mapLayout" onclick="mapLayoutChange('3');" id="mapType07" value=" mapType07"> <label for="mapType07"><img src="/images/line/mapType07.png"
                                width="80%" height="80%">mapType07</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="radio" name="mapLayout" onclick="mapLayoutChange('6');" id="mapType08" value=" mapType08"> <label for="mapType08"><img src="/images/line/mapType08.png"
                                width="80%" height="80%">mapType08</label>
                        </div>
                    </div>
                    <div id="mapLayoutArea"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Yes/No コンファーム -->
    <div class="form-group" id="input_confirm">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Lang::get('message.inputConfirm.title')}}{{Lang::get('message.item.Meg')}}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" onclick="delInput('input_confirm');">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="form-group ">
                            <label for="exampleInputEmail1">タイトル</label>
                            <input type="text" name="confirm_title[]" class="form-control inputConfirmTitle"  placeholder="">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group ">
                            <label for="exampleInputEmail1">代替文字</label>
                            <input type="text" name="altText[]" class="form-control inputAltText" placeholder="代替文字">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group ">
                            <label for="exampleInputEmail1">ボタン名称(YES)</label>
                            <input type="text" name="actionChar[]" class="form-control inputActionCharYes" placeholder="ボタン名称(YES)">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group ">
                            <label for="exampleInputEmail1">Yesのアクション</label>
                            <input type="text" name="actionTextChar[]" class="form-control inputActionTextYes" placeholder="Yesのアクション">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group ">
                            <label for="exampleInputEmail1">ボタン名称(No)</label>
                            <input type="text" name="actionChar[]" class="form-control inputActionCharNo" placeholder="ボタン名称(No)">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group ">
                            <label for="exampleInputEmail1">Noのアクション</label>
                            <input type="text" name="actionTextChar[]" class="form-control inputActionTextNo" placeholder="Noのアクション">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="input-group " id="mapLayout">
        <table>
            <tr>
                <td><select class="form-control" name="imgMapActionType[]">
                        <option value="url">URL</option>
                        <option value="txt">テキスト</option>
                </select></td>
                <td><input type="text" name="imgMapChar[]" class="form-control"></td>
            </tr>
        </table>
    </div>
</div><!-- 非表示 -->
