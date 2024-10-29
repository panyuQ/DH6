<script setup>
import { ref, onMounted, onBeforeUnmount, inject } from 'vue';
import { loginStatus } from '@/api';

const speed = import.meta.env.VITE_STATUS_SPEED;
const status = ref({});
const asideWidth = ref(inject('PAGE_HOME').aside.width);
const checkLoginStatus = async () => {
    const result = await loginStatus();
    if (!result.result) {
        window.location.href = '/login';
    } else {
        status.value = result;
    }
};

onMounted(() => {
    // 初始检查
    checkLoginStatus();

    // 每 SPEED 毫秒检查一次
    const intervalId = setInterval(checkLoginStatus, speed);

    // 在组件卸载时清除定时器
    onBeforeUnmount(() => {
        clearInterval(intervalId);
    });

});

const logOut = async () => {
    if (status.value.result) {
        await import('@/api').then(api => api.logout());
    }
    // 跳转到登录页面
    window.location.href = '/login';
};

const startDragging = (e) => {
    e.preventDefault();
    document.addEventListener('mousemove', onDragging);
    document.addEventListener('mouseup', stopDragging);
};

const onDragging = (e) => {
    const newWidth = e.clientX + 'px';
    asideWidth.value = newWidth;
};

const stopDragging = () => {
    document.removeEventListener('mousemove', onDragging);
    document.removeEventListener('mouseup', stopDragging);
};
</script>

<template>
    <el-container class="container">
        <el-aside :style="{ width: asideWidth }" class="aside">
            <div class="resize-handle" @mousedown="startDragging"></div>
            Aside
        </el-aside>
        <el-container>
            <el-header class="header">
                <div class="status">
                    <div class="id">{{ status.id }}-{{ status.level }}</div>
                    <el-popconfirm title="是否确认注销?" @confirm="logOut">
                        <template #reference>
                            <div class="name">
                                {{ status.name }}
                            </div>
                        </template>
                    </el-popconfirm>
                </div>
            </el-header>
            <el-main class="main">Main</el-main>
        </el-container>
    </el-container>
</template>

<style scoped>
.container {
    position: relative;
    height: 100vh;
}

.aside {
    position: sticky;
    left: 0;
    top: 0;
    height: 100vh;
    border-right: 1px solid var(--color-border);
    overflow: hidden;
    z-index: 3;
}

.resize-handle {
    position: absolute;
    right: -5px;
    top: 0;
    bottom: 0;
    width: 10px;
    background-color: transparent;
    cursor: col-resize;
    z-index: 10;
}

.header {
    position: sticky;
    top: 0;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 15px 40px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 2;
    border-bottom: 1px solid var(--color-border);
}

.header .status {
    display: flex;
    align-items: flex-end;
    column-gap: 10px;
}

.header .status .id {
    font-size: .75rem;
    /* 较小的字体大小 */
    font-weight: normal;
    /* 正常粗细 */
    color: var(--color-text);
    /* 较浅的文字颜色 */
    line-height: 1;
}

.header .status .name {
    font-size: 1.75rem;
    /* 较大的字体大小 */
    font-weight: bold;
    /* 加粗 */
    color: var(--color-heading);
    /* 更亮的文字颜色 */
    line-height: 1;
}

.main {
    position: relative;
    padding: 20px;
    z-index: 1;
}
</style>