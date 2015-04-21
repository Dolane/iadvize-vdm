<?php
// Set a unique application name (In case of mutliple Slim Projects on server)
define('APP_NAME'		,'iadvize-vdm');
// Uncomment level corresponding to *.conf.php file which has to be load 
define('APP_LEVEL'		,'prod');
// define('APP_LEVEL'		,'dev');

/************************************
 * Slim Framework configuration  	*
 ************************************/
define('SLIM_JSON_CONTENT_TYPE'		,'application/json; charset=UTF-8');

/************************************
 * www.viedemerde.fr configuration	*
 ************************************/
define('VDM_SELECTOR_ARTICLES'		,'div[class="post article"]');
define('VDM_ARTICLE_DATE_REGEX'		,'/.*([0-9]{2})\/([0-9]{2})\/([0-9]{4}).*([0-9]{2}):([0-9]{2}).*/');
define('VDM_ARTICLE_DATE_FORMAT'	,'$3-$2-$1 $4:$5:00');
define('VDM_ARTICLE_AUTHOR_REGEX'	,'/^.* - par (.*)$/');
define('VDM_ARTICLE_AUTHOR_FORMAT'	,'$1');
?>

