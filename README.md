# Log4p

Implementation of log for php

## Install

Via Composer

``` bash
$ composer require log4p/log4p
```

## Usage

``` php
// use default config
$logger = LoggerFactory::getLogger(__CLASS__);
$logger->info("This is a log info.", ['paramKey1'=>'paramValue1','paramKey2'=>'paramValue2']);
// use custom config
LoggerFactory::setConfigs(dirname(__DIR__).'/config/myconfig.php');
$logger = LoggerFactory::getLogger(__CLASS__);
$logger->info("This is a custom log info.", ['paramKey1'=>'paramValue1','paramKey2'=>'paramValue2']);
```

## Config

``` php
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
```

## Testing

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/DestinyAries/log4p/blob/master/LICENSE) for more information.
