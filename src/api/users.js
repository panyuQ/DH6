// @/api/users.js
import { fetchData } from './index.js';

export const findAll = async () => {
    return await fetchData(`/find/users`);
};
export const findOneById = async (id) => {
    return await fetchData(`/find/users/${id}`);
};

export const findFieldById = async (id, field) => {
    return await fetchData(`/find/users/${field}/${id}`);
};

export const contrastField = async (id, field, fieldValue) => {
    return await fetchData(`/contrast/users/${field}/${id}/${fieldValue}`);
};