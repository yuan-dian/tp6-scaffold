<?php

return [
    // 上传授权检测 key值为 产品动态授权项标识key，根据此标识动态获取验证的动态权限值
    'upload' => [
        // 全局限制 global 非产品动态授权项标识key
        'global' => [
            'class' => 'app\service\grant\policy\upload\GlobalLimit',
            'custom_limits' => [
                'day_limit'  => 999,   // 上传文件个数  999个/天
            ]
        ],
        // 文件上传次数
        'upload_limit' => [
            'class' => 'app\service\grant\policy\upload\UploadLimit'
        ]
    ],

    // 转换授权检测  key值为 产品动态授权项标识key，根据此标识动态获取验证的动态权限值
    'convert' => [
        // 图片转PDF批量
        'img2pdf_file_limit' => [
            'class' => 'app\service\grant\policy\convert\ImgToPdf',
        ],

        // PDF合并批量
        'pdfmerge_file_limit' => [
            'class' => 'app\service\grant\policy\convert\PdfMerge',
        ]
    ],
];