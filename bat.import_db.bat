@echo off
echo.

set host=localhost
set db=cervin
set user=root
set file=%db%.sql

:MENU
echo -- Default values --
echo Host : %host%
echo DB : %db%
echo User: %user%
echo File: %file%
echo.
set /p msg=Use default values : (y/n)? 
if "%msg%"=="y" goto DUMP
if "%msg%"=="n" goto CONFIG
goto MENU

:CONFIG
set /p host=Host : 
echo.

set /p db=DB : 
echo.

set /p user=User : 
echo.

set /p file=File : 
echo.

goto DUMP


:DUMP
mysql -h %host% -u %user% %db% < %file%
rem start notepad %file%
goto EXIT

:EXIT
echo.
echo Press any key to quit
pause > nul