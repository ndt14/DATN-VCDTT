import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { AuthSignin, AuthSignup } from '../interfaces/Auth';
import { User } from '../interfaces/User';

const AuthApi = createApi({
    reducerPath: 'auth',
    baseQuery: fetchBaseQuery({
        baseUrl: "http://be-vcdtt.datn-vcdtt.test/api",
    }),
    endpoints: (builder) => ({
        register: builder.mutation<{ message: string, token: string, user: User }, AuthSignup>({
            query: (credentials) => ({
                url: '/register',
                method: 'POST',
                body: credentials,
            }),
        }),
        login: builder.mutation<{ message: string, token: string, user: User }, AuthSignin>({
            query: (credentials) => ({
                url: '/login',
                method: 'POST',
                body: credentials,
            }),
        }),
        getLoginGoogle: builder.query<{ name: string, token: string, email: string,url:string }, void>({
            query: () => `/auth/google`,
            
        }),
        resetPassword: builder.mutation<{ message: string }, { email: string }>({
            query: (email) => ({
                url: '/reset-password', // Update the URL accordingly
                method: 'POST',
                body: { email },
            }),
        }),
        resetPasswordWithToken: builder.mutation<{ message: string }, { token: string|undefined, newPassword: string }>({
            query: ({ token, newPassword }) => ({
                url: `/reset-password/${token}`, // Use the correct URL based on your backend
                method: 'PUT', // Use the correct HTTP method for resetting the password
                body: { password: newPassword }, // Update the request body structure as needed
            }),
        }),
    }),
});

export const { useLoginMutation,useRegisterMutation,useResetPasswordMutation,useResetPasswordWithTokenMutation,useGetLoginGoogleQuery} = AuthApi;

export const authReducer = AuthApi.reducer;
export default AuthApi;
