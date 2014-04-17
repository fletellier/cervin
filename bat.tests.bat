@echo off

cd tests

:TESTS
cls
call phpunit
echo.
echo.
echo Press any key to launch tests
pause>nul
goto TESTS

:EXIT
echo.
echo Exiting...
ping -n 2 127.0.0.1 > nul