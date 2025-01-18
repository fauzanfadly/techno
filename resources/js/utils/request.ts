import axios, { AxiosHeaders, AxiosResponse, Method, RawAxiosRequestHeaders } from "axios"
import { closeLoading, openLoading } from "./loading_dialog";
import { useUserStore } from "../store/user";
import { openSnackbar } from "./snackbar";

type MethodsHeaders = Partial<{ [Key in Method as Lowercase<Key>]: AxiosHeaders; } & {common: AxiosHeaders}>;
type MethodType = "GET" | "POST" | "PUT" | "PATCH" | "DELETE";
type HeaderType = (RawAxiosRequestHeaders & MethodsHeaders) | AxiosHeaders;
type Payload = { [key: string]: any } | undefined;
const _errorMessage: string = "Something gone wrong";
type RequestConfig = {
    method: MethodType,
    url: string,
    headers: HeaderType,
    data?: Payload,
    useAuth: boolean,
    useLoading: boolean,
    errorMessage?: string,
}

const _request = async ({
    method = "GET",
    url,
    headers = {},
    data = {},
    useAuth = true,
    useLoading = false,
    errorMessage = _errorMessage,
}: RequestConfig): Promise<AxiosResponse<any, any>> => {
    if (useLoading) {
        openLoading();
    }

    const userStore = useUserStore();
    let _response: AxiosResponse<any, any>;
    let success = false;
    await axios.request({
        method: method,
        url,
        headers: {
            ...headers,
            ...(useAuth ? {
                Authorization: `Bearer ${userStore.token}`,
            } : {}),
        },
        data: data,
    })
        .then((response: AxiosResponse<any, any>) => {
            success = true;
            _response = response;
        })
        .catch((error) => {
            _response = error.response;
            console.error(`Request error to "${url}": ${error.response.data}`);
            openSnackbar({
                message: _response.data.message || errorMessage,
                status: 'error'
            });
        })
        .finally(() => {
            closeLoading();
        });

    return new Promise((resolve, reject) => {
        if (success) {
            resolve(_response);
        } else {
            reject(_response);
        }
    });
}

const convertObjectToParams = (
    data: { [key: string]: any },
    method: MethodType,
    url: string,
): string[] => {
    if (!data) {
        return [];
    }

    const _params: string[] = [];
    if (`${typeof data}`.toUpperCase() !== 'OBJECT') {
        console.error(`failed initialize request ${method} "${url}", data must be object "{}"`);
        throw new Error(`failed initialize request ${method} "${url}", data must be object "{}"`);
    }

    Object.keys(data).map(item => {
        _params.push(`${item}=${data[item]}`);
    });

    return _params;
}


const get = async ({
    url,
    headers = {},
    data = {},
    useLoading = false,
    useAuth = true,
    errorMessage = _errorMessage,
}: RequestConfig) => {
    let _params: string[] = [];
    try {
        _params = convertObjectToParams(data, "GET", url);
    } catch (error) {
        return null;
    }

    return _request({
        method: "GET",
        url: `${url}${_params ? `?${_params.join('&')}` : ''}`,
        headers,
        useLoading,
        useAuth,
        errorMessage,
    });
}

const post = async ({
    url,
    headers = {},
    data = {},
    useLoading = false,
    useAuth = true,
    errorMessage = _errorMessage,
}: RequestConfig) => {
    return _request({
        method: "POST",
        url,
        headers,
        data,
        useLoading,
        useAuth,
        errorMessage,
    });
}

const put = async ({
    url,
    headers = {},
    data = {},
    useLoading = false,
    useAuth = true,
    errorMessage = _errorMessage,
}: RequestConfig) => {
    return _request({
        method: "PUT",
        url,
        headers,
        data,
        useLoading,
        useAuth,
        errorMessage,
    });
}

const patch = async ({
    url,
    headers = {},
    data = {},
    useLoading = false,
    useAuth = true,
    errorMessage = _errorMessage,
}: RequestConfig) => {
    return _request({
        method: "PATCH",
        url,
        headers,
        data,
        useLoading,
        useAuth,
        errorMessage,
    });
}

const del = async ({
    url,
    headers = {},
    data = {},
    useLoading = false,
    useAuth = true,
    errorMessage = _errorMessage,
}: RequestConfig) => {
    let _params: string[] = [];
    try {
        _params = convertObjectToParams(data, "DELETE", url);
    } catch (error) {
        return null;
    }

    return _request({
        method: "DELETE",
        url: `${url}?${_params.join('&')}`,
        headers,
        useLoading,
        useAuth,
        errorMessage,
    });
}


export const Request = {
    get,
    post,
    put,
    patch,
    del,
}
