import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';


interface AuthSignup {
    email: string;
    password: string;
    name: string;
    confirmPassword: string
}
interface AuthSignin {
    email: string;
    password: string;
}
const AuthApi = createApi({
    reducerPath: 'auth',
    baseQuery: fetchBaseQuery({
        baseUrl: "http://be-vcdtt.datn-vcdtt.test/api/",
    }),
    endpoints: (builder) => ({
        register: builder.mutation<{ message: string, accessToken: string, user: {} }, AuthSignup>({
            query: (credentials) => ({
                url: '/register',
                method: 'POST',
                body: credentials,
            }),
        }),
        login: builder.mutation<{ message: string, accessToken: string, user: {} }, AuthSignin>({
            query: (credentials) => ({
                url: '/login',
                method: 'POST',
                body: credentials,
            }),
        }),
    }),
});

export const { useLoginMutation,useRegisterMutation } = AuthApi;

export const authReducer = AuthApi.reducer;
export default AuthApi;
