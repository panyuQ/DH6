<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
const route = useRoute();
onMounted(() => {
    document.body.style.background = route.meta?.background1;
})
const formRef = ref({});
const isActive = ref(false);
const login = async () => {
    formRef.value = {};
};

const signin = async () => {
    formRef.value = {};
};

const toggle = () => {
    isActive.value = !isActive.value;
}

</script>

<template>
    <el-card class="container" body-class="form-box" :class="{ 'active': isActive }">
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

        <div class="overlay-container">
            <div class="overlay" :style="{ background: route.meta?.background2 }">
                <div class="overlay-panel overlay-left">
                    <el-button class="button" size="large" @click="toggle">登录</el-button>
                </div>
                <div class="overlay-panel overlay-right">
                    <el-button class="button" size="large" @click="toggle">签到</el-button>
                </div>
            </div>
        </div>
    </el-card>
</template>

<style scoped>
.container {
    position: fixed;
    width: 40%;
    max-width: 758px;
    height: 40%;
    min-height: 245px;
    max-height: 320px;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    --padding: 10px;
    --margin: 20px;
}

.overlay-container {
    position: absolute;
    width: 50%;
    height: 100%;
    top: 0;
    left: 0;
    overflow: hidden;
    transition: transform 0.6s ease-in-out;
    z-index: 10;
}

.overlay-container .overlay {
    background: center/cover no-repeat fixed;
    background-color: var(--lightblue);
    position: relative;
    width: 200%;
    height: 100%;
    left: 0;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.overlay-container .overlay-panel {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    position: absolute;
    width: 50%;
    height: 100%;
    top: 0;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.overlay-container .overlay-left {
    right: 50%;
    transform: translateX(0);
}

.overlay-container .overlay-right {
    right: 0;
    transform: translateX(20%);
}

.container.active .overlay-container {
    transform: translateX(100%);
}

.container.active .overlay {
    transform: translateX(-50%);
}

.container.active .overlay-left {
    transform: translateX(-20%);
}

.container.active .overlay-right {
    transform: translateX(0);
}

:deep(.form-box) {
    position: relative;
    width: 100%;
    height: 100%;
}

:deep(.form-box .el-form) {
    position: absolute;
    top: 0;
    right: 0;
    width: 50%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0 var(--margin);
    transition: 0.6s ease-in-out;
}

:deep(.form-box .el-form .el-form-item:last-child) {
    margin-bottom: 0;
}

:deep(.form-box .el-form.login) {
    transform: translateX(0);
    animation: hide 0.6s forwards;
}

:deep(.form-box .el-form.signin) {
    transform: translateX(0);
    animation: show 0.6s forwards;
}

:deep(.form-box .el-form-item__content) {
    justify-content: center;
}

.button {
    border-radius: 20px;
    padding: 1em 3.5em;
    color: var(--white);
    background: var(--blue) linear-gradient(90deg, var(--blue) 0%, var(--lightblue) 74%);
}

.container.active .login {
    transform: translateX(-100%);
    animation: show 0.6s forwards;
}

.container.active .signin {
    transform: translateX(-100%);
    animation: hide 0.6s forwards;
}


@keyframes show {

    0%,
    49.99% {
        opacity: 0;
        z-index: 1;
    }

    50%,
    100% {
        opacity: 1;
        z-index: 2;
    }
}

@keyframes hide {

    0%,
    49.99% {
        opacity: 1;
        z-index: 2;
    }

    50%,
    100% {
        opacity: 0;
        z-index: 1;
    }
}
</style>