// @/api/index.js
import axios from 'axios';
import CryptoJS from 'crypto-js';
const { ElMessage } = await import('element-plus');



const DEBUG = import.meta.env.DEV;

export const API_URL = import.meta.env.VITE_API_URL ?? 'http://localhost:8081';

axios.defaults.withCredentials = true;

const handleError = (error, request) => {
    const info = {};
    info.type = request ? '-->>' : '<<--';
    info.method = error.config.method.toUpperCase();
    info.url = error.config.url;
    info.error = {
        name: error.name,
        status: error.status,
    }
    if (!request) {
        info.error.type = error.response?.data?.error?.type ?? null;
        info.error.description = error.response?.data?.error?.description ?? null;
    } else {

    }

    ElMessage.error(`${info.error.name} ${info.error.status}`);

    if (DEBUG) {
        console.error(`${info.type}  ${info.method}  ${info.url}`);
        console.log(`错误代码：${info.error.status}`)
        console.log(`错误名称：${info.error.name}`)
        if (info.error.type) {
            console.log(`错误类型：${info.error.type}`);
            console.log(`错误描述：${info.error.description}`);
        }

    }
};

axios.interceptors.request.use(
    config => {
        if (DEBUG) {
            console.log(`-->>  ${config.method.toUpperCase()}\t${config.url}`, config.data ?? null);
        }
        return config;
    },
    error => {
        handleError(error, true);
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    response => {
        const responseData = response.data;
        if (DEBUG) {
            console.log(`<<--  ${response.config.url}`, responseData.data);
        }
        if (responseData.data?.message) {
            if (responseData.data?.result) {
                ElMessage.success(responseData.data.message);
            } else {
                ElMessage.warning(responseData.data.message);
            }
        }
        return responseData.data;
    },
    error => {
        handleError(error, false);
        return Promise.reject(error);
    }
);

const get = async (url) => {
    return await axios.get(url);
};

const post = async (url, data) => {
    return await axios.post(url, data);
};


export const fetchData = async (path, data = null) => {
    let url = `${API_URL}${path}`;
    return await (data ? post(url, data) : get(url)) ?? {};
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

export const isRoot = async () => {
    return await fetchData('/is/root');
};