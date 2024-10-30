// @/api/users.js
import { fetchData } from './index.js';

export const findAllByNotGreaterLevel = async () => {
    return await fetchData(`/find/config_page_menu`);
};