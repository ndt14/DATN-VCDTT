
import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { pause } from '../utils/util';
import { Privacy } from '../interfaces/Privacy';



const PrivacyApi = createApi({
    reducerPath: "page",
    tagTypes: ['Page'],
    baseQuery: fetchBaseQuery({
        baseUrl: "http://be-vcdtt.datn-vcdtt.test/api/",
        fetchFn: async (...arg) => {
            await pause(1000)
            return await fetch(...arg);
        }
    }),
    endpoints: (builder) => ({
        getPrivacy: builder.query<Privacy[], void>({
            query: () => `/page`,
            providesTags: ['Page']
        }),
       
    })
});

export const {
   useGetPrivacyQuery
 } = PrivacyApi;
export const privacyReducer = PrivacyApi.reducer;
export default PrivacyApi;