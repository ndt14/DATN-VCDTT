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


import storage from 'redux-persist/lib/storage';
import TourApi, { tourReducer } from '../api/tours';
import FaqApi, { faqReducer } from '../api/faqs';
import BlogApi, { blogReducer } from "../api/blogs";


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
})
const middleware = [TourApi.middleware, FaqApi.middleware,BlogApi.middleware]
 

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
