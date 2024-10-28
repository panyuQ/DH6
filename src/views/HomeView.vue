<script setup>
import { ref, onMounted } from 'vue';
import { findAll_users, findOneById_users } from '@/api';
const users = ref(null);
const user = ref(null);
onMounted(async () => {
    users.value = await findAll_users();
    user.value = await findOneById_users(123);
});
</script>

<template>
    <div>
        <p v-for="user in users" :key="user.id">
            {{ user.name }}
        </p>
    </div>
    <div>
        <p>{{ user }}</p>
    </div>
</template>
