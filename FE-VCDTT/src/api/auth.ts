import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { AuthSignin, AuthSignup } from '../interfaces/Auth';

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
        resetPassword: builder.mutation<{ message: string }, { email: string }>({
            query: (email) => ({
                url: '/reset-password', // Update the URL accordingly
                method: 'POST',
                body: { email },
            }),
        }),
        resetPasswordWithToken: builder.mutation<{ message: string }, { token: string, newPassword: string }>({
            query: ({ token, newPassword }) => ({
                url: `/reset-password/${token}`, // Use the correct URL based on your backend
                method: 'PUT', // Use the correct HTTP method for resetting the password
                body: { password: newPassword }, // Update the request body structure as needed
            }),
        }),
    }),
});

export const { useLoginMutation,useRegisterMutation,useResetPasswordMutation,useResetPasswordWithTokenMutation} = AuthApi;

export const authReducer = AuthApi.reducer;
export default AuthApi;
