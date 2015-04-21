<?php
namespace iadvdm;

/**
 * Beautifying standart PHPUnit results 
 * @author Ludovic TOURMAN
 *
 */
class PHPUnitResultsFormatter {
	private $puResults;
	
	public function __construct(\PHPUnit_Framework_TestResult $puResults){
		$this->puResults = $puResults;
	}
	
	/**
	 * Beautify TestResult to html 
	 * @return string $html : Return Html code
	 */
	public function getHtmlResults(){
		// TODO : Send Html formatted results 
		return '';
	}
	
	/**
	 * Beautify TestResult to json
	 * @return string $json : Return a json string 
	 */
	public function getJsonResults(){
		$a_result = array();
		
		// Loop on passed tests
		$a_passed = array();
		foreach ($this->puResults->passed() as $test){
			$a_passed[] = $test;
		}
		$a_result['passed'] = $a_passed;
		
		// Loop on failure tests
		$a_failures = array();
		foreach ($this->puResults->failures() as $test){
			$a_failures[] = $test;
		}
		$a_result['failures'] = $a_failures;
		
		// Loop on error tests
		$a_errors = array();
		foreach ($this->puResults->errors() as $test){
			$a_errors[] = $test;
		}
		$a_result['errors'] = $a_errors;
		
		// Loop on skipped tests
		$a_skipped = array();
		foreach ($this->puResults->skipped() as $test){
			$a_skipped[] = $test;
		}
		$a_result['skipped'] = $a_skipped;
		
		return json_encode($a_result, JSON_PRETTY_PRINT);
	}
}