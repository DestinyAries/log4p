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

## Testing

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/DestinyAries/log4p/blob/master/LICENSE) for more information.
