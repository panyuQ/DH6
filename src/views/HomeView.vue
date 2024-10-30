<script setup>
import { ref, onMounted, onBeforeUnmount, inject, reactive } from 'vue';
import { loginStatus } from '@/api';
import { useRouter } from 'vue-router';
import { Picture as IconPicture } from '@element-plus/icons-vue'
import { Menu, Content } from '@/components/Home';
import { findAllByNotGreaterLevel } from '@/api/config_page_menu';

const speed = import.meta.env.VITE_STATUS_SPEED;
const status = ref({});
const PAGE_HOME = inject('PAGE_HOME');
const APP = inject('APP');
const router = useRouter();
const DATA = ref({
    menu: null,
    content: null,
})


const checkLoginStatus = async () => {
    const result = await loginStatus();
    if (!result.result) {
        logOut();
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
    if (status.value?.result) {
        await import('@/api').then(api => api.logout());
    }
    // 跳转到登录页面
    router.push({ name: 'login' })
};


const xxx = async () => {

    DATA.value.menu = await findAllByNotGreaterLevel()
};
const font = reactive({
    color: 'rgba(255, 255, 255, .15)',
})

</script>

<template>
    <el-container class="container">

        <el-aside :style="{ width: PAGE_HOME.aside.width }" class="aside">

            <el-tooltip class="title" effect="dark" :content="APP.description" placement="bottom-end">
                <a href="/" class="app-link">
                    <el-image :src="APP.logo" class="logo">
                        <template #error>
                            <div class="image-slot">
                                <el-icon><icon-picture /></el-icon>
                            </div>
                        </template>
                    </el-image>
                    <div class="app-title">
                        <div class="name">{{ APP.name.toUpperCase() }}</div>
                        <div class="version">v{{ APP.version }}</div>
                    </div>
                </a>
            </el-tooltip>
            <div class="content">
                <Menu :datas="DATA.menu" />
            </div>

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

            <el-main class="main">
                <el-watermark class="content" :font="font" :content="[status.id + '-' + status.level, status.name]">
                    <el-button @click="xxx">点击</el-button>
                </el-watermark>
            </el-main>
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
    font-weight: normal;
    color: var(--color-text-2);
    line-height: 1;
}

.header .status .name {
    font-size: 1.75rem;
    font-weight: bold;
    color: var(--color-heading);
    line-height: 1;
}

.main {
    position: relative;
    padding: 0;
    z-index: 1;
}

.main .content {
    width: 100%;
    height: 100%;
    padding: 20px;
}

/* 新增的样式 */
.app-link {
    --logo-size: 60px;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    height: var(--logo-size);
    text-decoration: none;
    color: inherit;
    column-gap: 10px;

    padding: 10px 0 10px 40px;
}

.logo {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.app-title {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    align-items: flex-end;
    column-gap: 5px;
}

.app-title .name {
    font-size: 1.75rem;
    font-weight: bold;
    color: var(--color-heading);
    line-height: 1;
}

.app-title .version {
    font-size: 1rem;
    color: var(--color-text-2);
    line-height: 1;
}
</style>