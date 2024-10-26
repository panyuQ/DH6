@echo off

:: 设置代码页为 UTF-8
chcp 65001 >nul

:: 配置端口、目录
set VUE_PORT=8080
set VUE_DIR=".\dist"

:: 编译 Vue 项目
echo 正在编译 Vue 项目...
call npm run build

:: 检查编译是否成功
if %errorlevel% equ 0 (
  echo 编译成功。

  http-server %VUE_DIR% -p %VUE_PORT%
) else (
  echo 编译失败。
  exit /b 1
)