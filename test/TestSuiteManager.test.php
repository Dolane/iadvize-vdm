<?php
$testRunner = new \PHPUnit_TextUI_TestRunner();
$testSuite  = new \PHPUnit_Framework_TestSuite();
$testResult = new \PHPUnit_Framework_TestResult();
$jsonResultFile = './test/result.json';
$arguments = array(
		'backupGlobals' => false,
		'jsonLogfile'=>$jsonResultFile
);

$testFiles = array(
		'./test/class/vdm/VdmArticle.test.php',
);

$testSuite->addTestFiles($testFiles);
// TODO : Catch doRun buffer to avoid output on page
$testResult = $testRunner->doRun($testSuite, $arguments);

$json_response = array();
if(file_exists($jsonResultFile)){
	$json_response = file_get_content($jsonResultFile);

	$app->response->headers->set('Content-Type', SLIM_JSON_CONTENT_TYPE);
	$app->response->write($json_response);
}
?>