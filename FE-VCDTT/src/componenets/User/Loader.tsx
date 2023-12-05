import { useState, useEffect } from "react";
import { useGetLoaderQuery } from "../../api/setting";
import { Setting } from "../../interfaces/Setting";

const Loader = () => {
  const [isLoading, setIsLoading] = useState(true);
  const {data:dataLoader} = useGetLoaderQuery();

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

         {dataLoader?.data.keyvalue.map(({value}:Setting)=>{
                    return(
                  <img
                    src={value}
                    alt=""
                  />
                  )
                })}
      </div>
    </div>
  ) : null;
};

export default Loader;
