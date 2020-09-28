var addCount = 0;

//画像ファイルアップロード時のプレビュー用設定
var uploadThumbsOptions = {
    position : 0,
    imgbreak : false
};

// カレンダーの表示
flatpickr('.timepicker', {
    "locale": "ja",
    enableTime: true,
    time_24hr: true,

    minDate: "today"
});

flatpickr('.datepicker', {
    "locale": "ja",
    enableTime: false,
    minDate: "today"
});

flatpickr('.dateRangePicker', {
    "locale": "ja",
    enableTime: false,
    minDate: "today",
    mode: "range"
});



$('input[id=lefile]').change(function() {
    $('#inputTargetCSV').val($(this).val());
});

//$(".select2").select2();

//ボタン制御
$('#btnDraft').click(function(e) {
        $("#resist").val("btnDraft");
        e.preventDefault();
        $("#resist").val("0");
        $('#inputForm').submit();
});
$('#btnPreview').click(function(e) {
        $("#resist").val("btnPreview");
        e.preventDefault();
        $("#resist").val("preview");
        $('#inputForm').submit();
});
$('#btnResist').click(function(e) {
        $("#resist").val("btnResist");
        e.preventDefault();
        $("#resist").val("1");
        $('#inputForm').submit();
});



// 入力パターン追加
function addInput(type){
    addCount++;
    if (addCount<= 5) {
        $("#" + type).clone().appendTo("#sendMessageArea");
    }else{
        alert("これ以上追加はできません");
    }
    //画像ファイルアップロード時のプレビュー再初期化
    if(type == 'input_image' || type == 'input_imagemap'){
        $('input:file').uploadThumbs(uploadThumbsOptions);
    }
}
//入力パターン削除
function delInput(type){
    $("#" + type).remove();
    addCount--;
}

// マップ情報変更
function mapLayoutChange(type){
    $("#mapLayoutArea").empty();
    for(var i=type; i>0; i--){
        $("#mapLayout").clone().appendTo("#mapLayoutArea");
    }
}

