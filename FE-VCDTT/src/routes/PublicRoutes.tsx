import { Routes, Route } from "react-router-dom";
import HomePage from "../pages/HomePage";
import Dashboard from "../pages/admin/Dashboard";
import LayoutAdmin from "../layouts/LayoutAdmin";

const PublicRoutes = () => {
  return (
    <Routes>
      <Route path="">
        <Route index element={<HomePage />}/>
      </Route>
      <Route path="admin" element={<LayoutAdmin/>}>
        <Route index element={<Dashboard/>}/>
      </Route>
    </Routes>
  );
};

export default PublicRoutes;
