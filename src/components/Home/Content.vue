<script setup>
import { ref, watch, toRef, onMounted } from 'vue';
import { findOneByIdAndNotGreaterLevel } from '@/api/config_page_content';
import { fetchData } from '@/api';
import ContentEdit from './ContentEdit.vue';

const props = defineProps({
    pageIndex: {
        type: Number,
        default: null
    },
    datas: {
        type: Object,
        default: null
    },
    stringDatas: {
        type: String,
        default: null
    }
});

// 使用 toRef 将 props.pageIndex 转换为响应式引用
const pageIndexRef = toRef(props, 'pageIndex');
const datasRef = toRef(props, 'datas');
const stringDatas = toRef(props, 'stringDatas');
const DATA = ref({});
const VALUE = ref({});
const EDIT = ref(false);


watch(pageIndexRef, async (newPageIndex) => {
    if (newPageIndex != null) {
        if (newPageIndex === 99) {
            EDIT.value = true;
            console.log(newPageIndex)
        } else {
            EDIT.value = false;
            const data = await findOneByIdAndNotGreaterLevel(newPageIndex);
            if (data.result) {
                DATA.value = JSON.parse(data.content.data);
            } else {
                DATA.value = null;
            }

        }
    }
}, { immediate: true });

watch(datasRef, async (newDatas) => {
    if (newDatas) {
        DATA.value = newDatas;
    }
}, { immediate: true })
watch(stringDatas, async (newStringDatas) => {
    if (newStringDatas) {
        const data = JSON.parse(newStringDatas);
        DATA.value = data;
    }
}, { immediate: true })

watch(DATA, async (newData) => {
    const api = newData?.api ?? []
    for (const [apiPath, map] of Object.entries(api)) {
        const responseData = await fetchData(apiPath);
        for (const [field, key] of Object.entries(map)) {
            VALUE.value[key] = responseData[field]
        }
    }
}, { immediate: true })


</script>

