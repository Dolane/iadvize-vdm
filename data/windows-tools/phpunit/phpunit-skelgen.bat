@echo off
setlocal EnableDelayedExpansion

CALL %~dp0..\_config.bat

@php %PHPUNIT_SKELGEN_CMD% %*

REM Command line exemple :

REM CALL phpunit-skelgen generate-test -- "iadvdm\business\ArticlesApi" %PROJECT%\class\business\ArticlesApi.class.php "iadvdm\business\ArticlesApiTest" %PROJECT%\test\class\business\ArticlesApi.test.php

REM CALL phpunit-skelgen generate-test -- "iadvdm\service\api\Post" %PROJECT%\class\service\api\Post.class.php "iadvdm\service\api\PostTest" %PROJECT%\testclass\\service\api\Post.test.php
REM CALL phpunit-skelgen generate-test -- "iadvdm\service\api\Posts" %PROJECT%\class\service\api\Posts.class.php "iadvdm\service\api\PostsTest" %PROJECT%\testclass\\service\api\Posts.test.php

REM CALL phpunit-skelgen generate-test -- "iadvdm\service\Error" %PROJECT%\class\service\Error.class.php "iadvdm\service\ErrorTest" %PROJECT%\testclass\\service\Error.test.php

REM CALL phpunit-skelgen generate-test -- "iadvdm\vdm\VdmArticle" %PROJECT%\class\vdm\VdmArticle.class.php "iadvdm\vdm\VdmArticleTest" %PROJECT%\testclass\\vdm\VdmArticle.test.php
REM CALL phpunit-skelgen generate-test -- "iadvdm\vdm\VdmArticlesManager" %PROJECT%\class\vdm\VdmArticlesManager.class.php "iadvdm\vdm\VdmArticlesManagerTest" %PROJECT%\testclass\\vdm\VdmArticlesManager.test.php
REM CALL phpunit-skelgen generate-test -- "iadvdm\vdm\VdmArticlesParser" %PROJECT%\class\vdm\VdmArticlesParser.class.php "iadvdm\vdm\VdmArticlesParserTest" %PROJECT%\testclass\\vdm\VdmArticlesParser.test.php
REM CALL phpunit-skelgen generate-test -- "iadvdm\vdm\VdmArticlesUtils" %PROJECT%\class\vdm\VdmArticlesUtils.class.php "iadvdm\vdm\VdmArticlesUtilsTest" %PROJECT%\testclass\\vdm\VdmArticlesUtils.test.php

REM CALL phpunit-skelgen generate-test -- "iadvdm\Utils" %PROJECT%\class\Utils.class.php "iadvdm\UtilsTest" %PROJECT%\testclass\\Utils.test.php