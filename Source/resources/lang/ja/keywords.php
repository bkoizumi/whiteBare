<?php

return [

        'sysName' => '自動応答管理',
        'path' => [
                'index' => '登録情報一覧'
                ,'create' => '新規登録'
                ,'edit' => '編集'
        ],
        'searchListCount' => '全 :total 件中 :from - :to 件を表示',

        'item' => [
                'Meg' => 'メッセージ',
                'status' => '状態',
                'created_at' => '登録日時',
                'updated_at' => '更新日時',
                'managementTitle' => '管理用タイトル',
                'targetList' => '配信リスト',
                'send_time' => '配信日時',
                'inputMessage' => '配信メッセージ',
                'inputMessageTypeText' => 'テキストメッセージ',
                'inputMessageTypeImage' => '画像メッセージ',
                'inputMessageTypeRich' => 'リッチメッセージ',
                'inputMessageTypeCarousel' => 'カルーセル'
        ],
        'list' => [

                'table' => [
                        'id' => 'ID',
                        'status' => '状態',
                        'meg_type' => 'タイプ',
                        'meg_body' => '受信メッセージ',
                        'title' => 'タイトル',
                        'created_at' => '登録日時',
                        'updated_at' => '更新日時'
                ]
        ]
];
