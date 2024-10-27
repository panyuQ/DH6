// @/api/index.js
import axios from 'axios';
import { ElMessage } from 'element-plus'
import { ref } from 'vue';

const API_URL = 'http://localhost:8081'; // 替换为你的 API 端点

// 用于存储从后端获取的数据
const DATAS = ref({});


/**
 * 根据给定的键从 DATAS 中获取值，并在获取后删除该键值对
 *
 * @param {string} key - 要获取的键
 * @param {boolean} [del=false] - 是否删除该键值对
 * @returns {*} - 返回 DATAS 中对应键的值，如果键不存在则返回 undefined
 */
export const datas = (key = null, del = false) => {
    
    if (key === null) key = Object.keys(DATAS.value)[0];

    let data = DATAS.value[key];
    // 删除该键值对
    if (del && key in DATAS.value) {
        delete DATAS.value[key];
    }

    // 返回获取到的值
    return data;
}
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
            DATAS.value[key] = await get(url);
        }
    } catch (error) {
        console.error(`方法 ${key} 运行时出错:`, error);
        ElMessage.error(`方法 ${key} 运行时出错: ${error.message}`);
    }
};

/**
 * 异步获取所有用户信息
 * 
 * @returns {Promise<void>} 无返回值，但异步操作会获取并处理用户数据
 */
export const findAll_users = async () => {
    await fetchData('findAll_users', `${API_URL}/find/users`);
};

/**
 * 根据用户ID异步获取用户信息
 * 
 * @param {string} id   用户的唯一标识符（ID）
 */
export const findOneById_users = async (id) => {
    await fetchData('findOneById_users', `${API_URL}/find/users/${id}`);
};

/**
 * 根据ID查找用户集合中的特定字段
 * 
 * @param {string} id       用户的唯一标识符（ID）
 * @param {string} feild    需要查找的字段名称
 */
export const findFeildById_users = async (id, feild) => {
    await fetchData('findFeildById_users', `${API_URL}/find/users/${feild}/${id}`);
};

/**
 * 对比用户信息的特定字段值
 * 
 * @param {string} id           用户的唯一标识符（ID）
 * @param {string} feild        用户信息的字段名，用于指定需要对比的属性
 * @param {any} feildValue      需要对比的字段值，用于与数据库中的值进行匹配
 * @returns {Promise<boolean>}  返回一个Promise，解析为对比结果true表示给定的字段值与数据库中的值匹配，false表示不匹配
 */
export const contrastFeild_users = async (id, feild, feildValue) => {
    await fetchData('contrastFeild_users', `${API_URL}/contrast/users/${feild}/${id}/${feildValue}`);
};