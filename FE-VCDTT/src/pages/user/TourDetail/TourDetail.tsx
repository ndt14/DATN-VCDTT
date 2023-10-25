import { Link, useLocation, useParams } from "react-router-dom";
import { useEffect, useState } from "react";
import { useGetTourByIdQuery } from "../../../api/tours";
import Loader from "../../../componenets/User/Loader";
import "./TourDetail.css";
import { DatePicker } from "antd";
import type { DatePickerProps } from "antd";
import moment from "moment";
import TinySlider from "tiny-slider-react";
import "tiny-slider/dist/tiny-slider.css";
import { Tour } from "../../../interfaces/Tour";

// const [selectedDate, setSelectedDate] = useState<dayjs.Dayjs | null>(null);
// Initialize with null or a default date if needed

const TourDetail = () => {
  //validate

  //

  const [dateTour, setDateTour] = useState<string>(" ");
  const [isDateSelected, setIsDateSelected] = useState(false);

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
  const tourName = tourData?.data?.tour.name;
  const tourLocation = tourData?.data?.tour.name;
  const tourPrice = tourData?.data?.tour.adult_price;
  const tourChildPrice = tourData?.data?.tour.child_price;
  // console.log(tourChildPrice);

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

  // console.log(formattedTourPrice+ formattedTourChildPrice);

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
  console.log(tourSameCategory);

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
                        <div className="summary-review">
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
                        </div>
                        {/* <!-- review comment html --> */}
                        <div className="comment-area">
                          <h3 className="comment-title">3 Reviews</h3>
                          <div className="comment-area-inner">
                            <ol>
                              <li>
                                <figure className="comment-thumb">
                                  <img
                                    src="../../../../assets/images/img20.jpg"
                                    alt=""
                                  />
                                </figure>
                                <div className="comment-content">
                                  <div className="comment-header">
                                    <h5 className="author-name">Tom Sawyer</h5>
                                    <span className="post-on">
                                      Jana 10 2020
                                    </span>
                                    <div className="rating-wrap">
                                      <div
                                        className="rating-start"
                                        title="Rated 5 out of 5"
                                      >
                                        <span className="w-90"></span>
                                      </div>
                                    </div>
                                  </div>
                                  <p>
                                    Officia amet posuere voluptates, mollit
                                    montes eaque accusamus laboriosam quisque
                                    cupidatat dolor pariatur, pariatur auctor.
                                  </p>
                                  <a href="#" className="reply">
                                    <i className="fas fa-reply"></i>Reply
                                  </a>
                                </div>
                              </li>
                              <li>
                                <ol>
                                  <li>
                                    <figure className="comment-thumb">
                                      <img
                                        src="../../../../assets/images/img21.jpg"
                                        alt=""
                                      />
                                    </figure>
                                    <div className="comment-content">
                                      <div className="comment-header">
                                        <h5 className="author-name">
                                          John Doe
                                        </h5>
                                        <span className="post-on">
                                          Jana 10 2020
                                        </span>
                                        <div className="rating-wrap">
                                          <div
                                            className="rating-start"
                                            title="Rated 5 out of 5"
                                          >
                                            <span className="w-90"></span>
                                          </div>
                                        </div>
                                      </div>
                                      <p>
                                        Officia amet posuere voluptates, mollit
                                        montes eaque accusamus laboriosam
                                        quisque cupidatat dolor pariatur,
                                        pariatur auctor.
                                      </p>
                                      <a href="#" className="reply">
                                        <i className="fas fa-reply"></i>Reply
                                      </a>
                                    </div>
                                  </li>
                                </ol>
                              </li>
                            </ol>
                            <ol>
                              <li>
                                <figure className="comment-thumb">
                                  <img
                                    src="../../../../assets/images/img22.jpg"
                                    alt=""
                                  />
                                </figure>
                                <div className="comment-content">
                                  <div className="comment-header">
                                    <h5 className="author-name">Jaan Smith</h5>
                                    <span className="post-on">
                                      Jana 10 2020
                                    </span>
                                    <div className="rating-wrap">
                                      <div
                                        className="rating-start"
                                        title="Rated 5 out of 5"
                                      >
                                        <span></span>
                                      </div>
                                    </div>
                                  </div>
                                  <p>
                                    Officia amet posuere voluptates, mollit
                                    montes eaque accusamus laboriosam quisque
                                    cupidatat dolor pariatur, pariatur auctor.
                                  </p>
                                  <a href="#" className="reply">
                                    <i className="fas fa-reply"></i>Reply
                                  </a>
                                </div>
                              </li>
                            </ol>
                          </div>
                          <div className="comment-form-wrap">
                            <h3 className="comment-title">Leave a Review</h3>
                            <form className="comment-form">
                              <div className="full-width rate-wrap">
                                <label>Your rating</label>
                                <div className="procduct-rate">
                                  <span></span>
                                </div>
                              </div>
                              <p>
                                <input
                                  type="text"
                                  name="name"
                                  placeholder="Name"
                                />
                              </p>
                              <p>
                                <input
                                  type="text"
                                  name="name"
                                  placeholder="Last name"
                                />
                              </p>
                              <p>
                                <input
                                  type="email"
                                  name="email"
                                  placeholder="Email"
                                />
                              </p>
                              <p>
                                <input
                                  type="text"
                                  name="subject"
                                  placeholder="Subject"
                                />
                              </p>
                              <p>
                                <textarea
                                  rows={6}
                                  placeholder="Your review"
                                ></textarea>
                              </p>
                              <p>
                                <input
                                  type="submit"
                                  name="submit"
                                  value="Submit"
                                />
                              </p>
                            </form>
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
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.0877378831387!2d105.77566300940596!3d21.069157686311605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3134552c4daa2e41%3A0xc52e6ea7f463d8a0!2zNDk1IMSQLiBD4buVIE5odeG6vywgQ-G7lSBOaHXhur8sIFThu6sgTGnDqm0sIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1695805354232!5m2!1svi!2s"
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
                                  Thêm vào yêu thíc
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
