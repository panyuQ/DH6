<script setup>
import { ref } from 'vue'
import { ElMessage } from 'element-plus'
import { findAll_users, datas } from '@/api';
findAll_users();

const formRef = ref({});
const login = async () => {
    ElMessage('login: ' + formRef.value);
    formRef.value = {};
}

const signin = async () => {
    console.log('signin:', formRef.value);
    formRef.value = {};
}

</script>

<template>
    <el-card class="container" body-class="form-box">
        <p>{{ datas() }}</p>
        <el-form class="login">
            <el-form-item>
                <el-input type="text" v-model="formRef.username" placeholder="账号" size="large" name="username" />
            </el-form-item>
            <el-form-item>
                <el-input type="password" v-model="formRef.password" placeholder="密码" size="large" name="password" />
            </el-form-item>
            <el-form-item>
                <el-button class="button" size="large" @click="login">登录</el-button>
            </el-form-item>
        </el-form>
        <el-form class="signin">
            <el-form-item>
                <el-input type="text" v-model="formRef.id" placeholder="ID / 学号" size="large" name="id" />
            </el-form-item>
            <el-form-item>
                <el-input type="text" v-model="formRef.name" placeholder="名称" size="large" name="name" />
            </el-form-item>
            <el-form-item>
                <el-button class="button" size="large" @click="signin">签到</el-button>
            </el-form-item>
        </el-form>
    </el-card>
</template>

<style scoped>
.container {
    position: fixed;
    width: 40%;
    max-width: 800px;
    height: 40%;
    min-height: 245px;
    max-height: 320px;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    --padding: 10px;
    --margin: 20px;
}

:deep(.form-box) {
    position: relative;
    width: 100%;
    height: 100%;

    .el-form {
        position: absolute;
        top: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0 var(--margin);
        transition: transform 1s;

        .el-form-item:last-child {
            margin-bottom: 0;
        }

        &.login {
            left: 0;
            width: 50%;
            height: 100%;
            padding-right: var(--padding);
        }

        &.signin {
            left: 50%;
            width: 50%;
            height: 100%;
            padding-left: var(--padding);
        }
    }

    .el-form-item__content {
        justify-content: center;
    }

    .button {
        border-radius: 20px;
        padding: 1em 3.5em;
        color: var(--white);
        background-color: var(--blue);
        background-image: linear-gradient(90deg, var(--blue) 0%, var(--lightblue) 74%);
    }

}

.container:hover .login {
    transform: translateX(100%);
    padding-left: var(--padding);
    padding-right: var(--margin);
}

.container:hover .signin {
    transform: translateX(-100%);
    padding-left: var(--margin);
    padding-right: var(--padding);
}
</style>
