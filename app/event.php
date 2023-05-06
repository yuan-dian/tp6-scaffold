<?php
// 事件定义文件
return [
    'bind' => [
    ],

    'listen' => [
        'AppInit' => ['app\event\LoadConfig'],
        'HttpRun' => [],
        'HttpEnd' => ['app\event\AsyncEvent'],
        'LogLevel' => [],
        'LogWrite' => [],
    ],

    'subscribe' => [
    ],
];
