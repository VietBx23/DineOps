import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:4000/api',
  timeout: 5000,
});

export const fetchUsers = () => api.get('/users');
export const createUser = (payload) => api.post('/users', payload);

export default api;
