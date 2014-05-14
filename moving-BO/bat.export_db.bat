@echo off
echo.

set host=localhost
set db=cervin
set user=root

:MENU
echo -- Default values --
echo Host : %host%
echo DB : %db%
echo User: %user%
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

goto DUMP


:DUMP
mysqldump -h %host% -u %user% %db% > %db%.sql
start notepad %db%.sql
goto EXIT

:EXIT
echo.
echo Press any key to quit
pause > nul