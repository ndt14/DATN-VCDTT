import { useState, useEffect } from "react";

const Loader = () => {
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    // Sử dụng setTimeout để đặt trạng thái isLoading thành false sau 2 giây
    const timer = setTimeout(() => {
      setIsLoading(false);
    }, 1000); // 2 giây

    // Hủy bỏ timer khi component unmount
    return () => clearTimeout(timer);
  }, []); // [] đảm bảo useEffect chỉ chạy sau khi component được render

  // Nếu isLoading là true, hiển thị loader, ngược lại không hiển thị
  return isLoading ? (
    <div id="siteLoader" className="site-loader">
      <div className="preloader-content">
        <img src="../../../assets/images/loader1.gif" alt="" />
      </div>
    </div>
  ) : null;
};

export default Loader;
