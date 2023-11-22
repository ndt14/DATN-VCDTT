
import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import { pause } from '../utils/util';
import { Blog } from '../interfaces/Blog';


const BlogApi = createApi({
    reducerPath: "blog",
    tagTypes: ['Blog'],
    baseQuery: fetchBaseQuery({
        baseUrl: "http://be-vcdtt.datn-vcdtt.test/api/",
        fetchFn: async (...arg) => {
            await pause(1000)
            return await fetch(...arg);
        }
    }),
    endpoints: (builder) => ({
        getBlogs: builder.query<Blog, void>({
            query: () => `/blog`,
            providesTags: ['Blog']
        }),
        getBlogById: builder.query<Blog, number | string>({
            query: (id) => `/blog-show/${id}`,
            providesTags: ['Blog']
        }),
        removeBlog: builder.mutation<void, number | string>({
            query: (id) => ({
                url: `/blogs/${id}`,
                method: "DELETE",
            }),
            invalidatesTags: ['Blog']
        }),
        addBlog: builder.mutation<Blog, Blog>({
            query: (blog) => ({
                url: `/blogs`,
                method: "POST",
                body: blog
            }),
            invalidatesTags: ['Blog']
        }),
        updateBlog: builder.mutation<Blog, Blog>({
            query: (blog) => ({
                url: `/blogs/${blog.id}`,
                method: "PUT",
                body: blog
            }),
            invalidatesTags: ['Blog']
        })
    })
});

export const {
    useGetBlogsQuery,
    useGetBlogByIdQuery,
    useAddBlogMutation,
    useRemoveBlogMutation,
    useUpdateBlogMutation
    
 } = BlogApi;
export const blogReducer = BlogApi.reducer;
export default BlogApi;