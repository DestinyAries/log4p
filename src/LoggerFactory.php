<?php 
namespace Log4p;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;
use Log4p\BaseLogger;

class LoggerFactory
{
    /**
     * 默认时区
     */
    private const DEFAULT_TIMEZONE = "Asia/Shanghai";
	/**
	 * 默认文件名
	 */
    private const DEFAULT_NAME = 'sysout';
    /**
     * 默认文件名称格式
     */
    private const DEFAULT_FILENAME_FORMAT = '{filename}-{date}';
    /**
     * 默认文件名称-日期格式
     */
    private const DEFAULT_FILENAME_DATE_FORMAT = 'Ymd';
    /**
     * 默认日志内容格式
     */
    private const DEFAULT_CONTENT_FORMAT = "[%datetime%] %level_name% - #className#: %message% %context% %extra%\n";
    /**
     * 默认日志内容-日期格式
     */
    private const DEFAULT_CONTENT_DATE_FORMAT = 'Y-m-d H:i:s';
    /**
     * 配置
     */
    protected static $configs = array();

    /**
     * 设置自定义配置文件，格式参见config/default.php
     * @param string $filePath
     * @throws MissingException
     */
    public static function setConfigs(string $filePath)
    {
        if ($filePath && file_exists($filePath)) {
            self::$configs = require($filePath); 
        } else {
            throw new MissingException("Unable to load $filePath.");
        }
    }

    /**
     * 获取日志实例
     * @param string $type 类名
     * @param int $level 日志记录等级
     * @return \Monolog\Logger
     */
    public static function getLogger(string $className = self::DEFAULT_NAME, $level = BaseLogger::INFO)
    {
        // 读取配置文件
        $curConfigs = self::$configs ?? require(dirname(__DIR__).'/config/default.php');
        // 设置时区
        date_default_timezone_set(self::getByKey($curConfigs, 'timezone') ?? self::DEFAULT_TIMEZONE);
        // 日志类型
        $type = NULL;
        // 配置文件的*配置类型
        $remainType = NULL;
        // 存储路径
        $filePath = NULL;
        // 日志文件名格式化
        $filenameFormat = NULL;
        // 日志文件名日期格式化
        $filenameDateFormat = NULL;
        // 日志内容格式化
        $contentFormat = NULL;
        // 日志内容日期格式化
        $contentDateFormat = NULL;
        // 获取配置规则
        if (self::getByKey($curConfigs, 'rule')) {
            foreach ($curConfigs['rule'] as $key => $config) {
                $namespace = self::getByKey($config, 'namespace');
                if ($namespace && 
                    (stripos($className, $namespace) !== false || $namespace == '*')) {
                    $filePath = self::getByKey($config, 'filePath');
                    $filenameFormat = self::getBySubKey($config, 'filenameFormat', 'filename');
                    $filenameDateFormat = self::getBySubKey($config, 'filenameFormat', 'date');
                    $contentFormat = self::getBySubKey($config, 'contentFormat', 'content');
                    $contentDateFormat = self::getBySubKey($config, 'contentFormat', 'date');
                    if (stripos($className, $namespace) !== false) {
                        $type = $key;
                    }
                    if ($namespace == '*') {
                        $remainType = $key;
                    }
                }
            }
        }
        $type = $type ?? $remainType ?? self::DEFAULT_NAME;
        $filePath = $filePath ?? dirname(__DIR__).'/logs/'. $type .'.log';
        $filenameFormat = $filenameFormat ?? self::DEFAULT_FILENAME_FORMAT;
        $filenameDateFormat = $filenameDateFormat ?? self::DEFAULT_FILENAME_DATE_FORMAT;
        $contentFormat = $contentFormat ?? self::DEFAULT_CONTENT_FORMAT;
        $contentDateFormat = $contentDateFormat ?? self::DEFAULT_CONTENT_DATE_FORMAT;

        $formatter = new LineFormatter(str_replace("#className#", $className, $contentFormat), $contentDateFormat, true, true);
        $formatter->includeStacktraces();
        $log = new BaseLogger($type);
        // 按日记日志
        $stream = new RotatingFileHandler($filePath, 0, $level);
        // 文件名格式
        $stream->setFilenameFormat($filenameFormat, $filenameDateFormat);
        // 日志内容格式
        $stream->setFormatter($formatter);
        $log->pushHandler($stream);
        return $log;
    }

    /**
     * 根据key获取value
     * @param array $array
     * @param string $key
     * @return NULL|array
     */
    private static function getByKey($array, $key)
    {
        return array_key_exists($key, $array) ? $array[$key] : NULL;
    }

    /**
     * 根据key和subKey获取value
     * @param array $array
     * @param string $key
     * @param string $subKey
     * @return NULL|array
     */
    private static function getBySubKey($array, $key, $subKey)
    {
        return array_key_exists($key, $array) ? 
            (array_key_exists($subKey, $array[$key]) ? $array[$key][$subKey] : NULL) : NULL;
    }
}
