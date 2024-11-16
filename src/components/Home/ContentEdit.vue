<script setup>
import { isRoot } from '@/api';

import { ref, onBeforeMount } from 'vue';
const status = ref(false);
const DATA = ref(null);
const PAGE = ref({
    id: null,
    level: null
})
onBeforeMount(async () => {
    if ((await isRoot()).result) {
        status.value = true;
        DATA.value = await import('@/api/config_page_menu').then(api => api.findAll());
    } else {
        status.value = false;
    }
})

const toLabel = (folder, name) => {
    if (folder && name) {
        return `${folder} / ${name}`
    } else {
        return folder || name;
    }
}

</script>

<template>
    <template v-if="status">
        <el-form>
            <el-row :gutter="10">
                <el-col :span="5">
                    <el-select v-model="PAGE.id" placeholder="页面">
                        <el-option v-for="item in DATA" :label="toLabel(item.folder, item.name)" :key="item.id"
                            :value="item.id" class="label">
                            <template #default>
                                <span v-if="item.folder && item.name">{{ item.folder }} / {{ item.name }}</span>
                                <span v-else>
                                    {{ item.folder || item.name }}
                                </span>
                                <div v-if="item.level">
                                    <span v-if="!item.name" class="folder">目录 </span>
                                    <span class="level">Lv.{{ item.level }}</span>
                                </div>
                            </template>
                        </el-option>
                    </el-select>
                </el-col>
            </el-row>
        </el-form>

    </template>
</template>

<style scoped>
.label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}
.label .folder {
    color: #939393;
}
.label .level {
    color: #67c23a;
}
</style>