import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";
import { pause } from "../utils/util";
import { Faq } from "../interfaces/Faq";

const FaqApi = createApi({
  reducerPath: "faq",
  tagTypes: ["Faq"],
  baseQuery: fetchBaseQuery({
    baseUrl: "http://be-vcdtt.datn-vcdtt.test/api",
    fetchFn: async (...arg) => {
      await pause(1000);
      return await fetch(...arg);
    },
  }),
  endpoints: (builder) => ({
    getFaqs: builder.query<Faq, void>({
      query: () => `/faq`,
      providesTags: ["Faq"],
    }),
    getFaqById: builder.query<Faq, number | string>({
      query: (id) => `/faq-show/${id}`,
      providesTags: ["Faq"],
    }),
    removeFaq: builder.mutation<void, number | string>({
      query: (id) => ({
        url: `/faqs/${id}`,
        method: "DELETE",
      }),
      invalidatesTags: ["Faq"],
    }),
    addFaq: builder.mutation<Faq, Faq>({
      query: (faq) => ({
        url: `/faqs`,
        method: "POST",
        body: faq,
      }),
      invalidatesTags: ["Faq"],
    }),
    updateFaq: builder.mutation<Faq, Faq>({
      query: (faq) => ({
        url: `/faqs/${faq.id}`,
        method: "PUT",
        body: faq,
      }),
      invalidatesTags: ["Faq"],
    }),
  }),
});

export const {
  useGetFaqsQuery,
  useGetFaqByIdQuery,
  useAddFaqMutation,
  useRemoveFaqMutation,
  useUpdateFaqMutation,
} = FaqApi;
export const faqReducer = FaqApi.reducer;
export default FaqApi;
