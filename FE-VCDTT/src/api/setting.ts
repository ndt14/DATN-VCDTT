import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";
import { pause } from "../utils/util";
import { Setting } from "../interfaces/Setting";

const SettingApi = createApi({
  reducerPath: "keyvalue",
  tagTypes: ["Keyvalue"],
  baseQuery: fetchBaseQuery({
    baseUrl: "http://be-vcdtt.datn-vcdtt.test/api",
    fetchFn: async (...arg) => {
      await pause(1000);
      return await fetch(...arg);
    },
  }),
  endpoints: (builder) => ({
    getLogo: builder.query<Setting, void>({
      query: () => `/keyvalue/logo`,
      providesTags: ["Keyvalue"],
    }),
    getBankName: builder.query<Setting, void>({
      query: () => `/keyvalue/bankName`,
      providesTags: ["Keyvalue"],
    }),
    getBanner: builder.query<Setting, void>({
      query: () => `/banner`,
      providesTags: ["Keyvalue"],
    }),
    getSubBanner: builder.query<Setting, void>({
      query: () => `/keyvalue/subBanner`,
      providesTags: ["Keyvalue"],
    }),
    getBankAccountName: builder.query<Setting, void>({
      query: () => `/keyvalue/bankAccountName`,
      providesTags: ["Keyvalue"],
    }),
    getBankContent: builder.query<Setting, void>({
      query: () => `/keyvalue/bankingContent`,
      providesTags: ["Keyvalue"],
    }),
    getBankImage: builder.query<Setting, void>({
      query: () => `/keyvalue/BankAccountQR`,
      providesTags: ["Keyvalue"],
    }),
    getBankNumber: builder.query<Setting, void>({
      query: () => `/keyvalue/bankAccountNumber`,
      providesTags: ["Keyvalue"],
    }),
    getEmailWeb: builder.query<Setting, void>({
      query: () => `/keyvalue/email`,
      providesTags: ["Keyvalue"],
    }),
    getFavicon: builder.query<Setting, void>({
      query: () => `/keyvalue/favicon`,
      providesTags: ["Keyvalue"],
    }),
    getAddress: builder.query<Setting, void>({
      query: () => `/keyvalue/address`,
      providesTags: ["Keyvalue"],
    }),
    getWebPhoneNumber1: builder.query<Setting, void>({
      query: () => `/keyvalue/webPhoneNumber1`,
      providesTags: ["Keyvalue"],
    }),
    getWebTitle: builder.query<Setting, void>({
      query: () => `/keyvalue/webTitle`,
      providesTags: ["Keyvalue"],
    }),

    getLoader: builder.query<Setting, void>({
      query: () => `/keyvalue/loadingScreen`,
      providesTags: ["Keyvalue"],
    }),
    getLinkFacebook: builder.query<Setting, void>({
      query: () => `/keyvalue/facebookLink`,
      providesTags: ["Keyvalue"],
    }),
  }),
});

export const {
  useGetLogoQuery,
  useGetBankNameQuery,
  useLazyGetBannerQuery,
  useGetBankAccountNameQuery,
  useGetAddressQuery,
  useGetEmailWebQuery,
  useGetBannerQuery,
  useGetFaviconQuery,
  useGetWebPhoneNumber1Query,
  useGetWebTitleQuery,
  useGetLoaderQuery,
  useGetSubBannerQuery,
  useGetBankContentQuery,
  useGetBankImageQuery,
  useGetBankNumberQuery,
  useGetLinkFacebookQuery,
} = SettingApi;
export const settingReducer = SettingApi.reducer;
export default SettingApi;
