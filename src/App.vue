<script setup>
import { onBeforeMount, onMounted, ref } from 'vue';
import { RouterView } from 'vue-router';
import { ElLoading } from 'element-plus'

const loading = ref(null);
onBeforeMount(() => {
  loading.value = ElLoading.service({
    lock: true,
    text: 'Loading',
    background: 'rgba(0, 0, 0, 0.7)',
  })
});
onMounted(async () => {
  loading.value.close();
});
</script>

<template>
  <RouterView />
</template>

<style scoped></style>