<script lang="ts" setup>
import * as Icons from '@element-plus/icons-vue';
import { ref, computed } from 'vue';
import type { PropType } from 'vue';

interface MenuItem {
    id: number;
    name?: string;
    folder?: string;
    icon?: string;
    children?: MenuItem[];
}

const props = defineProps({
    datas: {
        type: Array as PropType<MenuItem[]>,
        required: true,
        default: []
    },
    activeIndex: {
        type: String,
        default: '0'
    },
    handleSelect: {
        type: Function,
        default: (key: string) => {
            import('element-plus').then(({ ElMessage }) => {
                ElMessage.warning('此处尚未开放');
            });
        }
    }
});

// 使用 computed 计算 DATA，添加有效性检查
const DATA = computed(() => {
    if (!props.datas || !Array.isArray(props.datas)) {
        return []; // 返回一个空数组，避免 forEach 出错
    }

    const result: MenuItem[] = [];
    const folder: Record<string, MenuItem[]> = {};

    props.datas.forEach((item) => {
        if (item.folder != null) {
            if (item.name == null) {
                result.push(item);
                item.children = [];
                folder[item.folder] = item.children;
            } else {
                (folder[item.folder] || (folder[item.folder] = [])).push(item);
            }
        } else {
            result.push(item);
        }
    });

    // 为每个 folder 添加 children
    result.forEach((item) => {
        if (folder[item.folder]) {
            item.children = folder[item.folder];
        }
    });

    return result;
});
</script>

<template>
    <el-menu :unique-opened="true" @select="handleSelect" :default-active="activeIndex">
        <template v-for="item in DATA" :key="item.id">
            <el-sub-menu v-if="item.folder" :index="item.id.toString()">
                <template #title>
                    <el-icon>
                        <component :is="Icons[item.icon]" />
                    </el-icon>
                    <span>{{ item.folder }}</span>
                </template>
                <el-menu-item v-for="subItem in item.children" :key="subItem.id" :index="subItem.id.toString()">
                    <template #title>
                        <el-icon>
                            <component :is="Icons[subItem.icon]" />
                        </el-icon>
                        <span>{{ subItem.name }}</span>
                    </template>
                </el-menu-item>
            </el-sub-menu>
            <el-menu-item v-else :index="item.id.toString()">
                <template #title>
                    <el-icon>
                        <component :is="Icons[item.icon]" />
                    </el-icon>
                    <span>{{ item.name }}</span>
                </template>
            </el-menu-item>
        </template>
    </el-menu>
</template>

<style scoped>
.el-menu {
    --el-menu-bg-color: var(--color-background-mute);
    --el-menu-hover-bg-color: var(--color-background-soft);
    --el-menu-text-color: var(--color-text-1);
}
</style>
