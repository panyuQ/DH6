// @/api/users.js
import { fetchData } from './index.js';

export const findOneByIdAndNotGreaterLevel = async (id) => {
    return await fetchData(`/find/config_page_content/${id}`);
};
export const findOneByIdAndLevel = async (id, level) => {
    return await fetchData(`/find/config_page_content/${id}/${level}`);
};

export const findAll = async() => {
    return await fetchData(`/find/config_page_content`);
}