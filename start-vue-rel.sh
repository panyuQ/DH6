#!/bin/bash

# 设置代码页为 UTF-8
export LANG=en_US.UTF-8

# 配置端口、目录
VUE_PORT=8080
VUE_DIR=./dist

# 编译 Vue 项目
echo "正在编译 Vue 项目..."
npm run build

# 检查编译是否成功
if [ $? -eq 0 ]; then
  echo "编译成功。"
  
  http-server $VUE_DIR -p $VUE_PORT
else
  echo "编译失败。"
  exit 1
fi