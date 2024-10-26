@echo off

:: 配置端口
set API_PORT=8081
set API_DIR=".\slim-api\public"

:: 启动 PHP 内置服务器
php -S localhost:%API_PORT% -t %API_DIR%