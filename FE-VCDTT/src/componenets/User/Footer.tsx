import { Link } from "react-router-dom";

const Footer = () => {
  return (
    <footer id="colophon" className="site-footer footer-primary">
      <div className="top-footer">
        <div className="container">
          <div className="row">
            <div className="col-lg-3 col-md-6">
              <aside className="widget widget_text">
                <h3 className="widget-title">Về VCDTT</h3>
                <div className="textwidget widget-text">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut
                  elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus
                  leo.
                </div>
                <div className="award-img">
                  <a href="#">
                    <img src="assets/images/logo6.png" alt="" />
                  </a>
                  <a href="#">
                    <img src="assets/images/logo2.png" alt="" />
                  </a>
                </div>
              </aside>
            </div>
            <div className="col-lg-3 col-md-6">
              <aside className="widget widget_text">
                <h3 className="widget-title">THÔNG TIN LIÊN HỆ</h3>
                <div className="textwidget widget-text">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                  <ul>
                    <li>
                      <a href="#">
                        <i className="fas fa-phone-alt"></i>
                        +01 (977) 2599 12
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i className="fas fa-envelope"></i>
                        <span
                          className="__cf_email__"
                          data-cfemail="51323e3c21303f2811353e3c30383f7f323e3c"
                        >
                          [email&#160;protected]
                        </span>
                      </a>
                    </li>
                    <li>
                      <i className="fas fa-map-marker-alt"></i>
                      3146 Koontz, California
                    </li>
                  </ul>
                </div>
              </aside>
            </div>
            <div className="col-lg-3 col-md-6">
              <aside className="widget widget_recent_post">
                <h3 className="widget-title">BÀI VIẾT MỚI NHẤT</h3>
                <ul>
                  <li>
                    <h5>
                      <a href="#">
                        Life is a beautiful journey not a destination
                      </a>
                    </h5>
                    <div className="entry-meta">
                      <span className="post-on">
                        <a href="#">August 17, 2021</a>
                      </span>
                      <span className="comments-link">
                        <a href="#">No Comments</a>
                      </span>
                    </div>
                  </li>
                  <li>
                    <h5>
                      <a href="#">Take only memories, leave only footprints</a>
                    </h5>
                    <div className="entry-meta">
                      <span className="post-on">
                        <a href="#">August 17, 2021</a>
                      </span>
                      <span className="comments-link">
                        <a href="#">No Comments</a>
                      </span>
                    </div>
                  </li>
                </ul>
              </aside>
            </div>
            <div className="col-lg-3 col-md-6">
              <aside className="widget widget_newslatter">
                <h3 className="widget-title">ĐĂNG KÝ</h3>
                <div className="widget-text">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </div>
                <form className="newslatter-form">
                  <input type="email" name="s" placeholder="Email của bạn.." />
                  <input type="submit" name="s" value="ĐĂNG KÝ NGAY" />
                </form>
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
                    <a href="#">Chính sách riêng tư</a>
                  </li>
                  <li>
                    <a href="#">Thỏa thuận sử dụng</a>
                  </li>
                  <li>
                    <Link to="faqs">FAQ</Link>
                  </li>
                </ul>
              </div>
            </div>
            <div className="col-md-2 text-center">
              <div className="footer-logo">
                <Link to="">
                  <img src="assets/images/travele-logo.png" alt="" />
                </Link>
              </div>
            </div>
            <div className="col-md-5">
              <div className="copy-right text-right">
                Copyright © 2023 VCDTT. All rights reserveds
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
