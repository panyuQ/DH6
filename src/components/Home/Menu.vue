<script lang="ts" setup>
import * as Icons from '@element-plus/icons-vue';
const props = defineProps({
    datas: {
        type: Object,
    }
})

const handleSelect = (key: string, keyPath: string[]) => {
    console.log(key, keyPath);
}

</script>

<template>
    <el-menu :unique-opened="true" @select="handleSelect">
        <template v-for="item in datas">
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