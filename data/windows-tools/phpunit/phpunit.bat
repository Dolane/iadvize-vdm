@echo off
setlocal EnableDelayedExpansion

CALL %~dp0..\_config.bat

@php %PHPUNIT_CMD% %*