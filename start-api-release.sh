#!/bin/bash

# 配置端口、目录
API_PORT=8080
API_DIR="./slim-api/public"

# 启动 PHP 内置服务器
php -S localhost:$API_PORT -t $API_DIR

