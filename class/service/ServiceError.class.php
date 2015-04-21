<?php
namespace iadvdm\service;

/**
 * Class to encapsulate Errors/Exceptions to json response
 * @author Ludovic TOURMAN
 *
 */
class ServiceError {
	public $code;
	
	public $message;
	
	public function __construct($code = null, $message = null){
		$this->code 	= $code;
		$this->message 	= $message;
	}
	
	/**
	 * Instanciate class from PHP Exception
	 * @param Exception $e
	 * @return \iadvdm\service\ServiceError
	 */
	public function setFromException(Exception $e){
		$this->code = $e->getCode();
		$this->message = $e->getMessage();
		return $this;
	}
	
	/**
	 * Return a custom array for json error response
	 * @return Custom array for json response
	 */
	public function getJsonError(){
		// TODO : Map custom code and message from exception for service users
		$code = 'TECH-ERR-0';
		$message = 'An unexpected error has occurred.';
		
		$userError = array(
			'error'=>array(
				'code'		=>$code
				,'message' 	=>$message)
			);
		return $userError;
	}
	
	/**
	 * Log this error with Log4PHP
	 * @return \iadvdm\service\ServiceError
	 */
	public function logError(){
		$message = $this->code.' : '.$this->message;
		
		if(!empty($message)){
			\Logger::getLogger(APP_NAME)->error($message);
		}
		return $this;
	}
}
?>