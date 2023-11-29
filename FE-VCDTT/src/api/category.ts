
import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { pause } from '../utils/util';
import { Category } from '../interfaces/Category';


const CategoryApi = createApi({
    reducerPath: "category",
    tagTypes: ['Category'],
    baseQuery: fetchBaseQuery({
        baseUrl: "http://be-vcdtt.datn-vcdtt.test/api",
        fetchFn: async (...arg) => {
            await pause(1000)
            return await fetch(...arg);
        }
    }),
    endpoints: (builder) => ({
        getCategories: builder.query<Category, void>({
            query: () => `/category`,
            providesTags: ['Category']
        }),
        getCategoryById: builder.query<Category, number | string>({
            query: (id) => `/category-show/${id}`,
            providesTags: ['Category']
        }),
        removeCategory: builder.mutation<void, number | string>({
            query: (id) => ({
                url: `/categorys/${id}`,
                method: "DELETE",
            }),
            invalidatesTags: ['Category']
        }),
        addCategory: builder.mutation<Category, Category>({
            query: (Category) => ({
                url: `/categorys`,
                method: "POST",
                body: Category
            }),
            invalidatesTags: ['Category']
        }),
        updateCategory: builder.mutation<Category, Category>({
            query: (Category) => ({
                url: `/categorys/${Category.id}`,
                method: "PUT",
                body: Category
            }),
            invalidatesTags: ['Category']
        })
    })
});

export const {
    useGetCategoriesQuery,
    useGetCategoryByIdQuery,
    useAddCategoryMutation,
    useRemoveCategoryMutation,
    useUpdateCategoryMutation
 } = CategoryApi;
export const categoryReducer = CategoryApi.reducer;
export default CategoryApi;