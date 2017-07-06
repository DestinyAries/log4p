<?php 
namespace Log4p;

use Log4p\LoggerFactory;

class LoggerTest extends \PHPUnit\Framework\TestCase
{
    public function testLogger()
    {
    	$logger = LoggerFactory::getLogger(__CLASS__);
    	$logger->info("This is a test log info.");
    	$logger->info("People info log", ['name'=>'destiny', 'gender'=>'gril', 'age'=>1]);
    }
}