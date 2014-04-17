@echo off
set module=%~dp0module
set doc=%~dp0doc\phpDoc

echo.
echo Code folder : %module%
echo Destination folder : %doc%
echo.
echo Generating documentation ...
echo.
call phpdoc -d "%module%" -t "%doc%"
echo.
if exist "%doc%\index.html" goto LAUNCH
goto EXIT

:LAUNCH
echo.
echo Press any key to open report
pause > nul
start chrome --allow-file-access-from-files "%doc%\index.html"
exit


:EXIT
echo.
echo Press any key to quit
pause > nul
exit