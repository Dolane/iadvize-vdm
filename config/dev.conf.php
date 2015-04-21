<?php
/************************************
 **** DEVELOPPMENT CONFIGURATION ****
 ************************************/

/************************************
 * www.viedemerde.fr configuration	*
 ************************************/
// Base site Url
define('VDM_BASE_URL'				,'http://www.viedemerde.fr/?page=');
// Html files mockup location (Comment VDM_BASE_URL above and uncomment this one)
// define('VDM_BASE_URL'				,'./data/mockups/html/vdm.html.');
// Max new articles to download from site
define('VDM_MAX_ARTICLES_DOWNLOAD'	,200);
// Max articles to respond in api
define('VDM_MAX_ARTICLES_SHOW'		,200);
// Json file location to store articles
define('VDM_ARTICLES_JSON_FILE'		,'./data/json/articles.json');

/************************************
 * Slim Framework configuration  	*
 ************************************/
$app = Slim\Slim::getInstance(APP_NAME);
// Define if Slim Framework is in debug mode (False : Catch all stack trace)
$app->config('debug',true);


/************************************
 * 		Log4PHP configuration  		*
 ************************************/
// Application log folder (Don't forget to give apache write access on it)
define('LOGS_FOLDER'	,'./data/logs');
// Separator to use in Log4PHP
define('LOGS_SEPARATOR'	,' | ');

// Log4PHP definition
Logger::configure(array(
	'rootLogger' => array(
			'appenders' => array('default'),
			// Log level (ERROR|WARN|INFO|DEBUG|TRACE)
			'level'		=> 'DEBUG'
	),
	'appenders' => array(
		'default' => array(
			// Daily logs
			'class' => 'LoggerAppenderDailyFile',
			'layout' => array(
				'class' => 'LoggerLayoutPattern',
				'params' => array(
					// Datetime | LogLevel | AppName | LogMessage | Logging Class+Line
					'ConversionPattern' => '%d{Y-m-d H:i:s}'.LOGS_SEPARATOR.'%p'.LOGS_SEPARATOR.'%c'.LOGS_SEPARATOR.'%m'.LOGS_SEPARATOR.'%F:%L%n'
				)
			),
			'params' => array(
				// File location and name format ("2015-01-01_iadvize-vdm.log")
				'file'			=> LOGS_FOLDER.'/%s_'.APP_NAME.'.log',
				'datePattern'	=> 'Y-m-d',
				'append' 		=> true
			)
		)
	)
));

?>