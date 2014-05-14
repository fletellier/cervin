@echo off

if exist "%~dp0\vendor\.composer\files\" del /f /q /s "%~dp0\vendor\.composer\files\*" && FOR /D %%p IN ("%~dp0\vendor\.composer\files\*") DO rmdir "%%p" /s /q
if exist "%LOCALAPPDATA%\Composer\files\" del /f /q /s "%LOCALAPPDATA%\Composer\files\*" && FOR /D %%p IN ("%LOCALAPPDATA%\Composer\files\*") DO rmdir "%%p" /s /q
php composer.phar self-update
php composer.phar update

:EXIT
echo.
echo Press any key to quit
pause > nul