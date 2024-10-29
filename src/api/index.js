// @/api/index.js
import axios from 'axios';
import { ElMessage } from 'element-plus';
import CryptoJS from 'crypto-js';

const DEBUG = import.meta.env.DEV;
export const API_URL = import.meta.env.VITE_API_URL ?? 'http://localhost:8081';

axios.defaults.withCredentials = true;

axios.interceptors.request.use(config => {
    if (DEBUG) {
        console.log(`发送 ${config.method.toUpperCase()} 请求: ${config.url}`, config.data ?? null);
    }
    return config;
}, error => {
    handleError(error, true);
    return Promise.reject(error);
});

axios.interceptors.response.use(response => {
    if (DEBUG) {
        console.log(`响应 ${response.config.method.toUpperCase()} 请求: ${response.config.url}`, response.data);
    }
    if (response.data.statusCode !== 200) {
        throw new Error(response.data.data);
    }
    return response.data.data;
}, error => {
    handleError(error, false);
    return Promise.reject(error);
});

const get = async (url) => {
    return await axios.get(url);
};

const post = async (url, data) => {
    return await axios.post(url, data);
};

const handleError = (error, request) => {
    let x = request ? '请求' : '响应';
    if (DEBUG) {
        console.error(`${error.config.method.toUpperCase()} ${x}出错: ${error.config.url} \n`, error);
    }
    ElMessage.error(`${x}错误: ${error.message}`);
};

export const fetchData = async (path, data = null) => {
    let res = null;
    try {
        let url = `${API_URL}${path}`;
        res = await (data ? post(url, data) : get(url));
    } catch (error) {
    }
    return res;
};

const encryptPassword = (password) => CryptoJS.MD5(password).toString(CryptoJS.enc.Hex);

export const login = async (data) => {
    if (data.password) {
        data.password = encryptPassword(data.password);
    }
    return await fetchData('/login', data);
};

export const loginStatus = async () => {
    return await fetchData('/login/status');
};

export const logout = async () => {
    return await fetchData('/logout');
};
export const signin = async (data) => {
    return await fetchData('/signin', data);
};