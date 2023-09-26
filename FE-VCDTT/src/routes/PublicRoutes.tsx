import { Routes, Route } from "react-router-dom";
import HomePage from "../pages/user/HomePage/HomePage";
import Dashboard from "../pages/admin/Dashboard";
import LayoutAdmin from "../layouts/LayoutAdmin";
import LayOutClient from "../layouts/LayOutClient";

const PublicRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<LayOutClient />}>
        <Route index element={<HomePage />} />
        <Route path="tours" element={<HomePage />} />
        <Route path="tours/:id" element={<HomePage />} />
        <Route path="categories" element={<HomePage />} />
        <Route path="about" element={<HomePage />} />
        <Route path="contact" element={<HomePage />} />
        <Route path="blogs" element={<HomePage />} />
        <Route path="faqs" element={<HomePage />} />
        <Route path="wish_lists" element={<HomePage />} />
        <Route path="purchase_histories" element={<HomePage />} />
        <Route path="auth">
          <Route path="signin" element={<HomePage />} />
          <Route path="signup" element={<HomePage />} />
        </Route>
      </Route>

      <Route path="admin" element={<LayoutAdmin />}>
        <Route index element={<Dashboard />} />
      </Route>

      <Route path="*" element={<HomePage />} />
    </Routes>
  );
};

export default PublicRoutes;
