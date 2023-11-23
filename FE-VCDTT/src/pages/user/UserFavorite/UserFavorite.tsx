import React from "react";
import { Link } from "react-router-dom";
import { useGetUserByIdQuery } from "../../../api/user";
import { useGetTourFavoriteByIdQuery } from "../../../api/user";
import { Tour } from "../../../interfaces/Tour";
import { useUpdateFavoriteMutation } from "../../../api/favorite";
import { IoPersonOutline } from "react-icons/io5";
import { FaRegHeart } from "react-icons/fa";
import { FaRegListAlt } from "react-icons/fa";

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

  const handleFavorite = (id: number) => {
    const info = {
      user_id: userId,
      tour_id: id,
    };
    updateTourFavorite(info).then(() => {
      alert("Bỏ thích thành công");
    });
  };

  const handleClick =
    (id: number) => (e: React.MouseEvent<HTMLAnchorElement>) => {
      e.preventDefault();
      handleFavorite(id);
    };

  const titleElement = document.querySelector("title");
  if (titleElement) {
    titleElement.innerText = "Thông tin người dùng";
  }
  return (
    <div>
      <section className="inner-banner-wrap">
        <div
          className="inner-baner-container"
          style={{
            backgroundImage: `url(../../../../assets/images/bg/bg1.jpg)`,
          }}
        >
          <div className="container">
            <div className="inner-banner-content">
              <h1 className="inner-title">Thông tin tài khoản</h1>
            </div>
          </div>
        </div>
        <div className="inner-shape"></div>
      </section>
      <section className="container" style={{ marginBottom: "200px" }}>
        <div className="row">
          <div className="col-4">
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
              <div className="shadow-lg">
                <nav className="nav flex-column ">
                  <Link className="nav-link" to={"/user/profile"}>
                    <IoPersonOutline /> Thông tin cá nhân
                  </Link>
                  <Link className="nav-link active" to={"/user/tours"}>
                    <FaRegListAlt /> Tour đã đặt
                  </Link>
                  <Link
                    className="nav-link text-white"
                    style={{ backgroundColor: "#1677FF" }}
                    to={"/user/favorite"}
                  >
                    <FaRegHeart /> Tour yêu thích
                  </Link>
                </nav>
              </div>

              {/* End left panel */}
            </div>
          </div>
          <div className="col-8">
            <h3>Tour yêu thích</h3>
            <div className="row">
              {tourFavorite?.map(
                ({
                  id,
                  name,
                  details,
                  main_img,
                  view_count,
                  adult_price,
                }: Tour) => {
                  return (
                    <div className="col-lg-6 col-md-6" key={id}>
                      <div className="package-wrap">
                        <figure className="feature-image">
                          <Link to={`/tours/${id}`}>
                            <img className="w-full" src={main_img} alt="" />
                          </Link>
                        </figure>
                        <div className="package-price">
                          <h6>
                            <span>{adult_price} đ </span> / người
                          </h6>
                        </div>
                        <div className="package-content-wrap">
                          {/* <div className="package-meta text-center"></div> */}
                          <div className="package-content">
                            <div className="text-container">
                              <h3 className="margin-top-12 text-content">
                                <Link className="mt-12" to={`/tours/${id}`}>
                                  {name}
                                </Link>
                              </h3>
                            </div>
                            <div className="review-area">
                              <span className="review-text">
                                ({view_count} reviews)
                              </span>
                              <div
                                className="rating-start"
                                title="Rated 5 out of 5"
                              >
                                <span className="w-3/5"></span>
                              </div>
                            </div>
                            <div className="text-description">
                              <p className="text-content">{details}</p>
                            </div>

                            <div className="btn-wrap">
                              <a
                                onClick={() => handleClick(id || 0)}
                                href="#"
                                className="button-text width-6"
                              >
                                Thêm vào yêu thích
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
          </div>
        </div>
      </section>
    </div>
  );
};

export default UserTour;
