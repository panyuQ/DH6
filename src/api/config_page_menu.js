// @/api/users.js
import { fetchData } from './index.js';

export const findAllByNotGreaterLevel = async () => {
    return await fetchData(`/find/config_page_menu`);
};
export const findAll = async () => {
    return await fetchData(`/find/config_page_menu/all`);
};