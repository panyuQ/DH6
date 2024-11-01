<script setup>
import { ref, watch, toRef } from 'vue';
import { findOneByIdAndNotGreaterLevel } from '@/api/config_page_content';

const props = defineProps({
    pageIndex: {
        type: Number,
        default: null
    }
});

const DATA = ref(null);

// 使用 toRef 将 props.pageIndex 转换为响应式引用
const pageIndexRef = toRef(props, 'pageIndex');

watch(pageIndexRef, async (newPageIndex) => {
    if (newPageIndex != null) {
        const data = await findOneByIdAndNotGreaterLevel(newPageIndex);
        if (data.result) {
            DATA.value = JSON.parse(data.content.data);
        } else{
            DATA.value = null;
        }
    }
});
</script>

<template>
    <p>{{ DATA }}</p>
</template>