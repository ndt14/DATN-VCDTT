import { Routes, Route } from "react-router-dom";
import Dashboard from "../pages/admin/Dashboard";
import LayoutAdmin from "../layouts/LayoutAdmin";
import LayOutClient from "../layouts/LayOutClient";
// import ScrollToTop from "../hooks/ScrollToTop";
import {
  HomePage,
  BlogDetail,
  BlogsPage,
  ContactPage,
  FaqsPage,
  NotFoundPage,
  TourDetail,
  PurchasingInformation,
  PrivacyPolicy,
} from "../pages/user";
import TourSearch from "../pages/user/TourSearch/TourSearch";
import UserProfile from "../pages/user/UserProfile/UserProfile";
import BillSuccess from "../pages/user/BillSuccess/BillSuccess";
import UserTour from "../pages/user/UserTour/UserTour";
import UserFavorite from "../pages/user/UserFavorite/UserFavorite";
import SearchBar from "../componenets/User/SearchBar";

const PublicRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<LayOutClient />}>
        <Route index element={<HomePage />} />
        <Route path="tours" element={<HomePage />} />
        <Route path="tours/:id" element={<TourDetail />} />
        <Route
          path="check_order_information/:id"
          element={<PurchasingInformation />}
        />
        <Route path="vnpay?" element={<BillSuccess />} />
        <Route path="categories" element={<HomePage />} />
        <Route path="about" element={<HomePage />} />
        <Route path="contact" element={<ContactPage />} />
        <Route path="blogs" element={<BlogsPage />} />
        <Route path="blogs/:id" element={<BlogDetail />} />
        <Route path="faqs" element={<FaqsPage />} />
        <Route path="wish_lists" element={<HomePage />} />
        <Route path="purchase_histories" element={<HomePage />} />
        <Route path="signin" element={<HomePage />} />
        <Route path="signup" element={<HomePage />} />
        <Route path="search" element={<TourSearch />} />
        <Route path="user/profile" element={<UserProfile />} />
        <Route path="user/tours" element={<UserTour />} />
        <Route path="user/favorite" element={<UserFavorite />} />
        <Route path="privacy_policy" element={<PrivacyPolicy />} />
        <Route path="*" element={<NotFoundPage />} />
      </Route>

      <Route path="admin" element={<LayoutAdmin />}>
        <Route index element={<Dashboard />} />
      </Route>

      <Route path="*" element={<NotFoundPage />}></Route>
      <Route path="/se" element={<SearchBar/>}></Route>
    </Routes>
  );
};

export default PublicRoutes;
