<script setup>

import { ref, onMounted, inject } from 'vue';
import { loginStatus } from '@/api';
import { findAll } from '@/api/users';

const status = ref(null);

onMounted(async () => {
    status.value = await loginStatus();
    if (status.value != null && !status.value.result)
        window.location.href = '/login'
});

const toggle = async () => {
    
}
</script>

<template>
    <div>
        <p>{{ status }}</p>
        <el-button @click="toggle"> 点击切换</el-button>
    </div>
</template>
