<script setup>
import { ref, onMounted } from 'vue';
import { isLogin } from '@/api';
const loginStatus = ref(null);
onMounted(async () => {
    loginStatus.value = await isLogin();
});
</script>

<template>
    <div>
        <p>{{ loginStatus }}</p>
    </div>
</template>
