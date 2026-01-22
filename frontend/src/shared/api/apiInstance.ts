import axios, {
    type AxiosResponse,
    type InternalAxiosRequestConfig,
} from 'axios';

export interface ISingleResponse<T> {
    success: boolean;
    result: T;
}

export interface IMultipleResponse<T> {
    success: boolean;
    next: string | null;
    previous: string | null;
    count: number;
    results: T[];
}



const API_URL = import.meta.env.VITE_APP_API_URL

export const apiInstance = axios.create({
    baseURL: API_URL,
    headers: { 'Content-Type': 'application/json' },
    withCredentials: true,
});

apiInstance.interceptors.request.use(
    async (config: InternalAxiosRequestConfig) => {
        return config;
    },
    (err) => Promise.reject(err),
);

apiInstance.interceptors.response.use(
    (response: AxiosResponse) => response.data,
    async (error) => {
        const originalRequest = error.config;

        if (error.response?.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;

           
        }

        return Promise.reject(error);
    },
);
