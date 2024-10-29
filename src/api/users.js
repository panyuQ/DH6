// @/api/users.js
import { fetchData } from './index.js';

export const findAll = async () => {
    return await fetchData('findAll_users', `/find/users`);
};
export const findOneById = async (id) => {
    return await fetchData(`/find/users/${id}`);
};

export const findFieldById = async (id, field) => {
    return await fetchData('findFieldById_users', `/find/users/${field}/${id}`);
};

export const contrastField = async (id, field, fieldValue) => {
    return await fetchData('contrastField_users', `/contrast/users/${field}/${id}/${fieldValue}`);
};