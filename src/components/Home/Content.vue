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
    if (newPageIndex != null)
        DATA.value = await findOneByIdAndNotGreaterLevel(newPageIndex);
});
</script>

<template>
    <p>{{ DATA }}</p>
</template>