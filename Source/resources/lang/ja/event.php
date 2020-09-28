<?php

return [
        'sysName' => 'イベント管理',
        'path' => [
                'index' => '登録情報一覧',
                'create' => '新規登録',
                'edit' => '詳細'
        ],
        'searchListCount' => '全 :total 件中 :from - :to 件を表示',

        'item' => [
                'eventName' => 'イベント名称',
                'event_date' => '開催日',
                'event_place' => '開催場所',
                'start_session' => '開始日時',
                'end_session' => '終了日時',
                'chat_period' => 'チャット期間',
                'target' => '配信リスト',
                'parameters' => 'パラメータ',
                'status' => '状態',
                'notes' => '備考',
                'created_at' => '登録日時',
                'updated_at' => '更新日時'
        ],
        'parameters' => [
                '0' => 'なし',
                '1' => 'あり'
        ],

        'status' => [
                '0' => '無効',
                '1' => '有効'
        ],

        'comment' => [
                'csvFile' => '文字コードがUTF-8のCSVファイルを選択してください'
        ]
]
;

