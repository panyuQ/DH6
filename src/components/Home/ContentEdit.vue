<script setup>
import { isRoot } from '@/api';
import * as Icons from '@element-plus/icons-vue';
import { ref, onBeforeMount,reactive,computed } from 'vue';
import Content from './Content.vue'
import { ElMessage, ElMessageBox } from 'element-plus'

const status = ref(false);
const DATA_MENU = ref(null);
const DATA_CONTENT = ref(null);
const PAGE = reactive({
    id: null,
    level: null,
    idData: null,
    levelData: null,
});
const showSource = ref(false);
const formRef = ref({});

const drawerEdit1 = ref(false);
const drawerEdit2 = ref(false);
const INIT = () => {
    status.value = false;
    DATA_MENU.value = null;
    DATA_CONTENT.value = null;
    PAGE.value = {
        id: null,
        level: null,
        idData: null,
        levelData: null,
    };
    showSource.value = false;
    formRef.value = {};
}
const loadData_status = async () => {
    status.value = await isRoot();
}
const loadData_menu = async () => {
    if (status.value) {
        const result = await import('@/api/config_page_menu').then(api => api.findAll());
        if (result.result) {
            DATA_MENU.value = result.data;
        }
    }
}

const loadData_content = async (id) => {
    DATA_CONTENT.value = await import('@/api/config_page_content').then(api => api.findAllById(id))
}

onBeforeMount(async () => {
    await loadData_status();
    await loadData_menu();
})

const toLabel = (folder, name) => {
    if (folder && name) {
        return `${folder} / ${name}`
    } else {
        return folder || name;
    }
}

const textareaValue = computed({
    get() {
        return PAGE.levelData ? JSON.stringify(PAGE.levelData, null, 2) : '';
    },
    set(value) {
        try {
            PAGE.levelData = value ? JSON.parse(value) : null;
        } catch (e) {
            ElMessage.error('输入的内容不是有效的JSON格式');
        }
    }
});

const changeID = async (value) => {
    PAGE.id = value;
    PAGE.level = null;
    PAGE.idData = DATA_MENU.value[value]
    PAGE.levelData = null;
    showSource.value = false;
    await loadData_content(value);
}
const changeLEVEL = (value) => {
    DATA_CONTENT.value.forEach(item => {
        if (item.level === value) {
            PAGE.levelData = JSON.parse(item.data);
            return;
        }
    });
}
const add1 = () => {
    const data = {
        id: null,
        level: 1,
        folder: null,
        name: null,
        icon: null,
        sort: 0,
    }
    formRef.value = data;
    PAGE.idData = formRef.value;
}
const startAdd2 = () => {
    ElMessageBox.prompt('输入想要添加的页面等级（非负整数）', '添加（等级）页面', {
        confirmButtonText: '确认',
        cancelButtonText: '取消',
        inputPattern:
            /^\d+$/,
        inputErrorMessage: '无效数字（仅非负数）',
    })
        .then(({ value }) => {
            ElMessage.warning(`将添加等级为 ${value} 的页面`)
        })
}

const startEdit2 = () => {
    drawerEdit2.value = true;
}

const handleCOL = (data) => {
    console.log(data)
}
</script>

<template>
    <template v-if="status">
        <el-form label-position="top">
            <el-row :gutter="15">
                <!-- 菜单 -->
                <el-col :span="5">
                    <el-form-item>
                        <el-select v-model="PAGE.id" placeholder="页面" @change="changeID">
                            <template #footer>
                                <el-button :icon="Icons.Plus" @click="add1">
                                    添加
                                </el-button>

                                <el-popconfirm v-if="PAGE.id" title="是否删除当前选中项?">
                                    <template #reference>
                                        <el-button :icon="Icons.Delete">
                                            删除
                                        </el-button>
                                    </template>
                                </el-popconfirm>
                            </template>
                            <el-option v-for="item in DATA_MENU" :label="toLabel(item.folder, item.name)" :key="item.id"
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
                    </el-form-item>
                </el-col>
                <!-- 等级 -->
                <el-col :span="4">
                    <el-form-item>
                        <el-select v-model="PAGE.level" placeholder="等级" @change="changeLEVEL">
                            <template #footer v-if="PAGE.id != null">
                                <el-button :icon="Icons.Plus" @click="startAdd2">
                                    添加
                                </el-button>
                                <el-popconfirm v-if="PAGE.level" title="是否删除当前选中项?">
                                    <template #reference>
                                        <el-button :icon="Icons.Delete">
                                            删除
                                        </el-button>
                                    </template>
                                </el-popconfirm>
                            </template>
                            <el-option v-for="item in DATA_CONTENT" :label="item.level" :key="item.level"
                                :value="item.level" />
                        </el-select>
                    </el-form-item>
                </el-col>
                <el-col :span="3" v-if="PAGE.level">
                    <el-form-item>
                        <el-radio-group v-model="showSource">
                            <el-radio-button label="展示源码" :value="true" />
                            <el-radio-button label="隐藏源码" :value="false" />
                        </el-radio-group>
                    </el-form-item>
                </el-col>
                <el-col :span="3" v-if="PAGE.level">

                    <el-affix :offset="10">
                        <el-button :icon="Icons.Edit" @click="startEdit2">
                            编辑
                        </el-button>
                    </el-affix>
                </el-col>
            </el-row>
            <el-row :gutter="10" v-if="PAGE.idData">
                <el-col :span="2">
                    <el-form-item label="等级">
                        <el-input-number v-model="PAGE.idData.level" />
                    </el-form-item>
                </el-col>
                <el-col :span="3">
                    <el-form-item label="图标">
                        <el-select v-model="PAGE.idData.icon">
                            <el-option v-for="(item, key) in Icons" :key="key" :label="key" :value="key">
                                <template #default>
                                    <div class="icon">
                                        <component :is="item" class="image" />
                                        <span class="text">{{ key }}</span>
                                    </div>
                                </template>
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
                <el-col :span="3">
                    <el-form-item label="目录">
                        <el-input v-model="PAGE.idData.folder" />
                    </el-form-item>
                </el-col>
                <el-col :span="3">
                    <el-form-item label="名称">
                        <el-input v-model="PAGE.idData.name" />
                    </el-form-item>
                </el-col>
                <el-col :span="2">
                    <el-form-item label="排序">
                        <el-input-number v-model="PAGE.idData.sort" />
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row v-if="showSource">
                <el-col :span="20">
                    <el-form-item>
                        <el-input type="textarea" v-model="textareaValue" :autosize="{ minRows: 2, maxRows: 15 }"
                            :show-word-limit="true" />
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <div class="CONTENT">
            <h1>预览</h1>
            <div v-if="PAGE.levelData">
                <Content v-if="PAGE.levelData" :datas="PAGE.levelData" @clickCOL="handleCOL" />
            </div>
        </div>

    </template>
    <el-drawer modal-class="drawer" v-model="drawerEdit2" title="等级页面编辑" direction="ltr" append-to-body>

    </el-drawer>
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

.el-input-number {
    text-align: center;
}

.icon {
    width: 100%;
    height: 100%;
    display: inline-flex;
    align-items: center;
    column-gap: 10px;
}

.icon .image {
    max-height: 100%;
}

:deep(.drawer) {
    --el-drawer-bg-color: var(--color-background-mute);
}

.CONTENT {
    border-top: 1px solid var(--color-text-1);
}

.CONTENT h1 {
    margin-bottom: 10px
}

.CONTENT :deep(.el-col:hover) {
    outline: 1px solid var(--color-text-1);
}
</style>