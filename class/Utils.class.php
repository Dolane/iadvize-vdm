<?php
namespace iadvdm;

/**
 * Utils is a class containing usefull code :)
 * @author Ludovic TOURMAN
 *
 */
class Utils {
	/**
	 * Encode in UTF-8 entire object passed in parameter
	 * @param $object : Object to encode
	 * @return No return : Object is encoded by reference
	 */
	public static function utf8_encode_object(&$object){
		if(is_array($object) || is_object($object)){
			foreach($object as &$unElement){
				self::utf8_encode_object($unElement);
			}
		}else{
			$object = utf8_encode($object);
		}
	}
	
	/**
	 * Decode UTF-8 of entire object passed in parameter
	 * @param $object : Object to decode
	 * @return No return : Object is decoded by reference
	 */
	public static function utf8_decode_object(&$object){
		if(is_array($object) || is_object($object)){
			foreach($object as &$unElement){
				self::utf8_decode_object($unElement);
			}
		}else{
			$object = utf8_decode($object);
		}
	}
}

/**
 * Custom Timer
 * Allow to start, stop, and get duration for multiple instances
 * @author Ludovic TOURMAN
 *
 */
class Timer {
	private static $a_timers = array();
	
	private static $START 		= 'startTime';
	private static $END			= 'endTime';
	private static $INTERVAL	= 'interval';
	
	/**
	 * Start timer for specified index
	 * @param mixed(number|string) $index (Opt.)
	 */
	public static function start($index = 0){
		self::$a_timers[$index] = array(
				self::$START 		=> new \DateTime()
				,self::$END			=> null
				,self::$INTERVAL	=> null
		);
	}
	
	/**
	 * Stop timer for specified index
	 * @param mixed(number|string) $index (Opt.)
	 */
	public static function end($index = 0){
		$startTime;
		$endTime	= new \DateTime(); 
		
		// Check if start() has been called
		$values = self::$a_timers[$index];
		if($values == null || $values[self::$START] == null){
			return null;
		}
		
		// Calculate duration
		$startTime = $values[self::$START];
		$interval = $endTime->diff($startTime);
		
		// Add endTime and interval to values
		$values[self::$END] = $endTime;
		$values[self::$INTERVAL] = $interval;
		
		// Update static timer array with new values 
		self::$a_timers[$index] = $values;
	}
	
	/**
	 * Get duration between start() and stop() timer
	 * @param mixed(number|string) $index (Opt.)
	 * @param string $format (Opt.) : Pattern of duration (See http://php.net/manual/dateinterval.format.php)
	 * @return string $interval
	 */
	public static function getDuration($index = 0, $format = '%Hh%Im%Ss'){
		$values = self::$a_timers[$index];
		//Force end() if endTime not set
		if($values[self::$END] == null){
			self::end($index);
		}
		
		if($values[self::$START] == null){
			return null;
		}
		
		$interval = self::$a_timers[$index][self::$INTERVAL];
		return $interval->format($format);
	}
}

/**
 * Custom SlimLogWriter using Log4PHP 
 * @author Ludovic TOURMAN
 *
 */
class Log4PHPSlimLogWriter {
	
	public function __construct(){
	}
	
	/**
	 * Method called by \Slim\LogWriter (Don't change parameters) to write a log
	 * @param mixed $message
	 * @param integer $slimLogLevel (See http://docs.slimframework.com/logging/levels/)
	 */
	public function write($message, $slimLogLevel = null){
		// SlimLogger is using different log levels than Log4PHP
		// so that, we have to map it with static function 
		\Logger::getLogger(APP_NAME)->log(Log4PHPSlimLogWriter::slimLogLevelToLog4PHPLevel($slimLogLevel), $message);
	}
	
	/**
	 * Static function mapping \Slim\Log to \Log4PHP\LoggerLevel
	 * @param string $slimLogLevel
	 * @return \Log4PHP\LoggerLevel $log4PHPLevel (Default level is set to ERROR)
	 */
	public static function slimLogLevelToLog4PHPLevel($slimLogLevel = null){
		// Set default log4PHP level
		$log4PHPLevel = \LoggerLevel::getLevelError();
		
		// Creating custom mapping array (\Slim\Log -> \Log4PHP\LoggerLevel)
		$a_logLevelMapper = array(
				\Slim\Log::EMERGENCY => \LoggerLevel::getLevelError(),
				\Slim\Log::ALERT => \LoggerLevel::getLevelError(),
				\Slim\Log::CRITICAL => \LoggerLevel::getLevelError(),
				\Slim\Log::ERROR => \LoggerLevel::getLevelError(),
				\Slim\Log::WARN => \LoggerLevel::getLevelWarn(),
				\Slim\Log::NOTICE => \LoggerLevel::getLevelInfo(),
				\Slim\Log::INFO => \LoggerLevel::getLevelInfo(),
				\Slim\Log::DEBUG => \LoggerLevel::getLevelDebug()
		);
		
		// Check if \Slim\Log exists in above array (The truth is out there ;)
		if(array_key_exists($slimLogLevel, $a_logLevelMapper)){
			// Set corresponding \Log4PHP\LoggerLevel
			$log4PHPLevel = $a_logLevelMapper[$slimLogLevel];
		}
		
		return $log4PHPLevel;
	}
}

?>