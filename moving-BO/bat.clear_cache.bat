@echo off

:CLEAR
cls
if exist "%~dp0\data\cache\" del /f /q /s "%~dp0\data\cache\*" && FOR /D %%p IN ("%~dp0\data\cache\*") DO rmdir "%%p" /s /q
rem if exist "%~dp0\data\cache\css\" del /f /q /s "%~dp0\data\cache\css\*" && FOR /D %%p IN ("%~dp0\data\cache\css\*") DO rmdir "%%p" /s /q
echo * > "%~dp0\data\cache\.gitignore"
echo !.gitignore >>  "%~dp0\data\cache\.gitignore"
echo.
echo Press any key to clear cache
pause>nul
goto CLEAR

:EXIT
echo.
echo Exiting...
ping -n 2 127.0.0.1 > nul