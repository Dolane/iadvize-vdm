@echo off
setlocal EnableDelayedExpansion

CALL _config.bat

CALL %BEHAT_BAT_LOCATION%
