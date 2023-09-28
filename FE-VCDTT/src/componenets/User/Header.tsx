import { Link } from "react-router-dom";

const Header = () => {
  return (
    <>
      <header id="masthead" className="site-header header-primary">
        {/* <!-- header html start --> */}
        <div className="top-header"></div>
        <div className="bottom-header">
          <div className="container d-flex justify-content-between align-items-center">
            <div className="site-identity">
              <h1 className="site-title">
                <Link to="">
                  <img
                    className="white-logo"
                    src="../../../assets/images/travele-logo.png"
                    alt="logo"
                  />
                  <img
                    className="black-logo"
                    src="../../../assets/images/travele-logo1.png"
                    alt="logo"
                  />
                </Link>
              </h1>
            </div>
            <div className="main-navigation d-none d-lg-block">
              <nav id="navigation" className="navigation">
                <ul>
                  <li className="menu-item-has-children">
                    <Link to={""}>Trang chủ</Link>
                  </li>
                  <li className="menu-item-has-children">
                    <a href="#">Danh mục</a>
                    <ul>
                      <li>
                        <a href="destination.html">Miền Bắc</a>
                      </li>
                      <li>
                        <a href="tour-packages.html">Miền Trung</a>
                      </li>
                      <li>
                        <a href="package-offer.html">Miền Nam</a>
                      </li>
                      <li>
                        <a href="package-detail.html">Vùng núi</a>
                      </li>
                      <li>
                        <a href="tour-cart.html">Vùng biển</a>
                      </li>
                    </ul>
                  </li>
                  <li className="menu-item-has-children">
                    <Link to="blogs">Bài viết</Link>
                    <ul>
                      <li>
                        <Link to="blogs/1">Bài viết 1</Link>
                      </li>
                      <li>
                        <Link to="blogs/2">Bài viết 2</Link>
                      </li>
                      <li>
                        <Link to="blogs/3">Bài viết 3</Link>
                      </li>
                    </ul>
                  </li>
                  <li className="menu-item-has-children">
                    <Link to="contact">Liên hệ</Link>
                    {/* <ul>
                      <li>
                        <a href="product-right.html">Shop Archive</a>
                      </li>
                      <li>
                        <a href="product-detail.html">Shop Single</a>
                      </li>
                      <li>
                        <a href="product-cart.html">Shop Cart</a>
                      </li>
                      <li>
                        <a href="product-checkout.html">Shop Checkout</a>
                      </li>
                    </ul> */}
                  </li>
                </ul>
              </nav>
            </div>
            <div className="header-btn">
              <div className="">
                <Link className="button-primary rounded" to="login">
                  ĐĂNG NHẬP
                </Link>
              </div>
              <div>
                <Link
                  className="button-primary rounded"
                  style={{ marginLeft: "12px" }}
                  to="signup"
                >
                  ĐĂNG KÝ
                </Link>
              </div>
            </div>
          </div>
        </div>
        <div className="mobile-menu-container"></div>
      </header>
      <a id="backTotop" href="#" className="to-top-icon">
        <i className="fas fa-chevron-up"></i>
      </a>
    </>
  );
};

export default Header;
