<?php

return [
        'sysName' => 'メッセージ管理',
        'path' => [
                'index' => '登録情報一覧',
                'create' => '新規登録',
                'receive' => '受信メッセージ',
                'edit' => '編集'
        ],
        'reload' => '更新',
        'searchListCount' => '全 :total 件中 :from - :to 件を表示',

        'item' => [
                'nick_name' => 'ニックネーム',
                'Meg' => 'メッセージ',
                'csvFile' => 'CSVファイル',
                'listname' => 'リスト名称',
                'appType' => 'アプリ種別',
                'parameters' => 'パラメータ',
                'status' => '状態',
                'notes' => '備考',
                'created_at' => '登録日時',
                'updated_at' => '更新日時',
                'messageTitle' => 'タイトル',
                'targetList' => '配信リスト',
                'send_time' => '配信日時',
                'inputMessage' => '配信メッセージ',
                'inputMessageTypeText' => 'テキストメッセージ',
                'inputMessageTypeImage' => '画像メッセージ',
                'inputMessageTypeRich' => 'リッチメッセージ',
                'inputMessageTypeCarousel' => 'カルーセル'
        ],
        'inputText' => [
                'title' => 'テキスト',
                'placeholder' => '配信メッセージを入力してください',
                'warning' => '※2000文字以内'
        ],
        'inputImage' => [
                'title' => '画像',
                'warning' => '1024px 1024px 1MB以内'
        ],
        'inputImageMap' => [
                'title' => 'マップ',
                'placeholder' => 'URLを入力してください',
                'url' => 'URL',
                'warning' => '1040px 1040px 1MB以内'
        ],
        'inputConfirm' => [
                'title' => 'Yes/No',
                'placeholder' => 'URLを入力してください',
                'url' => 'URL',
                'warning' => '1024px 1024px 1MB以内'
        ],
        'inputCarousel' => [
                'title' => 'カルーセル',
                'placeholder' => 'URLを入力してください',
                'url' => 'URL',
                'warning' => '1024px 1024px 1MB以内'
        ],
        'parameters' => [
                '0' => 'なし',
                '1' => 'あり'
        ],

        'status' => [
                '0' => '下書き',
                '1' => '配信待ち',
                '2' => '配信中',
                '3' => '配信完了',
                '99' => '配信失敗'
        ],

        'comment' => [
                'csvFile' => '文字コードがUTF-8のCSVファイルを選択してください'
        ]
];
