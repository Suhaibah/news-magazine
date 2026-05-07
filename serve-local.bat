@echo off
cd /d "%~dp0"
C:\xampp\php\php.exe -S 127.0.0.1:8009 -t public > storage\logs\php-server.log 2>&1
