<?php
//Automatic requires from composer.phar
require './lib/vendor/autoload.php';
//Global configuration (not specific to environnement)
require './config/__global.conf.php';

// Instanciate Slim Framework application
$app = new Slim\Slim();
// Set the application name to SlimApplication (In case of mutliple Slim Projects on server)
$app->setName(APP_NAME);

/**
 * Those requires has to be called after $app->setName(APP_NAME)
 * because they are using Slim Framework $app object
 */

// Check if level config file exists, if not, load the default one
if(file_exists('./config/'.APP_LEVEL.'.conf.php')){
	require './config/'.APP_LEVEL.'.conf.php';
}else{
	require './config/_default.conf.php';
}

// Load utils
require './class/Utils.class.php';

// Load vdm specific classes
require './class/vdm/VdmArticle.class.php';
require './class/vdm/VdmArticlesUtils.class.php';
require './class/vdm/VdmArticlesManager.class.php';
require './class/vdm/VdmArticlesParser.class.php';

// Load business classes
require './class/business/ArticlesApi.class.php';

// Load service classes
require './class/service/ServiceError.class.php';
require './class/service/api/Posts.class.php';
require './class/service/api/Post.class.php';

// Load navigation files
require './navigation/_global.nav.php';
require './navigation/api.nav.php';

// Set custom log writer
$app->log->setWriter(new \iadvdm\Log4PHPSlimLogWriter());

// Launch Slim Framework application
$app->run();
?>

