
import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { pause } from '../utils/util';
import { Tour } from '../interfaces/Tour';


const TourApi = createApi({
    reducerPath: "tour",
    tagTypes: ['Tour'],
    baseQuery: fetchBaseQuery({
        baseUrl: "http://be-vcdtt.datn-vcdtt.test/api/",
        fetchFn: async (...arg) => {
            await pause(1000)
            return await fetch(...arg);
        }
    }),
    endpoints: (builder) => ({
        getTours: builder.query<Tour[], void>({
            query: () => `/tour`,
            providesTags: ['Tour']
        }),
        getTourById: builder.query<Tour, number | string>({
            query: (id) => `/tour-show/${id}`,
            providesTags: ['Tour']
        }),
        removeTour: builder.mutation<void, number | string>({
            query: (id) => ({
                url: `/tours/${id}`,
                method: "DELETE",
            }),
            invalidatesTags: ['Tour']
        }),
        addTour: builder.mutation<Tour, Tour>({
            query: (tour) => ({
                url: `/tours`,
                method: "POST",
                body: tour
            }),
            invalidatesTags: ['Tour']
        }),
        updateTour: builder.mutation<Tour, Tour>({
            query: (tour) => ({
                url: `/tours/${tour.id}`,
                method: "PUT",
                body: tour
            }),
            invalidatesTags: ['Tour']
        })
    })
});

export const {
    useGetToursQuery,
    useGetTourByIdQuery,
    useAddTourMutation,
    useRemoveTourMutation,
    useUpdateTourMutation
 } = TourApi;
export const tourReducer = TourApi.reducer;
export default TourApi;