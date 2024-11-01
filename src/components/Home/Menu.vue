<script lang="ts" setup>
import * as Icons from '@element-plus/icons-vue';
import { ElMessage } from 'element-plus';
import { watch, ref } from 'vue';
const props = defineProps({
    datas: {
        type: Object,
    },
    handleSelect: {
        type: Function,
        default: (key: string, keyPath: string[]) => {
            ElMessage.warning('此处尚未开放')
        }
    }
})

const DATA = ref(null);
watch(() => props.datas, (newDatas) => {
    DATA.value = [];
    const folder = {};

    newDatas.forEach((item: any) => {
        if (item.folder != null) {
            if (item.name == null) {
                // 如果没有名称，直接添加到 DATA 并初始化 children 数组
                DATA.value.push(item);
                item.children = [];
                folder[item.folder] = item.children;
            } else {
                // 如果有名称，添加到对应的 folder 子项中
                (folder[item.folder] || (folder[item.folder] = [])).push(item);
            }
        } else {
            // 没有 folder 的项直接添加到 DATA
            DATA.value.push(item);
        }
    });
});


</script>

<template>
    <el-menu :unique-opened="true" @select="handleSelect">
        <template v-for="item in DATA">
            <el-sub-menu :index="item.id.toString()" v-if="item.folder">
                <template #title>
                    <el-icon>
                        <component :is="Icons[item.icon]" />
                    </el-icon>
                    <span>{{ item.folder }}</span>
                </template>
                <el-menu-item v-for="subItem in item.children" :index="subItem.id.toString()">
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