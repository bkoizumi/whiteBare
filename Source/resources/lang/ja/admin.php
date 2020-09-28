<?php

return [
        'sysName' => '管理者管理',
        'path' => [
                'index' => '登録情報一覧',
                'create' => '新規登録',
                'edit' => '編集'
        ],
        'searchListCount' => '全 :total 件中 :from - :to 件を表示',

        'item' => [
                'name' => '氏名',
                'password' => 'パスワード',
                'email' => 'メールアドレス',
                'lid' => 'lid',
                'authority' => '権限',
                'locale' => '言語',
                'status' => '状態',
                'created_at' => '登録日時',
                'updated_at' => '更新日時'
        ],
        'authority' => [
                '1' => 'システム管理',
                '2' => '運営管理',
                '3' => 'メッセージ管理',
                '4' => '配信リスト管理',
                '5' => '配信管理',
                '6' => 'ゲスト'
        ],
        'locale' => [
                'ja' => '日本語',
                'en' => '英語'
        ],
        'status' => [
                '0' => '無効',
                '1' => '有効'
        ]
]
;
