// import { Footer, Header } from "../componenets";
import { Outlet } from "react-router-dom";
import Header from "../componenets/User/Header";
import Footer from "../componenets/User/Footer";
import Loader from "../componenets/User/Loader";

const LayOutClient = () => {
  return (
    <>
      <div id="wrapper">
        
        <Header />
        <Outlet/>
        {<Loader/>}
        <Footer />
      </div>
    </>
  );
};

export default LayOutClient;
