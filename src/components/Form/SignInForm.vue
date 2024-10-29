<template>
  <el-form class="signin" :model="formRef" :rules="signinRules" ref="signinFormRef">
    <el-form-item prop="id">
      <el-input type="text" v-model="formRef.id" placeholder="ID（学号）" size="large" name="id" />
    </el-form-item>
    <el-form-item prop="name">
      <el-input type="text" v-model="formRef.name" placeholder="名称" size="large" name="name" />
    </el-form-item>
    <el-form-item>
      <el-button class="button" size="large" @click="handleSignin">签到</el-button>
    </el-form-item>
  </el-form>
</template>

<script setup>
import { ref } from 'vue';
import { ElMessage } from 'element-plus';
import { signin } from '@/api';

const DEBUG = import.meta.env.DEV;
const props = defineProps({
  gogogo: {
    type: Function,
    required: true
  }
})

const formRef = ref({});
const signinFormRef = ref(null);

const signinRules = {
  id: [
    {
      validator: (rule, value, callback) => {
        if (!formRef.value.id && !formRef.value.name) {
          callback(new Error('请输入 ID（学号）'));
        } else {
          callback();
        }
      }, trigger: 'blur'
    }
  ],
  name: [
    {
      validator: (rule, value, callback) => {
        if (!formRef.value.id && !formRef.value.name) {
          callback(new Error('请输入 名称'));
        } else {
          callback();
        }
      }, trigger: 'blur'
    }
  ]
};
const handleSignin = async () => {
  try {
    await signinFormRef.value.validate();
    await props.gogogo(signin, formRef.value);
  } catch (error) {
    ElMessage.error('签到失败');
    if (DEBUG)
      console.error('签到失败: ', error);
  }
};
</script>