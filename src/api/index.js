// @/api/index.js
import axios from 'axios';
import { ElMessage } from 'element-plus';
import CryptoJS from 'crypto-js';

axios.defaults.withCredentials = true;

const API_URL = 'http://localhost:8081'; // 替换为你的 API 端点

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

const post = async (url, data) => {
    try {
        const response = await axios.post(url, data);
        const { statusCode, data: responseData } = response.data;
        if (statusCode !== 200) {
            throw new Error(responseData);
        }
        return responseData;
    } catch (error) {
        throw error;
    }
};

const fetchData = async (key, url, data = null) => {
    let res = null;
    try {
        if (data) {
            res = await post(url, data);
        } else {
            res = await get(url);
        }
    } catch (error) {
        console.error(`API方法 ${key} 运行时出错:`, error);
        ElMessage.error(`API 请求出错: ${error.message}`);
    }
    console.log(`API 返回数据:`, res);
    return res;
};

// MD5 加密函数
function md5(text) {
    return CryptoJS.MD5(text).toString(CryptoJS.enc.Hex);
}

export const login = async (data) => {
    if (data.password) {
        data.password = md5(data.password);
    }
    return await fetchData('login', `${API_URL}/login`, data);
};

export const signin = async (data) => {
    return await fetchData('signin', `${API_URL}/signin`, data);
};

/**
 * 异步获取所有用户信息
 * 
 * @returns {Promise<void>} 无返回值，但异步操作会获取并处理用户数据
 */
export const findAll_users = async () => {
    return await fetchData('findAll_users', `${API_URL}/find/users`);
};

/**
 * 根据用户ID异步获取用户信息
 * 
 * @param {string} id   用户的唯一标识符（ID）
 */
export const findOneById_users = async (id) => {
    return await fetchData('findOneById_users', `${API_URL}/find/users/${id}`);
};

/**
 * 根据ID查找用户集合中的特定字段
 * 
 * @param {string} id       用户的唯一标识符（ID）
 * @param {string} field    需要查找的字段名称
 */
export const findFieldById_users = async (id, field) => {
    return await fetchData('findFieldById_users', `${API_URL}/find/users/${field}/${id}`);
};

/**
 * 对比用户信息的特定字段值
 * 
 * @param {string} id           用户的唯一标识符（ID）
 * @param {string} field        用户信息的字段名，用于指定需要对比的属性
 * @param {any} fieldValue      需要对比的字段值，用于与数据库中的值进行匹配
 * @returns {Promise<boolean>}  返回一个Promise，解析为对比结果true表示给定的字段值与数据库中的值匹配，false表示不匹配
 */
export const contrastField_users = async (id, field, fieldValue) => {
    return await fetchData('contrastField_users', `${API_URL}/contrast/users/${field}/${id}/${fieldValue}`);
};