import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { Coupon } from '../interfaces/Coupon';

const CouponApi = createApi({
    reducerPath: 'check-coupon',
    
    baseQuery: fetchBaseQuery({
        baseUrl: "http://be-vcdtt.datn-vcdtt.test/api/",
    }),
    endpoints: (builder) => ({
        checkCoupon: builder.mutation<{ message: string, status:number, }, Coupon>({
            query: (coupon) => ({
                url: 'check-coupon',
                method: 'POST',
                body: coupon,
            }),
        }),
        getCouponByUser: builder.query<Coupon,number|string >({
            query: (user_id) => `/list-coupon/${user_id}`,
        })
    }),
});

export const { useCheckCouponMutation,useGetCouponByUserQuery } = CouponApi;

export const couponReducer = CouponApi.reducer;
export default CouponApi;
