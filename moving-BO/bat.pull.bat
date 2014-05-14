@echo off

echo.
echo git pull
echo.
git pull
echo.
echo Clearing cache ...
echo.
if exist "%~dp0\data\cache\" del /f /q /s "%~dp0\data\cache\*" && FOR /D %%p IN ("%~dp0\data\cache\*") DO rmdir "%%p" /s /q
rem if exist "%~dp0\data\cache\css\" del /f /q /s "%~dp0\data\cache\css\*" && FOR /D %%p IN ("%~dp0\data\cache\css\*") DO rmdir "%%p" /s /q
echo * > "%~dp0\data\cache\.gitignore"
echo !.gitignore >>  "%~dp0\data\cache\.gitignore"
echo.
echo Press any key to quit
pause > nul