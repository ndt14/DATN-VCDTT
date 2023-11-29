
import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { pause } from '../utils/util';
import { User } from '../interfaces/User';


const UserApi = createApi({
    reducerPath: "user",
    tagTypes: ['User'],
    baseQuery: fetchBaseQuery({
        baseUrl: "https://admin.vcdtt.online/api",
        fetchFn: async (...arg) => {
            await pause(1000)
            return await fetch(...arg);
        }
    }),
    endpoints: (builder) => ({
        
        getUserById: builder.query<User, number | string>({
            query: (id) => `/user-show/${id}`,
            providesTags: ['User']
        }),
        getTourFavoriteById: builder.query<User, number | string>({
            query: (id) => `/wish-list/${id}`,
            providesTags: ['User']
        }),
        
        updateUser: builder.mutation<User, User>({
            query: (user) => ({
                url: `/user-edit/${user.id}`,
                method: "PUT",
                body: user
            }),
            invalidatesTags: ['User']
        }),
        updatePassword: builder.mutation<User, User>({
            query: (user) => ({
                url: `/change-password/${user.id}`,
                method: "PUT",
                body: user
            }),
            invalidatesTags: ['User']
        })
    })
});

export const {
    useGetUserByIdQuery,useUpdateUserMutation, useUpdatePasswordMutation, useGetTourFavoriteByIdQuery
    
 } = UserApi;
export const userReducer = UserApi.reducer;
export default UserApi;