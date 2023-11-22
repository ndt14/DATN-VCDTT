
import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { pause } from '../utils/util';
import { Favorite } from '../interfaces/Favorite';


const FavoriteApi = createApi({
    reducerPath: "favorite",
    tagTypes: ['Favorite'],
    baseQuery: fetchBaseQuery({
        baseUrl: "https://admin.vcdtt.online/api",
        fetchFn: async (...arg) => {
            await pause(1000)
            return await fetch(...arg);
        }
    }),
    endpoints: (builder) => ({
        updateFavorite: builder.mutation<Favorite, Favorite>({
            query: (favorite) => ({
                url: `/use-wish-list`,
                method: "POST",
                body: favorite
            }),
            invalidatesTags: ['Favorite']
        }),
    })
});

export const {
    useUpdateFavoriteMutation
    
 } = FavoriteApi;
export const favoriteReducer = FavoriteApi.reducer;
export default FavoriteApi;