<template>
    <ContentEdit v-if="EDIT" />
    <el-form v-else :style="{
        // 大小相关样式
        width: DATA?.style?.width, // 宽度
        height: DATA?.style?.height, // 高度

        // 背景相关样式
        background: DATA?.style?.background, // 背景

        // 外边距相关样式
        marginTop: DATA?.style?.margin?.top,
        marginRight: DATA?.style?.margin?.right,
        marginBottom: DATA?.style?.margin?.bottom,
        marginLeft: DATA?.style?.margin?.left,

        // 内边距相关样式
        paddingTop: DATA?.style?.padding?.top,
        paddingRight: DATA?.style?.padding?.right,
        paddingBottom: DATA?.style?.padding?.bottom,
        paddingLeft: DATA?.style?.padding?.left,

        // 文本相关样式
        color: DATA?.style?.color, // 文字颜色
        '--el-font-size-base': DATA?.style?.fontSize, // 文字大小
        fontWeight: DATA?.style?.fontWeight, // 文字粗细
        fontFamily: DATA?.style?.fontFamily, // 文字字体
        fontStyle: DATA?.style?.fontStyle, // 文字风格
        lineHeight: DATA?.style?.lineHeight, // 文字行高
        letterSpacing: DATA?.style?.letterSpacing, // 文字间距
        wordSpacing: DATA?.style?.wordSpacing, // 单词间距 
        textDecoration: DATA?.style?.textDecoration, // 文字装饰
        textAlign: DATA?.style?.textAlign, // 文字对齐方式

        // 边框相关样式
        borderColor: DATA?.style?.borderColor, // 边框颜色
        borderWidth: DATA?.style?.borderWidth, // 边框宽度
        borderStyle: DATA?.style?.borderStyle, // 边框样式
        borderRadius: DATA?.style?.borderRadius, // 边框圆角

        // 阴影相关样式
        boxShadow: DATA?.style?.boxShadow, // 阴影
    }" :label-width="DATA?.label?.width" :label-position="DATA?.label?.position">

        <el-row v-if="DATA" v-for="ROW in DATA.ROWS" :gutter="ROW?.gutter" :justify="ROW?.justify" :align="ROW?.align"
            :tag="ROW?.tag">

            <el-col v-for="COL in ROW.COLS" :span="COL?.span" :offset="COL?.offset" :pull="COL?.pull" :push="COL?.push"
                :tag="COL?.tag">

                <el-form-item :label-width="COL?.label?.width" :label-position="COL?.label?.position">
                    <template #label v-if="COL?.label?.content">
                        <span :style="{ // 标签的样式
                            // 大小相关样式
                            width: '100%',
                            height: '100%',

                            // 背景相关样式
                            background: COL?.label?.style?.background, // 背景

                            // 文本相关样式
                            color: COL?.label?.style?.color, // 文字颜色
                            fontSize: COL?.label?.style?.fontSize, // 字体大小
                            fontWeight: COL?.label?.style?.fontWeight, // 字体粗细
                            fontFamily: COL?.style?.fontFamily, // 字体样式
                            fontStyle: COL?.style?.fontStyle, // 文本样式
                            lineHeight: COL?.label?.style?.lineHeight, // 行高
                            letterSpacing: COL?.label?.style?.letterSpacing, // 字符间距
                            wordSpacing: COL?.label?.style?.wordSpacing, // 单词间距
                            textDecoration: COL?.label?.style?.textDecoration, // 文本修饰
                            textAlign: COL?.label?.style?.textAlign, // 文本对齐方式

                            justifyContent: COL?.label?.style?.justifyContent, // 水平对齐方式
                            alignItems: COL?.label?.style?.alignItems, // 垂直对齐方式

                            // 边框相关样式
                            borderColor: COL?.label?.style?.borderColor, // 边框颜色
                            borderWidth: COL?.label?.style?.borderWidth, // 边框宽度
                            borderStyle: COL?.label?.style?.borderStyle, // 边框样式
                            borderRadius: COL?.label?.style?.borderRadius, // 边框圆角

                            boxShadow: COL?.label?.style?.boxShadow, // 阴影

                        }">{{ COL?.label?.content }}</span>

                    </template>
                    <component :is="COL.element" v-model="VALUE[COL?.value?.field]" :readonly="COL?.value?.readonly"
                        :size="COL?.size" :style="{
                            // 背景相关样式
                            background: COL?.style?.background, // 背景

                            // 文本相关样式
                            color: COL?.style?.color, // 字体颜色
                            fontSize: COL?.style?.fontSize, // 字体大小
                            fontWeight: COL?.style?.fontWeight, // 字体粗细
                            fontFamily: COL?.style?.fontFamily, // 字体样式
                            fontStyle: COL?.style?.fontStyle, // 字体风格
                            lineHeight: COL?.style?.lineHeight, // 行高
                            letterSpacing: COL?.style?.letterSpacing, // 字符间距
                            wordSpacing: COL?.style?.wordSpacing, // 单词间距
                            textDecoration: COL?.style?.textDecoration, // 文本装饰
                            textAlign: COL?.style?.textAlign, // 文本对齐方式

                            justifyContent: COL?.style?.justifyContent, // 水平对齐方式
                            alignItems: COL?.style?.alignItems, // 垂直对齐方式

                            // 边框相关样式
                            borderColor: COL?.style?.borderColor, // 边框颜色
                            borderWidth: COL?.style?.borderWidth, // 边框宽度
                            borderStyle: COL?.style?.borderStyle, // 边框样式
                            borderRadius: COL?.style?.borderRadius, // 边框圆角

                            // 阴影相关样式
                            boxShadow: COL?.style?.boxShadow, // 阴影

                        }">

                        {{ VALUE[COL?.text?.field] ?? COL?.text }}
                        <component v-for="item in VALUE[COL?.subElement?.field]" :is="COL?.subElement?.element"
                            :label="item.label" :value="item.value" />
                    </component>

                </el-form-item>

            </el-col>

        </el-row>

    </el-form>


</template>

<style scoped>
:deep(.el-form) {
    --el-font-size-base: var(--font-size-base);
}

:deep(.el-form-item__label) {
    color: var(--color-text-1);
}

:deep(.el-form-item input) {
    text-align: inherit;
}

:deep(.el-text) {
    --el-font-size-medium: 1.5rem;
    --el-font-size-extra-small: 0.75rem
}
</style>