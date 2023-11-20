
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
        getLogo: builder.query<Setting[], void>({
            query: () => `/keyvalue/logo`,
            providesTags: ['Keyvalue']
        }),
        getBankName: builder.query<Setting[], void>({
            query: () => `/keyvalue/bankName`,
            providesTags: ['Keyvalue']
        }),
      
    })
});

export const {
    useGetLogoQuery,
    useGetBankNameQuery
 } = SettingApi;
export const settingReducer = SettingApi.reducer;
export default SettingApi;