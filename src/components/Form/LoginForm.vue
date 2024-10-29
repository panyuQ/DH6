<template name="ads">
    <el-form class="login" :model="formRef" :rules="loginRules" ref="loginFormRef">
        <el-form-item prop="username">
            <el-input type="text" v-model="formRef.username" placeholder="账号" size="large" name="username" />
        </el-form-item>
        <el-form-item prop="password">
            <el-input type="password" v-model="formRef.password" placeholder="密码" size="large" name="password" />
        </el-form-item>
        <el-form-item>
            <el-button class="button" size="large" @click="handleLogin">登录</el-button>
        </el-form-item>
    </el-form>
</template>

<script setup>
import { ref } from 'vue';
import { ElMessage } from 'element-plus';
import { useRouter } from 'vue-router';
import { login } from '@/api';


const DEBUG = import.meta.env.DEV;
const props = defineProps({
    gogogo: {
        type: Function,
        required: true
    },
    target: {
        type: String,
        default: 'home'
    }
});

const formRef = ref({});
const loginFormRef = ref(null);
const router = useRouter();

const loginRules = {
    username: [
        { required: true, message: '请输入账号', trigger: 'blur' }
    ],
    password: [
        { required: true, message: '请输入密码', trigger: 'blur' }
    ]
};

const handleLogin = async () => {
    try {
        await loginFormRef.value.validate();
        if (await props.gogogo(login, formRef.value)) {
            router.push({ name: props.target });
        }
    } catch (error) {
        ElMessage.error('登录失败');
        if (DEBUG)
            console.error('登录失败: ', error);
    }
};
</script>