import React from "react";
import { Link } from "react-router-dom";
import { useGetUserByIdQuery } from "../../../api/user";
import { useGetTourFavoriteByIdQuery } from "../../../api/user";
import { Tour } from "../../../interfaces/Tour";
import { useUpdateFavoriteMutation } from "../../../api/favorite";
import { IoPersonOutline } from "react-icons/io5";
import { FaRegHeart } from "react-icons/fa";
import { FaRegListAlt } from "react-icons/fa";
import SecondaryBanner from "../../../componenets/User/SecondaryBanner";
import { AiFillEye } from "react-icons/ai";
import { Rate } from "antd";
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";

const MySwal = withReactContent(Swal);

const UserTour = () => {
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  const userId = user?.id;

  const { data: userData } = useGetUserByIdQuery(userId || "");
  const { data: favoriteData } = useGetTourFavoriteByIdQuery(userId || "");
  const [updateTourFavorite] = useUpdateFavoriteMutation();
  const tourFavorite = favoriteData?.data.tours;
  console.log(tourFavorite);

  const userName = userData?.data?.user.name;
  const userEmail = userData?.data?.user.email;

  const handleFavoriteRemove = (id: number) => {
    const info = {
      user_id: userId !== null ? parseInt(userId) : 0,
      tour_id: id,
    };
    updateTourFavorite(info).then(async () => {
      MySwal.fire({
        text: "Bỏ thích thành công",
        icon: "success",
        showCancelButton: false,
        showConfirmButton: false,
        timer: 4000,
      });
      await new Promise((resolve) => setTimeout(resolve, 4000));

      // Reload the window
      window.location.reload();
    });
  };

  const handleClickRemove =
    (id: number | undefined) => (e: React.MouseEvent<HTMLAnchorElement>) => {
      e.preventDefault();
      if (typeof id === "number") {
        handleFavoriteRemove(id);
      } else {
        // Handle the case when id is undefined
        // console.log("Invalid id");
      }
    };
  const removeVietnameseSigns = (str: any) => {
    str = str.toLowerCase();
    // Chuyển đổi các ký tự có dấu thành không dấu
    str = str.replace(/á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/g, "a");
    str = str.replace(/đ/g, "d");
    str = str.replace(/é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/g, "e");
    str = str.replace(/í|ì|ĩ|ỉ|ị/g, "i");
    str = str.replace(/ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/g, "o");
    str = str.replace(/ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/g, "u");
    str = str.replace(/ý|ỳ|ỹ|ỷ|ỵ/g, "y");
    return str;
  };

  const createSlugFromString = (inputString: any) => {
    const stringWithoutVietnameseSigns = removeVietnameseSigns(inputString);
    return stringWithoutVietnameseSigns
      .replace(/\s+/g, "-")
      .replace(/[^\w\-]+/g, "")
      .replace(/\-\-+/g, "-")
      .replace(/^-+/, "")
      .replace(/-+$/, "");
  };

  const titleElement = document.querySelector("title");
  if (titleElement) {
    titleElement.innerText = "Thông tin người dùng";
  }
  const dataTitle = "Tour yêu thích";

  return (
    <div>
      <SecondaryBanner>{dataTitle}</SecondaryBanner>

      <section className="container" style={{ marginBottom: "200px" }}>
        <div className="row">
          <div className="col-md-4">
            <div className="border">
              <div className="d-flex p-3">
                <div>
                  <img
                    style={{ width: "70px" }}
                    src="../../../../assets/images/travel.png"
                    alt=""
                  />
                </div>
                <div>
                  <h3>{userName} </h3>
                  <p>{userEmail}</p>
                </div>
              </div>
              <hr />
              {/* Left panel */}
              <div className="">
                <nav className="nav flex-column ">
                  <Link className="nav-link text-black" to={"/user/profile"}>
                    <IoPersonOutline /> Thông tin cá nhân
                  </Link>
                  <Link className="nav-link text-black" to={"/user/tours"}>
                    <FaRegListAlt /> Tour đã đặt
                  </Link>
                  <Link
                    className="nav-link text-white"
                    style={{ backgroundColor: "#1677FF" }}
                    to={"/user/favorite"}
                  >
                    <FaRegHeart /> Tour yêu thích
                  </Link>
                  <Link className="nav-link text-black" to={"/user/coupon"}>
                    <FaRegListAlt /> Mã Giảm giá
                  </Link>
                </nav>
              </div>

              {/* End left panel */}
            </div>
          </div>
          <div className="col-md-8">
            <h3>Tour yêu thích</h3>
            {tourFavorite == "" ? (
              <p>Hiện bạn chưa có tour yêu thích nào</p>
            ) : (
              <div className="row">
                {tourFavorite?.map(
                  ({
                    id,
                    name,
                    details,
                    main_img,
                    view_count,
                    adult_price,
                    star,
                  }: Tour) => {
                    return (
                      <div className="col-lg-6 col-md-6" key={id}>
                        <div className="package-wrap">
                          <figure className="feature-image">
                            <Link
                              to={`/tours/${id}-${createSlugFromString(
                                name
                              )}.html`}
                            >
                              <img
                                className="w-full img-fixed"
                                src={main_img}
                                alt=""
                              />
                            </Link>
                          </figure>
                          <div className="package-price badge">
                            <h6 className="">
                              <span>
                                {new Intl.NumberFormat("vi-VN", {
                                  style: "currency",
                                  currency: "VND",
                                }).format(adult_price)}{" "}
                              </span>{" "}
                            </h6>
                          </div>
                          <div className="package-content-wrap">
                            {/* <div className="package-meta text-center"></div> */}
                            <div className="package-content">
                              <div className="text-container">
                                <h3 className="margin-top-12 text-content">
                                  <Link
                                    className="mt-12"
                                    to={`/tours/${id}-${createSlugFromString(
                                      name
                                    )}.html`}
                                  >
                                    {name}
                                  </Link>
                                </h3>
                              </div>
                              <div className="review-area">
                                <div
                                  className=""
                                  title={`Rated ${star} out of 5`}
                                >
                                  <span className="w-90">
                                    <Rate allowHalf disabled value={star} />
                                  </span>{" "}
                                  <span className="review-text">
                                    ({view_count} <AiFillEye size={25} />)
                                  </span>
                                </div>
                              </div>
                              <div className="text-description">
                                <span
                                  className="text-from-api"
                                  dangerouslySetInnerHTML={{
                                    __html: details,
                                  }}
                                ></span>
                              </div>

                              <div className="btn-wrap">
                                <a
                                  href="#"
                                  onClick={handleClickRemove(id)}
                                  className="button-text width-6 text-pink"
                                >
                                  Đã thích
                                  <i className="far fa-heart"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    );
                  }
                )}
              </div>
            )}
          </div>
        </div>
      </section>
    </div>
  );
};

export default UserTour;
