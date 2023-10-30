import React, { useRef } from "react";
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { useGetBillsWithUserIDQuery } from "../../../api/bill";
import { useGetUserByIdQuery } from "../../../api/user";
import { Bill } from "../../../interfaces/Bill";
import { Alert, Space } from "antd";
import { useGetTourFavoriteByIdQuery } from "../../../api/user";
import { Tour } from "../../../interfaces/Tour";
import { useUpdateFavoriteMutation } from "../../../api/favorite";
import { Favorite } from "../../../interfaces/Favorite";

const UserTour = () => {
  const user = JSON.parse(localStorage.getItem("user"));
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
    updateTourFavorite(info).then((response) => {
      alert("Bỏ thích thành công");
    });
  };

  const handleClick =
    (id: number) => (e: React.MouseEvent<HTMLAnchorElement>) => {
      e.preventDefault();
      handleFavorite(id);
    };

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
              <h1 className="inner-title">Tìm kiếm tour</h1>
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

              {/* <Link
                to={"/user/profile"}
                className="nav row "
                id="myTab"
                role="tablist"
              >
                <button className=" border-0 btn w-100" type="button">
                  Hồ sơ
                </button>
              </Link>

              <Link
                to={"/user/profile"}
                className="nav row "
                id="myTab"
                role="tablist"
              >
                <button className="border-0 btn w-100" type="button">
                  Tour đã đặt
                </button>
              </Link>

              <Link
                to={"/user/profile"}
                className="nav row "
                id="myTab"
                role="tablist"
              >
                <button className=" border-0 btn w-100" type="button">
                  Tour yêu thích
                </button>
              </Link> */}
              {/* <div className="">
                <div className="">
                  <nav id="navigation" className="">
                    <ul>
                      <ul>
                        <li>
                          <Link to="user/profile">Thông tin cá nhân</Link>
                        </li>
                        <li>
                          <Link to="user/tours">Tour đã mua</Link>
                        </li>
                        <li>
                          <Link to="user/favorite">Tour yêu thích</Link>
                        </li>
                      </ul>
                    </ul>
                  </nav>
                </div>
              </div> */}
              <nav className="nav flex-column">
                <Link className="nav-link" to={"/user/profile"}>
                  Thông tin cá nhân
                </Link>
                <Link className="nav-link active" to={"/user/tours"}>
                  Tour đã đặt
                </Link>
                <Link className="nav-link" to={"/user/favorite"}>
                  Tour yêu thích
                </Link>
              </nav>

              {/* End left panel */}
            </div>
          </div>
          <div className="col-8">
            <h3></h3>
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
                                onClick={handleClick(id)}
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
