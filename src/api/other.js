// @/api/other.js
import { fetchData } from './index.js';

export const findBase = async () => {
    return await fetchData(`/find/other/base`);
};