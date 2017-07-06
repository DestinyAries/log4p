<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Configuration for log4p
    |--------------------------------------------------------------------------
    |
    | timezone 
    */
    'timezone' => "Asia/Shanghai",
    
    /*
    |--------------------------------------------------------------------------
    | Configuration for log4p
    |--------------------------------------------------------------------------
    |
    | key : filename
    | value : [
    |   namespace: '*' matching all classes.
    |   filePath: a file path to store the log.
    |   filenameFormat: a log file name format.
    |   contentFormat: a log content format.
    | ]
    */
    'rule' => [
        'sysout' => [
            'namespace' => '*',
            'filePath' => dirname(__DIR__).'/logs/sysout.log',
            'filenameFormat' => [
                'filename' => '{filename}-{date}',
                'date' => 'Ymd'
            ],
            'contentFormat' => [
                'content' => "[%datetime%] %level_name% - #className#: %message% %context% %extra%\n",
                'date' => 'Y-m-d H:i:s'
            ]
        ],
        'log4p' => [
            'namespace' => 'Log4p',
            'filePath' => dirname(__DIR__).'/logs/log4p.log',
            'filenameFormat' => [
                'filename' => '{filename}-{date}',
                'date' => 'Ymd'
            ],
            'contentFormat' => [
                'content' => "[%datetime%] %level_name% - #className#: %message% %context% %extra%\n",
                'date' => 'Y-m-d H:i:s'
            ]
        ]
    ],
];
