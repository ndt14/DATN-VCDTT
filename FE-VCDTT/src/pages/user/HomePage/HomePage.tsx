import "./HomePage.css";
import { Carousel, Rate, Skeleton } from "antd";
import TinySlider from "tiny-slider-react";
import "tiny-slider/dist/tiny-slider.css";
// import TextContainer from "./TextContainer";

import { useGetToursQuery } from "../../../api/tours";
import { Tour } from "../../../interfaces/Tour";
import { Link } from "react-router-dom";
import Loader from "../../../componenets/User/Loader";
import { useState, useEffect } from "react";
import ReactPaginate from "react-paginate";
import _ from "lodash";
import { useGetTourFavoriteByIdQuery } from "../../../api/user";
import { useUpdateFavoriteMutation } from "../../../api/favorite";
import { AiFillEye } from "react-icons/ai";
import { useGetBlogsQuery } from "../../../api/blogs";
import { Blog } from "../../../interfaces/Blog";
import { useGetBannerQuery } from "../../../api/setting";
import { Setting } from "../../../interfaces/Setting";
import SearchBar from "../../../componenets/User/SearchBar";

const HomePage = () => {
  //

  //
  const [currentPage, setCurrentPage] = useState<number>(0);
  const { data, isLoading } = useGetToursQuery();
  // console.log(data);
  const handlePageChange = (selectedPage: { selected: number }) => {
    setCurrentPage(selectedPage.selected);
  };
  const itemsPerPage = 6;
  const pageCount = Math.ceil(data?.data?.tours.length / itemsPerPage);
  const currentData: Tour[] = (data?.data?.tours.slice(
    currentPage * itemsPerPage,
    (currentPage + 1) * itemsPerPage
  ) || []) as Tour[];
  const settings2 = {
    lazyload: false,
    nav: false,
    mouseDrag: true,
    items: 3,
    autoplay: true,
    autoplayButtonOutput: false,
  };

  const settings3 = {
    lazyload: false,
    nav: false,
    mouseDrag: true,
    items: 1,
    autoplay: true,
    autoplayButtonOutput: false,
  };

  //tour nổi bật
  // Sắp xếp danh sách tour theo view_count giảm dần
  const sortedTours = _.orderBy(data?.data.tours, ["view_count"], ["desc"]);
  const featuredTours = sortedTours.slice(0, 4);
  // console.log(featuredTours);

  //tour giảm giá
  const sortedDiscountedTours = _.orderBy(
    data?.data.tours,
    ["tourist_count"],
    ["desc"]
  );
  const saleTours = sortedDiscountedTours.slice(0, 4);

  //
  const [idArray, setIdArray] = useState<number[]>([]);

  const preParseUserData = localStorage.getItem("user");
  let userData: { id: string } | null = null;
  if (typeof preParseUserData === "string") {
    userData = JSON.parse(preParseUserData);
  }
  const userId = userData && userData.id ? userData.id : null;
  // console.log(typeof userId);

  const { data: favoriteData } = useGetTourFavoriteByIdQuery(userId || "");
  useEffect(() => {
    if (favoriteData) {
      // Handle the data when it is available
      const favoriteTours = favoriteData.data.tours;
      // Do something with favoriteTours
      const array = favoriteTours.map((item: Tour) => item.id);
      setIdArray(array);
    }
  }, [favoriteData]);

  //
  const [updateTourFavorite] = useUpdateFavoriteMutation();
  const handleFavoriteAdd = (id: number) => {
    const info = {
      user_id: userId !== null ? parseInt(userId) : 0,
      tour_id: id,
    };
    updateTourFavorite(info).then(() => {
      alert("Thêm vào yêu thích thành công");
    });
  };

  const handleFavoriteRemove = (id: number) => {
    const info = {
      user_id: userId !== null ? parseInt(userId) : 0,
      tour_id: id,
    };
    updateTourFavorite(info).then(() => {
      alert("Bỏ thích thành công");
    });
  };

  const handleClickAdd =
    (id: number | undefined) => (e: React.MouseEvent<HTMLAnchorElement>) => {
      e.preventDefault();
      if (typeof id === "number") {
        handleFavoriteAdd(id);
      } else {
        // Handle the case when id is undefined
        // console.log("Invalid id");
      }
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

  // SEO
  const titleElement = document.querySelector("title");
  if (titleElement) {
    titleElement.innerText = "Trang chủ - VCDTT";
  }
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

  //blog
  const { data: dataBlog } = useGetBlogsQuery();
  // console.log(dataBlog);
  const sortedDiscountedBlogs = _.orderBy(dataBlog?.data.blogs, ["id"]);
  const newBlogs = sortedDiscountedBlogs.slice(0, 3);

  //banner
  const { data: dataBanner } = useGetBannerQuery();
  return (
    <>
      <Loader />

      <main id="content" className="site-main">
        {/* <!-- Home slider html start --> */}
        <section className="home-slider-section ">
          <div className="home-slider d-none d-md-block">
            <div className="home-banner-items">
              <div className="banner-inner-wrap">
                <Carousel autoplay>
                  {dataBanner?.data.banner.map(({ url }: Setting) => {
                    return (
                      <>
                        <Carousel>
                          <img src={url} alt="" />
                        </Carousel>
                      </>
                    );
                  })}
                </Carousel>
              </div>
              <div className="banner-content-wrap">
                <div className="container"></div>
              </div>
              <div className="overlay"></div>
            </div>
          </div>
        </section>

        {/* <!-- slider html start -->
            <!-- Home search field html start --> */}
        <div className="trip-search-section shape-search-section">
          <div className="slider-shape"></div>
          <div className="container">
            <div className="trip-search-inner white-bg d-flex">
              <SearchBar />
              {/* <div className="input-group width-col-9  flex-grow-2">
                 <label> Tìm kiếm địa điểm * </label>
                <SearchBar />
                {/* <input type="text" name="s" placeholder="Nhập địa điểm" /> *
              </div>/}

              {/* <div className="input-group width-col-3">
              <Link to={'/search'}>
                <label className="screen-reader-text"> Tìm kiếm </label>
                
                <input
                  type="submit"
                  name="travel-search"
                  value="TÌM KIẾM"
                  className="rounded w-input"
                />
               </Link>
              </div> */}
            </div>
          </div>
        </div>

        <div className="container d-block d-sm-none">
          <div className="trip-search-inner white-bg d-flex">
            <SearchBar />
          </div>
        </div>

        {/*  */}
        <section className="package-section d-none d-xl-block d-xxl-none">
          <div className="container">
            <div className="section-heading text-center">
              <div className="row">
                <div className="col-lg-8 offset-lg-2">
                  <h5 className="dash-style">
                    KHÁM PHÁ CÁC ĐỊA DANH NỔI TIẾNG
                  </h5>
                  <h2 className="">TOUR NỔI BẬT</h2>
                </div>
              </div>
            </div>
            <div className="package-inner">
              <div className="row">
                {isLoading ? (
                  <Skeleton active />
                ) : (
                  <TinySlider settings={settings2}>
                    {featuredTours?.map(
                      ({
                        id,
                        name,
                        details,
                        main_img,
                        view_count,
                        adult_price,
                        star,
                      }: Tour) => {
                        if (idArray.includes(id as number)) {
                          return (
                            <div className="col-lg-4 col-md-6" key={id}>
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
                                      {" "}
                                      {new Intl.NumberFormat("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                      }).format(adult_price)}{" "}
                                    </span>
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
                                          <Rate
                                            allowHalf
                                            disabled
                                            value={star}
                                          />
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
                                        className="button-text width-6 text-pink"
                                        onClick={handleClickRemove(id)}
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
                        } else {
                          return (
                            <div className="col-lg-4 col-md-6" key={id}>
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
                                      {" "}
                                      {new Intl.NumberFormat("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                      }).format(adult_price)}{" "}
                                    </span>
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
                                          <Rate
                                            allowHalf
                                            disabled
                                            value={star}
                                          />
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
                                        onClick={handleClickAdd(id)}
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
                      }
                    )}
                  </TinySlider>
                )}
              </div>
            </div>
          </div>
        </section>
        {/* Mobile */}
        <section className="package-section d-block d-sm-none">
          <div className="container">
            <div className="section-heading text-center">
              <div className="row">
                <div className="col-lg-8 offset-lg-2">
                  <h5 className="dash-style">
                    KHÁM PHÁ CÁC ĐỊA DANH NỔI TIẾNG
                  </h5>
                  <h2 className="">TOUR NỔI BẬT</h2>
                </div>
              </div>
            </div>
            <div className="package-inner">
              <div className="row">
                {isLoading ? (
                  <Skeleton active />
                ) : (
                  <TinySlider settings={settings3}>
                    {featuredTours?.map(
                      ({
                        id,
                        name,
                        details,
                        main_img,
                        view_count,
                        adult_price,
                        star,
                      }: Tour) => {
                        if (idArray.includes(id as number)) {
                          return (
                            <div className="col-lg-4 col-md-6" key={id}>
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
                                      {" "}
                                      {new Intl.NumberFormat("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                      }).format(adult_price)}{" "}
                                    </span>
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
                                          <Rate
                                            allowHalf
                                            disabled
                                            value={star}
                                          />
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
                                        className="button-text width-6 text-pink"
                                        onClick={handleClickRemove(id)}
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
                        } else {
                          return (
                            <div className="col-lg-4 col-md-6" key={id}>
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
                                      {" "}
                                      {new Intl.NumberFormat("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                      }).format(adult_price)}{" "}
                                    </span>
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
                                          <Rate
                                            allowHalf
                                            disabled
                                            value={star}
                                          />
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
                                        onClick={handleClickAdd(id)}
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
                      }
                    )}
                  </TinySlider>
                )}
              </div>
            </div>
          </div>
        </section>

        {/*  */}

        {/*  */}
        <section className="special-section d-none d-xl-block d-xxl-none">
          <div className="container">
            <div className="section-heading text-center">
              <div className="row">
                <div className="col-lg-8 offset-lg-2">
                  <h5 className="dash-style">TOUR ĐỀ XUẤT & GIẢM GIÁ</h5>
                  <h2>TOUR GIẢM GIÁ</h2>
                </div>
              </div>
            </div>
            <div className="special-inner">
              <div className="row">
                {isLoading ? (
                  <Skeleton active />
                ) : (
                  <TinySlider settings={settings2}>
                    {saleTours?.map(
                      ({
                        id,
                        name,
                        details,
                        main_img,
                        view_count,
                        adult_price,
                        star,
                        sale_percentage,
                      }: Tour) => {
                        if (idArray.includes(id as number)) {
                          return (
                            <div className="col-lg-4 col-md-6" key={id}>
                              <div className="bg-primary text-white position-absolute discount badge ">
                                <span
                                  className="fs-4 font-weight-bold font-italic d-flex align-items-center justify-content-center"
                                  style={{ height: "100%" }}
                                >
                                  -{sale_percentage}%
                                </span>
                              </div>
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
                                      }).format(
                                        (adult_price *
                                          (100 - sale_percentage)) /
                                          100
                                      )}{" "}
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
                                          <Rate
                                            allowHalf
                                            disabled
                                            value={star}
                                          />
                                        </span>{" "}
                                        <span className="review-text">
                                          ({view_count} <AiFillEye size={25} />)
                                        </span>
                                      </div>
                                    </div>
                                    <div className="text-description">
                                      <span
                                        className=""
                                        dangerouslySetInnerHTML={{
                                          __html: details,
                                        }}
                                      ></span>
                                    </div>

                                    <div className="btn-wrap">
                                      <a
                                        href="#"
                                        className="button-text width-6 text-pink"
                                        onClick={handleClickRemove(id)}
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
                        } else {
                          return (
                            <div className="col-lg-4 col-md-6" key={id}>
                              <div className="bg-primary text-white position-absolute discount badge ">
                                <span
                                  className="fs-4 font-weight-bold font-italic d-flex align-items-center justify-content-center"
                                  style={{ height: "100%" }}
                                >
                                  -{sale_percentage}%
                                </span>
                              </div>
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
                                      }).format(
                                        (adult_price *
                                          (100 - sale_percentage)) /
                                          100
                                      )}{" "}
                                    </span>{" "}
                                    {/* <span>
                                      {new Intl.NumberFormat("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                      }).format(adult_price)}{" "}
                                    </span>{" "} */}
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
                                          <Rate
                                            allowHalf
                                            disabled
                                            value={star}
                                          />
                                        </span>{" "}
                                        <span className="review-text">
                                          ({view_count} <AiFillEye size={25} />)
                                        </span>
                                      </div>
                                    </div>
                                    <div className="text-description">
                                      <span
                                        className=""
                                        dangerouslySetInnerHTML={{
                                          __html: details,
                                        }}
                                      ></span>
                                    </div>

                                    <div className="btn-wrap">
                                      <a
                                        href="#"
                                        onClick={handleClickAdd(id)}
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
                      }
                    )}
                  </TinySlider>
                )}
              </div>
            </div>
          </div>
        </section>

        <section className="special-section d-block d-sm-none">
          <div className="container">
            <div className="section-heading text-center">
              <div className="row">
                <div className="col-lg-8 offset-lg-2">
                  <h5 className="dash-style">TOUR ĐỀ XUẤT & GIẢM GIÁ</h5>
                  <h2>TOUR GIẢM GIÁ</h2>
                </div>
              </div>
            </div>
            <div className="special-inner">
              <div className="row">
                {isLoading ? (
                  <Skeleton active />
                ) : (
                  <TinySlider settings={settings3}>
                    {saleTours?.map(
                      ({
                        id,
                        name,
                        details,
                        main_img,
                        view_count,
                        adult_price,
                        star,
                        sale_percentage,
                      }: Tour) => {
                        if (idArray.includes(id as number)) {
                          return (
                            <div className="col-lg-4 col-md-6" key={id}>
                              {sale_percentage > 0 ? (
                                <div className="bg-primary text-white position-absolute discount badge ">
                                  <span
                                    className="fs-4 font-weight-bold font-italic d-flex align-items-center justify-content-center"
                                    style={{ height: "100%" }}
                                  >
                                    -{sale_percentage}%
                                  </span>
                                </div>
                              ) : (
                                <span></span>
                              )}
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
                                      }).format(
                                        (adult_price *
                                          (100 - sale_percentage)) /
                                          100
                                      )}{" "}
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
                                          <Rate
                                            allowHalf
                                            disabled
                                            value={star}
                                          />
                                        </span>{" "}
                                        <span className="review-text">
                                          ({view_count} <AiFillEye size={25} />)
                                        </span>
                                      </div>
                                    </div>
                                    <div className="text-description">
                                      <span
                                        className=""
                                        dangerouslySetInnerHTML={{
                                          __html: details,
                                        }}
                                      ></span>
                                    </div>

                                    <div className="btn-wrap">
                                      <a
                                        href="#"
                                        className="button-text width-6 text-pink"
                                        onClick={handleClickRemove(id)}
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
                        } else {
                          return (
                            <div className="col-lg-4 col-md-6" key={id}>
                              <div className="bg-primary text-white position-absolute discount badge ">
                                {sale_percentage > 0 ? (
                                  <div className="bg-primary text-white position-absolute discount badge ">
                                    <span
                                      className="fs-4 font-weight-bold font-italic d-flex align-items-center justify-content-center"
                                      style={{ height: "100%" }}
                                    >
                                      -{sale_percentage}%
                                    </span>
                                  </div>
                                ) : (
                                  <span></span>
                                )}
                              </div>
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
                                      }).format(
                                        (adult_price *
                                          (100 - sale_percentage)) /
                                          100
                                      )}{" "}
                                    </span>{" "}
                                    {/* <span>
                                      {new Intl.NumberFormat("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                      }).format(adult_price)}{" "}
                                    </span>{" "} */}
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
                                          <Rate
                                            allowHalf
                                            disabled
                                            value={star}
                                          />
                                        </span>{" "}
                                        <span className="review-text">
                                          ({view_count} <AiFillEye size={25} />)
                                        </span>
                                      </div>
                                    </div>
                                    <div className="text-description">
                                      <span
                                        className=""
                                        dangerouslySetInnerHTML={{
                                          __html: details,
                                        }}
                                      ></span>
                                    </div>

                                    <div className="btn-wrap">
                                      <a
                                        className="button-text width-6"
                                        onClick={handleClickAdd(id)}
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
                      }
                    )}
                  </TinySlider>
                )}
              </div>
            </div>
          </div>
        </section>
        {/*  */}
        <section className="package-section">
          <div className="container">
            <div className="section-heading text-center">
              <div className="row">
                <div className="col-lg-8 offset-lg-2">
                  <h5 className="dash-style">
                    KHÁM PHÁ CÁC ĐỊA DANH NỔI TIẾNG
                  </h5>
                  <h2 className="">DANH SÁCH CÁC TOUR</h2>
                </div>
              </div>
            </div>
            <div className="package-inner">
              {isLoading ? (
                <Skeleton active />
              ) : (
                <div className="row">
                  {currentData?.map(
                    ({
                      id,
                      name,
                      details,
                      main_img,
                      view_count,
                      adult_price,
                      star,
                      sale_percentage,
                    }: Tour) => {
                      if (idArray.includes(id as number)) {
                        return (
                          <div className="col-lg-4 col-md-6" key={id}>
                            <div className="bg-primary text-white position-absolute discount badge ">
                              <span
                                className="fs-4 font-weight-bold font-italic d-flex align-items-center justify-content-center"
                                style={{ height: "100%" }}
                              >
                                -{sale_percentage}%
                              </span>
                            </div>
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
                                    }).format(
                                      (adult_price * (100 - sale_percentage)) /
                                        100
                                    )}{" "}
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
                      } else {
                        return (
                          <div
                            className="col-lg-4 col-md-6 position-relative"
                            key={id}
                          >
                            {sale_percentage > 0 ? (
                              <div className="bg-primary text-white position-absolute discount badge ">
                                <span
                                  className="fs-4 font-weight-bold font-italic d-flex align-items-center justify-content-center"
                                  style={{ height: "100%" }}
                                >
                                  -{sale_percentage}%
                                </span>
                              </div>
                            ) : (
                              <span></span>
                            )}

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
                                    }).format(
                                      (adult_price * (100 - sale_percentage)) /
                                        100
                                    )}{" "}
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
                                      onClick={handleClickAdd(id)}
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
                    }
                  )}

                  <ReactPaginate
                    previousLabel={"<-"}
                    nextLabel={"->"}
                    breakLabel={"..."}
                    pageCount={pageCount}
                    onPageChange={handlePageChange}
                    containerClassName={"pagination"}
                    activeClassName={"active"}
                  />

                  {/* <TourPreview></TourPreview>
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
              <TourPreview></TourPreview> */}
                </div>
              )}
              {/* <div className="btn-wrap text-center ">
              <a href="#" className="button-primary rounded">
                XEM TẤT CẢ TOUR
              </a>
            </div> */}
            </div>
          </div>
        </section>
        {/*  */}

        {/* <!-- best html end -->
            <!-- Home client section html start --> */}

        {/* <!-- client html end -->
            <!-- Home subscribe section html start --> */}

        {/* <!-- subscribe html end -->
            <!-- Home blog section html start --> */}
        <section className="blog-section">
          <div className="container">
            <div className="section-heading text-center">
              <div className="row">
                <div className="col-lg-8 offset-lg-2">
                  <h5 className="dash-style">Bài viết CỦA VCDTT</h5>
                  <h2>CÁC BÀI VIẾT MỚI NHẤT</h2>
                </div>
              </div>
            </div>
            <div className="row">
              {newBlogs?.map(({ id, title, short_desc, main_img }: Blog) => {
                return (
                  <div className="col-md-6 col-lg-4" key={id}>
                    <article className="post">
                      <figure className="feature-image">
                        <Link to={`blogs/${id}`}>
                          <img src={main_img} alt="" className="img-fixed" />
                        </Link>
                      </figure>
                      <div className="entry-content">
                        <h3>
                          <Link to={`blogs/${id}`}>{title}</Link>
                        </h3>
                        <div className="text-description">
                          <span
                            className="text-from-api"
                            dangerouslySetInnerHTML={{
                              __html: short_desc,
                            }}
                          ></span>
                        </div>
                      </div>
                    </article>
                  </div>
                );
              })}
            </div>
          </div>
        </section>
        {/* <!-- blog html end -->
             <!-- Home testimonial section html start --> */}
        {/* <section className="best-section">
          <div className="container">
            <div className="row">
              <div className="col-lg-5">
                <div className="section-heading">
                  <h5 className="dash-style">THƯ VIỆN ẢNH</h5>
                  <h2>MỘT SỐ HÌNH ẢNH NỔI BẬT</h2>
                  <p>
                    Aperiam sociosqu urna praesent, tristique, corrupti
                    condimentum asperiores platea ipsum ad arcu. Nostrud. Esse?
                    Aut nostrum, ornare quas provident laoreet nesciunt odio
                    voluptates etiam, omnis.
                  </p>
                </div>
                <figure className="gallery-img">
                  <img src="assets/images/img12.jpg" alt="" />
                </figure>
              </div>
              <div className="col-lg-7">
                <div className="row">
                  <div className="col-sm-6">
                    <figure className="gallery-img">
                      <img src="assets/images/img13.jpg" alt="" />
                    </figure>
                  </div>
                  <div className="col-sm-6">
                    <figure className="gallery-img">
                      <img src="assets/images/img14.jpg" alt="" />
                    </figure>
                  </div>
                </div>
                <div className="row">
                  <div className="col-12">
                    <figure className="gallery-img">
                      <img src="assets/images/img15.jpg" alt="" />
                    </figure>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section> */}
        {/* <!-- testimonial html end -->
            <!-- Home contact details section html start --> */}

        {/* <!--  contact details html end --> */}
      </main>
    </>
  );
};

export default HomePage;
