import { Link, useLocation, useNavigate, useParams } from "react-router-dom";
import { useEffect, useRef, useState } from "react";
import { useGetTourByIdQuery } from "../../../api/tours";
import Loader from "../../../componenets/User/Loader";
import "./TourDetail.css";
import { DatePicker, Rate } from "antd";
import type { DatePickerProps } from "antd";
import moment from "moment";
import TinySlider from "tiny-slider-react";
import "tiny-slider/dist/tiny-slider.css";
import { Tour } from "../../../interfaces/Tour";
import { Rating } from "../../../interfaces/Rating";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faStar } from "@fortawesome/free-solid-svg-icons";
import { useAddRatingMutation } from "../../../api/rating";
import { useGetUserByIdQuery } from "../../../api/user";
import { useGetBillsWithUserIDQuery } from "../../../api/bill";

const TourDetail = () => {
  const [dateTour, setDateTour] = useState<string>(" ");
  const [isDateSelected, setIsDateSelected] = useState(false);
  const [addRating] = useAddRatingMutation();
  const user = JSON.parse(localStorage.getItem("user")) || "";
  // console.log(user);

  const userId = user?.id;
  const { data: TourHistoryData } = useGetBillsWithUserIDQuery(userId | "");
  const purchase_history = TourHistoryData?.data?.purchase_history;

  console.log(purchase_history);

  // const { data: userData } = useGetUserByIdQuery(userId || "");

  const userName = user.name;
  const location = useLocation();
  const onChange: DatePickerProps["onChange"] = (date, dateString) => {
    setDateTour(dateString);
    setIsDateSelected(true);
    // localStorage.setItem("dateTour", dateString);
  };
  const settings = {
    lazyload: false,
    nav: false,
    mouseDrag: true,
    items: 3,
    autoplay: true,
    autoplayButtonOutput: false,
  };

  //
  const { id } = useParams<{ id: string }>();

  const { data: tourData } = useGetTourByIdQuery(id || "");
  console.log(tourData);

  const tourId = id;
  const tourName = tourData?.data?.tour.name;
  const tourLocation = tourData?.data?.tour.name;
  const tourPrice = tourData?.data?.tour.adult_price;
  const tourChildPrice = tourData?.data?.tour.child_price;
  const exact_location = tourData?.data?.tour.exact_location;

  const formattedTourPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(tourPrice);
  const formattedTourChildPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(tourChildPrice);

  //validate date
  const disabledDate = (current: moment.Moment | null) => {
    return current && current < moment().startOf("day");
  };

  const backgroundImageUrl = "../../../../assets/images/inner-banner.jpg";

  const containerStyle = {
    background: `url(${backgroundImageUrl})`,
    backgroundSize: "cover",
  };
  //

  const [productNumber, setProductNumber] = useState(1);
  const [productChildNumber, setProductChildNumber] = useState(0);
  const [price, setPrice] = useState(tourPrice);
  const [childPrice, setChildPrice] = useState(tourChildPrice || 0);

  useEffect(() => {
    // Update price state when tourPrice is available
    if (tourPrice !== undefined) {
      setPrice(tourPrice);
    }
  }, [tourPrice]);

  const tourSameCategory = tourData?.data?.toursSameCate;
  // console.log(tourSameCategory);

  const handleProductNumberChange = (
    event: React.ChangeEvent<HTMLInputElement>
  ) => {
    const newProductNumber = parseInt(event.target.value, 10);
    if (newProductNumber > 0) {
      setProductNumber(newProductNumber);
      // Update the price based on the new product number
      const newPrice = newProductNumber * tourPrice; // Assuming the price increases by 10 for each product
      setPrice(newPrice);
      console.log(newPrice);
    }
  };
  const handleProductChildNumberChange = (
    event: React.ChangeEvent<HTMLInputElement>
  ) => {
    const newProductNumber = parseInt(event.target.value, 10);
    if (newProductNumber >= 0) {
      setProductChildNumber(newProductNumber);
      // Update the price based on the new product number
      const newPrice = newProductNumber * tourChildPrice; // Assuming the price increases by 10 for each product
      setChildPrice(newPrice);
    }
  };

  const formattedResultPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price + childPrice);

  const renderStarRating = (rating: number): JSX.Element[] => {
    const starIcons: JSX.Element[] = [];
    for (let i = 1; i <= 5; i++) {
      // Check if the current star should be yellow (active) or gray (inactive)
      const starClassName = i <= rating ? "star-icon yellow" : "star-icon gray";
      starIcons.push(
        <FontAwesomeIcon icon={faStar} className={starClassName} key={i} />
      );
    }
    return starIcons;
  };

  const [selectedStar, setSelectedStar] = useState(5);
  console.log(selectedStar);

  const [ratingData, setRatingData] = useState({
    star: selectedStar,
    user_id: userId,
    user_name: userName,
    content: "",
    tour_id: id, // Assuming 'id' is the tour ID
  });
  // const desc = ['terrible', 'bad', 'normal', 'good', 'wonderful'];
  const handleStarRatingChange = (star: number) => {
    setSelectedStar(star);
    setRatingData({ ...ratingData, star });
  };

  const handleUserNameChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setRatingData({ ...ratingData, user_name: event.target.value });
  };

  const handleContentChange = (
    event: React.ChangeEvent<HTMLTextAreaElement>
  ) => {
    setRatingData({ ...ratingData, content: event.target.value });
  };
  const navigate = useNavigate();
  const handleSubmitRating = async () => {
    if (ratingData.star > 0 && ratingData.user_name && ratingData.content) {
      try {
        const response = await addRating(ratingData);
        // Handle success, e.g., show a success message or update UI
        console.log("Đánh giá thành công", response);
        alert("đánh giá thành công");
        navigate("/");
      } catch (error) {
        // Handle error, e.g., show an error message
        console.error("Đánh giá thất bại", error);
      }
    } else {
      // Handle incomplete rating data, e.g., show an error message
      console.error("Please fill in all rating details");
    }
  };

  const isLoggedIn = user != "";

  const iframeRef = useRef(null);

  useEffect(() => {
    if (iframeRef.current) {
      const iframeSrc = `https://maps.google.com/maps?width=600&height=400&hl=en&q=${encodeURIComponent(
        exact_location
      )}&t=&z=14&ie=UTF8&iwloc=B&output=embed`;
      iframeRef.current.src = iframeSrc;
    }
  }, [exact_location]);

  return (
    <>
      <Loader />
      <main id="content" className="site-main">
        {/* <!-- Inner Banner html start--> */}
        <section className="inner-banner-wrap">
          <div className="inner-baner-container" style={containerStyle}>
            <div className="container">
              <div className="inner-banner-content">
                <h1 className="inner-title">Tour chi tiết</h1>
              </div>
            </div>
          </div>
          <div className="inner-shape"></div>
        </section>
        {/* <!-- Inner Banner html end--> */}
        <div className="single-tour-section">
          <div className="container">
            <div className="row">
              <div className="col-lg-7">
                <div className="single-tour-inner">
                  <h2>{tourData?.data?.tour.name}</h2>
                  <figure className="feature-image">
                    <img src={tourData?.data?.tour.main_img} alt="" />
                  </figure>

                  <div className="tab-container">
                    <ul className="nav nav-tabs" id="myTab" role="tablist">
                      <li className="nav-item">
                        <a
                          className="nav-link active"
                          id="overview-tab"
                          data-toggle="tab"
                          href="#overview"
                          role="tab"
                          aria-controls="overview"
                          aria-selected="true"
                        >
                          Mô Tả
                        </a>
                      </li>
                      <li className="nav-item">
                        <a
                          className="nav-link"
                          id="program-tab"
                          data-toggle="tab"
                          href="#program"
                          role="tab"
                          aria-controls="program"
                          aria-selected="false"
                        >
                          Chương Trình
                        </a>
                      </li>
                      <li className="nav-item">
                        <a
                          className="nav-link"
                          id="review-tab"
                          data-toggle="tab"
                          href="#review"
                          role="tab"
                          aria-controls="review"
                          aria-selected="false"
                        >
                          Đánh Giá
                        </a>
                      </li>
                      <li className="nav-item">
                        <a
                          className="nav-link"
                          id="map-tab"
                          data-toggle="tab"
                          href="#map"
                          role="tab"
                          aria-controls="map"
                          aria-selected="false"
                        >
                          Bản Đồ
                        </a>
                      </li>
                    </ul>
                    <div className="tab-content" id="myTabContent">
                      <div
                        className="tab-pane fade show active"
                        id="overview"
                        role="tabpanel"
                        aria-labelledby="overview-tab"
                      >
                        {/* mô tả tour  */}
                        <div className="overview-content">
                          {tourData?.data?.tour.details}
                        </div>
                      </div>
                      <div
                        className="tab-pane"
                        id="program"
                        role="tabpanel"
                        aria-labelledby="program-tab"
                      >
                        {/* lịch trình */}

                        {tourData?.data?.tour.pathway}
                      </div>
                      <div
                        className="tab-pane"
                        id="review"
                        role="tabpanel"
                        aria-labelledby="review-tab"
                      >
                        {/* <div className="summary-review">
                          <div className="review-score">
                            <span>4.9</span>
                          </div>
                          <div className="review-score-content">
                            <h3>
                              Excellent
                              <span>( Based on 24 reviews )</span>
                            </h3>
                            <p>
                              Tincidunt iaculis pede mus lobortis hendrerit
                              eveniet impedit aenean mauris qui, pharetra rem
                              doloremque laboris euismod deserunt non,
                              cupiditate, vestibulum.
                            </p>
                          </div>
                        </div> */}
                        {/* <!-- review comment html --> */}
                        <div className="comment-area">
                          <h3 className="comment-title">
                            Có {tourData?.data.listRatings.length} đánh giá
                          </h3>
                          <div className="comment-area-inner">
                            {tourData?.data.listRatings.map(
                              ({
                                id,
                                user_name,
                                content,
                                admin_answer,
                                star,
                                created_at,
                              }: Rating) => {
                                // Chuyển đổi giá trị "start" thành số nguyên
                                const starRating = parseInt(star);

                                return (
                                  <>
                                    <ol key={id}>
                                      <li>
                                        <div className="comment-content">
                                          <div className="comment-header">
                                            <h5 className="author-name">
                                              {user_name}
                                            </h5>
                                            <span className="post-on">
                                              {created_at}
                                            </span>
                                            <div className="rating-wrap">
                                              <div
                                                className=""
                                                title={`Rated ${starRating} sao trên 5 sao tối đa`}
                                              >
                                                <span className="w-90">
                                                  {renderStarRating(starRating)}
                                                </span>
                                              </div>
                                            </div>
                                          </div>
                                          <p>{content}</p>
                                        </div>
                                      </li>
                                      {admin_answer && ( // Check if admin has responded
                                        <li>
                                          <ol>
                                            <li>
                                              <div className="comment-content">
                                                <div className="comment-header">
                                                  <h5 className="author-name">
                                                    Admin
                                                  </h5>
                                                </div>
                                                <p>{admin_answer}</p>
                                              </div>
                                            </li>
                                          </ol>
                                        </li>
                                      )}
                                    </ol>
                                  </>
                                );
                              }
                            )}
                          </div>
                          <div className="comment-form-wrap">
                            <h3 className="comment-title">Đánh giá của bạn</h3>
                            {isLoggedIn ? (
                              purchase_history &&
                              purchase_history.length > 0 &&
                              purchase_history[0].purchase_status === 5 ? (
                                <form className="comment-form">
                                  <div className="full-width rate-wrap">
                                    <label>Chọn sao</label>
                                    <div className="">
                                      <span>
                                        <Rate
                                          onChange={handleStarRatingChange}
                                          value={selectedStar}
                                        />
                                      </span>
                                    </div>
                                  </div>
                                  <p>
                                    <input
                                      type="text"
                                      name="user_name"
                                      placeholder="Tên của bạn"
                                      value={ratingData.user_name}
                                      onChange={handleUserNameChange}
                                    />
                                  </p>
                                  <p>
                                    <textarea
                                      rows={6}
                                      placeholder="Đánh giá"
                                      value={ratingData.content}
                                      onChange={handleContentChange}
                                    ></textarea>
                                  </p>
                                  <p>
                                    <button
                                      className="btn-continue"
                                      type="button"
                                      onClick={handleSubmitRating}
                                    >
                                      Gửi đánh giá
                                    </button>
                                  </p>
                                </form>
                              ) : (
                                <p style={{ color: "red" }}>
                                  Bạn chỉ có thể đánh giá sau khi hoàn thành
                                  tour.
                                </p>
                              )
                            ) : (
                              <p style={{ color: "red" }}>
                                Vui lòng đăng nhập và đi tour để đánh giá.
                              </p>
                            )}
                          </div>
                        </div>
                      </div>
                      <div
                        className="tab-pane"
                        id="map"
                        role="tabpanel"
                        aria-labelledby="map-tab"
                      >
                        <div className="map-area">
                          <iframe
                            ref={iframeRef}
                            width="600"
                            height="450"
                            style={{ border: 0 }}
                            loading="lazy"
                            referrerPolicy="no-referrer-when-downgrade"
                          ></iframe>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div className="col-lg-5">
                <div className="sidebar">
                  <div className="package-price">
                    <h5 className="price rounded-2">
                      <span> {formattedTourPrice} </span>
                    </h5>
                    <div className="start-wrap">
                      <div className="rating-start" title="Rated 5 out of 5">
                        <span className="w-60"></span>
                      </div>
                    </div>
                  </div>
                  <div className="widget-bg booking-form-wrap">
                    <h4 className="bg-title">Thông tin đặt tour</h4>

                    <form className="booking-form">
                      <div className="row">
                        <div className="col-sm-7">
                          <label htmlFor="" className="h6">
                            Người lớn(90cm trở lên)
                          </label>
                          <div className="price">{formattedTourPrice}</div>
                          <label htmlFor="" className="h6">
                            Trẻ em dưới 90cm
                          </label>
                          <div className="price">{formattedTourChildPrice}</div>
                        </div>

                        <div className="col-sm-5 mt-2">
                          {/* <a className="minus-btn mr-2" href="#">
                            <i className="fa fa-minus"></i>
                          </a> */}
                          <input
                            className="quantity"
                            onChange={handleProductNumberChange}
                            type="number"
                            value={productNumber}
                          />
                          <br />
                          <input
                            className="quantity"
                            style={{ marginTop: "36px" }}
                            type="number"
                            // min={0}
                            onChange={handleProductChildNumberChange}
                            value={productChildNumber}
                          />
                          {/* <a className="plus-btn ml-2" href="#">
                            <i className="fa fa-plus"></i>
                          </a> */}
                        </div>

                        <div className="col-sm-5 mt-2">
                          <label htmlFor="" className="h6">
                            Chọn ngày đi
                          </label>

                          <DatePicker
                            onChange={onChange}
                            disabledDate={disabledDate}
                          />
                        </div>

                        <div className="col-sm-12 mt-2">
                          <label htmlFor="" className="h5 d-flex">
                            <p className="mr-2">Tổng giá :</p>{" "}
                            <p className="price">
                              {" "}
                              {price + childPrice > 0
                                ? formattedResultPrice
                                : formattedTourPrice}
                            </p>
                          </label>
                        </div>
                        <div className="col-sm-12">
                          {isDateSelected ? (
                            <div className="form-group submit-btn">
                              <Link
                                to={`/check_order_information/${id}`}
                                state={{
                                  tourData,
                                  productNumber,
                                  productChildNumber,
                                  childPrice,
                                  price,
                                  formattedResultPrice,
                                  dateTour,
                                  tourName,
                                  tourLocation,
                                  tourPrice,
                                  tourChildPrice,
                                  tourId,
                                }}
                              >
                                <input
                                  type="submit"
                                  name="submit"
                                  value="Đặt tour"
                                  disabled={!isDateSelected}
                                />
                              </Link>
                            </div>
                          ) : (
                            <p style={{ color: "red" }}>
                              Vui lòng chọn ngày đi để tiếp tục.
                            </p>
                          )}
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <h2>Tour tương tự </h2>

              <div className="row">
                {tourSameCategory?.map(
                  ({
                    id,
                    name,
                    details,
                    main_img,
                    view_count,
                    adult_price,
                  }: Tour) => {
                    return (
                      <div className="col-lg-4 col-md-6" key={id}>
                        <div className="package-wrap">
                          <figure className="feature-image">
                            <Link to={`/tours/${id}`}>
                              <img className="w-full" src={main_img} alt="" />
                            </Link>
                          </figure>
                          <div className="package-price">
                            <h6>
                              <span>VND {adult_price} </span> / mỗi người
                            </h6>
                          </div>
                          <div className="package-content-wrap">
                            {/* <div className="package-meta text-center"></div> */}
                            <div className="package-content">
                              <h3 className="margin-top-12">
                                <Link className="mt-12" to={`/tours/${id}`}>
                                  {name}
                                </Link>
                              </h3>
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
                              <p>{details}</p>
                              <div className="btn-wrap">
                                <a href="#" className="button-text width-6">
                                  Đặt ngay
                                  <i className="fas fa-arrow-right"></i>
                                </a>
                                <a href="#" className="button-text width-6">
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
        </div>
      </main>
    </>
  );
};

export default TourDetail;
