@echo off
set bin_doctrine=%~dp0\vendor\doctrine\doctrine-module\bin\doctrine-module
echo.
echo Dump SQL:
echo.
php "%bin_doctrine%" orm:schema-tool:create --dump-sql

:MENU
echo.
set /p msg=Import SQL (y/n)? 
if "%msg%"=="y" goto IMPORT
if "%msg%"=="n" goto EXIT
goto MENU

:IMPORT
echo.
php "%bin_doctrine%" orm:schema-tool:update --force
goto EXIT

:EXIT
echo.
echo Press any key to quit
pause > nul