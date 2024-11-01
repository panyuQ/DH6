// @/api/users.js
import { fetchData } from './index.js';

export const findOneByIdAndNotGreaterLevel = async (id) => {
    return await fetchData(`/find/config_page_content/${id}`);
};