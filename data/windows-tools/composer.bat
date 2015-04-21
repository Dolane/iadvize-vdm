@echo off
setlocal EnableDelayedExpansion

CALL %~dp0_config.bat

REM Penser a ajouter "sslVerify = false" dans la config de GIT (Git/etc/gitconfig)

echo Quelle action Composer voulez-vous effectuer ?
echo 1] Install
echo 2] Update
echo.

set /p action_choice=

if %action_choice%==1 (
CHDIR %COMPOSER_FOLDER%
php composer.phar install
)
if %action_choice%==2 (
CHDIR %COMPOSER_FOLDER%
php composer.phar update
)
