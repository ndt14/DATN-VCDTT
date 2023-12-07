import { Link } from "react-router-dom";
import MessengerChat from "./MessengerChat";
import { useGetAddressQuery, useGetEmailWebQuery, useGetLogoQuery, useGetWebPhoneNumber1Query } from "../../api/setting";
import { Setting } from "../../interfaces/Setting";
import { useGetBlogsQuery } from "../../api/blogs";
import _ from "lodash";
import { Blog } from "../../interfaces/Blog";
import moment from "moment";

const Footer = () => {
  const {data: dataPhone} = useGetWebPhoneNumber1Query()
  const {data: dataEmail} = useGetEmailWebQuery()
  const {data: dataAddress} = useGetAddressQuery()
  const {data: dataLogo} = useGetLogoQuery()

   //blog
   const { data: dataBlog } = useGetBlogsQuery();
  //  console.log(dataBlog);/
   const sortedDiscountedBlogs = _.orderBy(dataBlog?.data.blogs, ["id"]);
   const newBlogs = sortedDiscountedBlogs.slice(0, 2);


   const openWindow = () => {
    window.open("https://vcdtt.online/privacy_policy", "_blank");
  };
  const openWindow2 = () => {
    window.open("https://vcdtt.online/service_account", "_blank");
  };
  return (
    <>
          <MessengerChat/>

    <footer id="colophon" className="site-footer footer-primary">
       <div id="fb-root"></div>

{/* <!-- Your Plugin chat code --> */}
<div id="fb-customer-chat" className="fb-customerchat">
  </div>
      <div className="top-footer">
        <div className="container">
          <div className="row">
            <div className="col-lg-4 col-md-6">
              <aside className="widget widget_text">
                <h3 className="widget-title">Về VCDTT</h3>
                <div className="textwidget widget-text">
                - VCDTT là một trang web bán tour du lịch đầy màu sắc và phong phú. <br />
              - Chúng tôi cung cấp những trải nghiệm du lịch tuyệt vời với các tour độc đáo, dẫn đường chuyên nghiệp và dịch vụ chăm sóc khách hàng tận tâm. <br />
               - Hãy ghé thăm VCDTT để khám phá những điểm đến hấp dẫn và tạo ra những kỷ niệm đáng nhớ!
                </div>
                {/* <div className="award-img">
                  <a href="#">
                    <img src="assets/images/logo6.png" alt="" />
                  </a>
                  <a href="#">
                    <img src="assets/images/logo2.png" alt="" />
                  </a>
                </div> */}
              </aside>
            </div>
            <div className="col-lg-4 col-md-6">
              <aside className="widget widget_text">
                <h3 className="widget-title">THÔNG TIN LIÊN HỆ</h3>
                <div className="textwidget widget-text">
                 Nếu có thắc mắc hãy liên hẹ với chúng tôi qua các phương thức liên lạc
                  <ul>
                    <li>
                      <a href="#">
                        <i className="fas fa-phone-alt"></i>
                        {dataPhone?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                             <span key={id}>{value}</span>
                                         )
                                         })}
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i className="fas fa-envelope"></i>
                        <span
                          className="__cf_email__"
                         
                        >
                          {dataEmail?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                             <span key={id}>{value}</span>
                                         )
                                         })}
                        </span>
                      </a>
                    </li>
                    <li>
                      <i className="fas fa-map-marker-alt"></i>
                      {dataAddress?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                             <span key={id}>{value}</span>
                                         )
                                         })}
                    </li>
                  </ul>
                </div>
              </aside>
            </div>
            <div className="col-lg-4 col-md-6">
              <aside className="widget widget_recent_post">
                <h3 className="widget-title">BÀI VIẾT MỚI NHẤT</h3>
                {newBlogs?.map(({ id, title, created_at }: Blog) => {
return(
  <ul key={id}>
  <li className="mt-2">
    <h5>
      <a href="#">
       {title}
      </a>
    </h5>
    <div className="entry-meta">
      <span className="post-on">
        <a href="#"> {moment(created_at).format(
                                                "DD/MM/YYYY"
                                              )}</a>
      </span>
      {/* <span className="comments-link">
        <a href="#">No Comments</a>
      </span> */}
    </div>
  </li>
 
</ul>
)

})}
               
              </aside>
            </div>
          

          </div>
        </div>
      </div>
      <div className="buttom-footer">
        <div className="container">
          <div className="row align-items-center">
            <div className="col-md-5">
              <div className="footer-menu">
                <ul>
                  <li>
                    {/* <a href="#">Chính sách</a> */}
                    <Link to={""} onClick={openWindow}>Chính sách & quyền riêng tư</Link>
                    
                  </li>
                  <li>
                  <Link to={""} onClick={openWindow2}>Điều khoản & dịch vụ</Link>
                  </li>
                  <li>
                    <Link to="faqs">Faqs</Link>
                  </li>
                </ul>
              </div>
            </div>
            <div className="col-md-3 text-center">
              <div className="footer-logo">
                <Link to="">
                {dataLogo?.data.keyvalue.map(({value}:Setting)=>{
                    return(
                  <img
                    src={value}
                    alt=""
                  />
                  )
                })}
                </Link>
              </div>
            </div>
            <div className="col-md-3">
              <div className="copy-right text-right">
                Copyright © 2023 VCDTT
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
    </>
  );
};

export default Footer;
