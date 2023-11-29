
import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { pause } from '../utils/util';
import { Rating } from '../interfaces/Rating';


const RatingApi = createApi({
    reducerPath: "rating",
    tagTypes: ['Rating'],
    baseQuery: fetchBaseQuery({
        baseUrl: "http://be-vcdtt.datn-vcdtt.test/api",
        fetchFn: async (...arg) => {
            await pause(1000)
            return await fetch(...arg);
        }
    }),
    endpoints: (builder) => ({
        getRatings: builder.query<Rating, void>({
            query: () => `/rating`,
            providesTags: ['Rating']
        }),
        getRatingById: builder.query<Rating, number | string>({
            query: (id) => `/rating/${id}`,
            providesTags: ['Rating']
        }),
        removeRating: builder.mutation<void, number | string>({
            query: (id) => ({
                url: `/ratings/${id}`,
                method: "DELETE",
            }),
            invalidatesTags: ['Rating']
        }),
        addRating: builder.mutation<Rating, Rating>({
            query: (Rating) => ({
                url: `/rating-store`,
                method: "POST",
                body: Rating
            }),
            invalidatesTags: ['Rating']
        }),
        updateRating: builder.mutation<Rating, Rating>({
            query: (Rating) => ({
                url: `/rating-edit/${Rating.id}`,
                method: "PUT",
                body: Rating
            }),
            invalidatesTags: ['Rating']
        })
    })
});

export const {
    useGetRatingsQuery,
    useGetRatingByIdQuery,
    useAddRatingMutation,
    useRemoveRatingMutation,
    useUpdateRatingMutation
 } = RatingApi;
export const ratingReducer = RatingApi.reducer;
export default RatingApi;