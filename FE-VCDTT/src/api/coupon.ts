import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { Coupon } from '../interfaces/Coupon';

const CouponApi = createApi({
    reducerPath: 'check-coupon',
    
    baseQuery: fetchBaseQuery({
        baseUrl: "https://admin.vcdtt.online/api",
    }),
    endpoints: (builder) => ({
        checkCoupon: builder.mutation<{ message: string, status:number, coupon: Coupon }, Coupon>({
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
