import { Routes, Route } from "react-router-dom";
import Dashboard from "../pages/admin/Dashboard";
import LayoutAdmin from "../layouts/LayoutAdmin";
import LayOutClient from "../layouts/LayOutClient";
import {HomePage, BlogDetail, BlogsPage, ContactPage, FaqsPage, NotFoundPage, TourDetail } from "../pages/user";

const PublicRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<LayOutClient />}>
        <Route index element={<HomePage />} />
        <Route path="tours" element={<HomePage />} />
        <Route path="tours/:id" element={<TourDetail />} />
        <Route path="categories" element={<HomePage />} />
        <Route path="about" element={<HomePage />} />
        <Route path="contact" element={<ContactPage />} />
        <Route path="blogs" element={<BlogsPage />} />
        <Route path="blogs/:id" element={<BlogDetail/>} />
        <Route path="faqs" element={<FaqsPage />} />
        <Route path="wish_lists" element={<HomePage />} />
        <Route path="purchase_histories" element={<HomePage />} />
        <Route path="signin" element={<HomePage />} />
        <Route path="signup" element={<HomePage />} />
        <Route path="*" element={<NotFoundPage />} />
      </Route>

      <Route path="admin" element={<LayoutAdmin />}>
        <Route index element={<Dashboard />} />
      </Route>

      
    </Routes>
  );
};

export default PublicRoutes;
