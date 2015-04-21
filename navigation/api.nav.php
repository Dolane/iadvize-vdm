<?php
/**
 * Define navigation for /api URL
 */

$app = Slim\Slim::getInstance(APP_NAME);

/**
 * URL : <app_name>/api/posts
 */
$app->get('/api/posts', function () use ($app) {
	\iadvdm\Timer::start('/api/posts');
	$r_params = $app->request->params();
	$json_response = \iadvdm\business\ArticlesApi::getPosts($r_params);
	
	$app->response->headers->set('Content-Type', SLIM_JSON_CONTENT_TYPE);
	$app->response->write($json_response);
	
	$requestUrl = $app->request->getPathInfo();
	if(!empty($_SERVER['QUERY_STRING'])){
		$requestUrl .= '?'.$_SERVER['QUERY_STRING'];
	}
	\Logger::getLogger(APP_NAME)->info('Response to "'.$requestUrl.'" done in '.\iadvdm\Timer::getDuration('/api/posts'));
});

/**
 * URL : <app_name>/api/posts/<id>
 */
$app->get('/api/posts/:id', function ($id) use ($app) {
	\iadvdm\Timer::start('/api/posts/:id');
	$json_response = \iadvdm\business\ArticlesApi::getPost($id);

	$app->response->headers->set('Content-Type', SLIM_JSON_CONTENT_TYPE);
	$app->response->write($json_response);

	$requestUrl = $app->request->getPathInfo();
	if(!empty($_SERVER['QUERY_STRING'])){
		$requestUrl .= '?'.$_SERVER['QUERY_STRING'];
	}
	\Logger::getLogger(APP_NAME)->info('Response to "'.$requestUrl.'" done in '.\iadvdm\Timer::getDuration('/api/posts/:id'));
});
?>