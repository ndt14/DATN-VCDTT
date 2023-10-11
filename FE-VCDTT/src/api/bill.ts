
import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { pause } from '../utils/util';
import { Bill } from '../interfaces/Bill';


const BillApi = createApi({
    reducerPath: "bill",
    tagTypes: ['Bill'],
    baseQuery: fetchBaseQuery({
        baseUrl: "http://be-vcdtt.datn-vcdtt.test/api/",
        fetchFn: async (...arg) => {
            await pause(1000)
            return await fetch(...arg);
        }
    }),
    endpoints: (builder) => ({
        getBills: builder.query<Bill[], void>({
            query: () => `/bill`,
            providesTags: ['Bill']
        }),
        getBillById: builder.query<Bill, number | string>({
            query: (id) => `/bill-show/${id}`,
            providesTags: ['Bill']
        }),
        removeBill: builder.mutation<void, number | string>({
            query: (id) => ({
                url: `/bills/${id}`,
                method: "DELETE",
            }),
            invalidatesTags: ['Bill']
        }),
        addBill: builder.mutation<Bill, Bill>({
            query: (bill) => ({
                url: `/purchase-history-store`,
                method: "POST",
                body: bill
            }),
            invalidatesTags: ['Bill']
        }),
        updateBill: builder.mutation<Bill, Bill>({
            query: (bill) => ({
                url: `/bills/${bill.id}`,
                method: "PUT",
                body: bill
            }),
            invalidatesTags: ['Bill']
        })
    })
});

export const {
    useGetBillsQuery,
    useGetBillByIdQuery,
    useAddBillMutation,
    useRemoveBillMutation,
    useUpdateBillMutation
    
 } = BillApi;
export const billReducer = BillApi.reducer;
export default BillApi;