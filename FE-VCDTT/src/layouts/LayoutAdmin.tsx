import { FooterAdmin, HeaderAdmin, SideBarAdmin } from "../componenets";
import { Outlet } from "react-router-dom";

const LayoutAdmin = () => {
  return (
    <>
      <div id="wrapper">
        <HeaderAdmin />
        <Outlet />
        <SideBarAdmin />
        <FooterAdmin />
      </div>
    </>
  );
};

export default LayoutAdmin;
