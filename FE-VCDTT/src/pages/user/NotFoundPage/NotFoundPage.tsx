import { Link } from "react-router-dom";

const NotFoundPage = () => {
  const backgroundImageUrl = "../../../../assets/images/404-img.jpg";

  const containerStyle = {
    background: `url(${backgroundImageUrl})`,
    backgroundSize: "cover",
  };
  return (
    <>
      <div id="page" className="full-page">
        <main id="content" className="site-main" style={containerStyle}>
          <div className="no-content-section 404-page">
            <div className="container">
              <div className="no-content-wrap">
                <span>404</span>
                <h1>Không tìm thấy trang được yêu cầu</h1>
                <h4>
                  Có vẻ như không có gì ở đây. Hãy thử tìm kiếm hoặc nhập một
                  địa chỉ URL khác
                </h4>
                <Link className="fs-2 fw-bold" to={"/"}>
                  Trở về trang chủ
                </Link>
              </div>
            </div>
            <div className="overlay"></div>
          </div>
        </main>

        <a id="backTotop" href="#" className="to-top-icon">
          <i className="fas fa-chevron-up"></i>
        </a>
        {/* <!-- custom search field html --> */}
        <div className="header-search-form">
          <div className="container">
            <div className="header-search-container">
              <form className="search-form" role="search" method="get">
                <input type="text" name="s" placeholder="Enter your text..." />
              </form>
              <a href="#" className="search-close">
                <i className="fas fa-times"></i>
              </a>
            </div>
          </div>
        </div>
        {/* <!-- header html end --> */}
      </div>
    </>
  );
};

export default NotFoundPage;
