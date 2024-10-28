<script setup>
import { ref, onMounted } from 'vue';
import { loginStatus } from '@/api';
const status = ref(null);
onMounted(async () => {
    status.value = await loginStatus();
});
</script>

<template>
    <div>
        <p>{{ status }}</p>
    </div>
</template>
