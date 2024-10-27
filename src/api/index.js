// @/api/index.js
import axios from 'axios';
import { ElMessage } from 'element-plus'
import { ref } from 'vue';

const API_URL = 'http://localhost:8081'; // 替换为你的 API 端点

export const datas = ref({});

const get = async (url) => {
    try {
        const response = await axios.get(url);
        const { statusCode, data } = response.data;
        if (statusCode !== 200) {
            throw new Error(data);
        }
        return data;
    } catch (error) {
        throw error;
    }
};

const fetchData = async (key, url, data = null) => {
    try {
        if (data) {
        } else {
            datas.value[key] = await get(url);
        }
    } catch (error) {
        console.error(`方法 ${key} 运行时出错:`, error);
        ElMessage.error(`方法 ${key} 运行时出错: ${error.message}`);
    }
};

export const findAll_users = async () => {
    await fetchData('findAll_users', `${API_URL}/find/users`);
};

export const findOneById_users = async (id) => {
    await fetchData('findOneById_users', `${API_URL}/find/users/${id}`);
};