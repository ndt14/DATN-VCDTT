import { combineReducers, configureStore } from "@reduxjs/toolkit";
import {
  FLUSH,
  PAUSE,
  PERSIST,
  PURGE,
  REGISTER,
  REHYDRATE,
  persistReducer,
  persistStore,
} from "redux-persist";

import storage from "redux-persist/lib/storage";
import TourApi, { tourReducer } from "../api/tours";
import FaqApi, { faqReducer } from "../api/faqs";
import BlogApi, { blogReducer } from "../api/blogs";
import BillApi, { billReducer } from "../api/bill";
import AuthApi, { authReducer } from "../api/auth";
import CouponApi, { couponReducer } from "../api/coupon";
import CategoryApi, { categoryReducer } from "../api/category";
import UserApi, { userReducer } from "../api/user";
import RatingApi, { ratingReducer } from "../api/rating";
import FavoriteApi, { favoriteReducer } from "../api/favorite";
import PrivacyApi, { privacyReducer } from "../api/privacy";

const persistConfig = {
  key: "root",
  storage,
  whitelist: ["cart"],
};
const rootReducer = combineReducers({
  // [productApi.reducerPath]: productReducer,
  // [authApi.reducerPath]: authApi.reducer,
  [TourApi.reducerPath]: tourReducer,
  [FaqApi.reducerPath]: faqReducer,
  [BlogApi.reducerPath]: blogReducer,
  [BillApi.reducerPath]: billReducer,
  [AuthApi.reducerPath]: authReducer,
  [CouponApi.reducerPath]: couponReducer,
  [CategoryApi.reducerPath]: categoryReducer,
  [UserApi.reducerPath]: userReducer,
  [RatingApi.reducerPath]: ratingReducer,
  [FavoriteApi.reducerPath]: favoriteReducer,
  [PrivacyApi.reducerPath]: privacyReducer,
});
const middleware = [
  TourApi.middleware,
  FaqApi.middleware,
  BlogApi.middleware,
  BillApi.middleware,
  AuthApi.middleware,
  CouponApi.middleware,
  CategoryApi.middleware,
  UserApi.middleware,
  RatingApi.middleware,
  FavoriteApi.middleware,
  PrivacyApi.middleware
];

const persistedReducer = persistReducer(persistConfig, rootReducer);
export const store = configureStore({
  reducer: persistedReducer,
  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware({
      serializableCheck: {
        ignoredActions: [FLUSH, REHYDRATE, PAUSE, PERSIST, PURGE, REGISTER],
      },
    }).concat(...middleware),
});
export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;

export default persistStore(store);
