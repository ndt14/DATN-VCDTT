
import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { pause } from '../utils/util';
import { Setting } from '../interfaces/Setting';



const SettingApi = createApi({
    reducerPath: "keyvalue",
    tagTypes: ['Keyvalue'],
    baseQuery: fetchBaseQuery({
        baseUrl: "http://be-vcdtt.datn-vcdtt.test/api/",
        fetchFn: async (...arg) => {
            await pause(1000)
            return await fetch(...arg);
        }
    }),
    endpoints: (builder) => ({
        getLogo: builder.query<Setting, void>({
            query: () => `/keyvalue/logo`,
            providesTags: ['Keyvalue']
        }),
        getBankName: builder.query<Setting, void>({
            query: () => `/keyvalue/bankName`,
            providesTags: ['Keyvalue']
        }),
        getBanner: builder.query<Setting, void>({
            query: () => `/keyvalue/banner`,
            providesTags: ['Keyvalue']
        }),
        getBankAccountName: builder.query<Setting, void>({
            query: () => `/keyvalue/bankAccountName`,
            providesTags: ['Keyvalue']
        }),
        getEmailWeb: builder.query<Setting, void>({
            query: () => `/keyvalue/email`,
            providesTags: ['Keyvalue']
        }),
        getFavicon: builder.query<Setting, void>({
            query: () => `/keyvalue/favicon`,
            providesTags: ['Keyvalue']
        }),
        getAddress: builder.query<Setting, void>({
            query: () => `/keyvalue/address`,
            providesTags: ['Keyvalue']
        }),
        getWebPhoneNumber1: builder.query<Setting, void>({
            query: () => `/keyvalue/webPhoneNumber1`,
            providesTags: ['Keyvalue']
        }),
        getWebTitle: builder.query<Setting, void>({
            query: () => `/keyvalue/webTitle`,
            providesTags: ['Keyvalue']
        }),
    })
});

export const {
    useGetLogoQuery,
    useGetBankNameQuery,
    useLazyGetBannerQuery,
    useGetBankAccountNameQuery,
    useGetAddressQuery,
    useGetEmailWebQuery,
    useGetBannerQuery,
    useGetFaviconQuery,
    useGetWebPhoneNumber1Query,
    useGetWebTitleQuery,

 } = SettingApi;
export const settingReducer = SettingApi.reducer;
export default SettingApi;