<?php
/**
 * Define navigation for / URL
 */

$app = Slim\Slim::getInstance(APP_NAME);

/**
 * URL : <app_name>/
 */
$app->get('/', function () use ($app) {
	require './instructions.html';
});

/**
 * URL : <app_name>/phpunit
 */
$app->get('/phpunit', function () use ($app) {
	require './test/TestSuiteManager.test.php';
});
?>