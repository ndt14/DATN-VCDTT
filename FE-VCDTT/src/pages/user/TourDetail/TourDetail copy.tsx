import { Link, useLocation, useNavigate, useParams } from "react-router-dom";
import { useEffect, useRef, useState } from "react";
import { useGetTourByIdQuery } from "../../../api/tours";
import Loader from "../../../componenets/User/Loader";
import "./TourDetail.css";
import { DatePicker, Rate, Skeleton } from "antd";
import type { DatePickerProps } from "antd";
import moment from "moment";
import TinySlider from "tiny-slider-react";
import "tiny-slider/dist/tiny-slider.css";
import { Tour } from "../../../interfaces/Tour";
import { Rating } from "../../../interfaces/Rating";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faStar } from "@fortawesome/free-solid-svg-icons";
import {
  useAddRatingMutation,
  useGetRatingByIdQuery,
} from "../../../api/rating";
import { AiFillEye } from "react-icons/ai";
import { useGetUserByIdQuery } from "../../../api/user";
import { useGetBillsWithUserIDQuery } from "../../../api/bill";
import ReactPaginate from "react-paginate";

const TourDetail = () => {
  const [dateTour, setDateTour] = useState<string>(" ");
  const [isDateSelected, setIsDateSelected] = useState(false);
  const [idArray, setIdArray] = useState<number[]>([]);

  const [addRating] = useAddRatingMutation();
  const { id: idRating } = useParams<{ id: string }>();
  const { data: dataRating } = useGetRatingByIdQuery(idRating | "");
  // console.log(dataRating);

  const user = JSON.parse(localStorage.getItem("user")) || "";
  // console.log(user);

  const userId = user?.id;
  const { data: TourHistoryData } = useGetBillsWithUserIDQuery(userId | "");
  // console.log(TourHistoryData);

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
  const { data: tourData, isLoading } = useGetTourByIdQuery(id || "");
  console.log(tourData);
  const [tour, setTour] = useState(tourData);

  const tourId = parseInt(id);
  // console.log(typeof tourId);
  const main_img = tourData?.data?.tour.main_img;
  const tourName = tourData?.data?.tour.name;
  const tourLocation = tourData?.data?.tour.name;
  const tourPrice = tourData?.data?.tour.adult_price;
  const tourChildPrice = tourData?.data?.tour.child_price;
  const exact_location = tourData?.data?.tour.exact_location;
  const tourDuration = tourData?.data?.tour.duration;
  const imageGallery = tourData?.data?.images;
  const tourLimit = tourData?.data?.tour.tourist_count;
  console.log(tourLimit);

  console.log(imageGallery);

  console.log(tourDuration);

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
  const [childPrice, setChildPrice] = useState(0);

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

  //đánh giá
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
  // console.log(selectedStar);

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

  const handleSubmitRating = async () => {
    if (ratingData.star > 0 && ratingData.user_name && ratingData.content) {
      try {
        const response = await addRating(ratingData);

        // Handle success, e.g., show a success message or update UI
        console.log("Đánh giá thành công", response);
        alert("Đánh giá thành công");

        // After a successful rating submission, update the component's state
        const newRating = {
          id: response.data.id, // Use the actual ID received from the server
          user_name: ratingData.user_name,
          content: ratingData.content,
          star: ratingData.star,
          created_at: new Date().toLocaleString(), // You can format the date accordingly
        };

        // Create a copy of the existing ratings and add the new rating
        const updatedRatings = [...tourData.data.listRatings, newRating];

        // Update the component's state with the new ratings
        setTour({
          ...tourData,
          data: { ...tourData.data, listRatings: updatedRatings },
        });

        // Reset the rating form or clear the inputs
        setRatingData({
          star: 5, // Set the default rating or any other value you prefer
          user_id: userId,
          user_name: userName,
          content: "",
          tour_id: id, // Assuming 'id' is the tour ID
        });
      } catch (error) {
        // Handle error, e.g., show an error message
        console.error("Đánh giá thất bại", error);
      }
    } else {
      // Handle incomplete rating data, e.g., show an error message
      console.error("Please fill in all rating details");
    }
  };
  useEffect(() => {
    if (tourData) {
      setTour(tourData);
    }
  }, [tourData]);

  // console.log(tour);

  const purchase_history = TourHistoryData?.data?.purchase_history;
  if (purchase_history) {
    var foundPurchase = purchase_history.find(
      (purchase) => purchase.tour_id === Number(id)
    );

    // console.log(foundPurchase.purchase_status);

    if (foundPurchase) {
      // A matching purchase_history object was found
      console.log("Found purchase_history:", foundPurchase);
    } else {
      // No matching purchase_history object was found
      console.log("Purchase_history not found for id:", id);
    }
  } else {
    // Handle the case where purchase_history is undefined or empty
    console.log("Purchase_history is undefined or empty");
  }

  // Calculate the average rating from the list of ratings
  const calculateAverageRating = () => {
    let totalRating = 0;
    if (tourData?.data?.listRatings) {
      tourData.data.listRatings.forEach((rating) => {
        totalRating += parseInt(rating.star);
      });
      return totalRating / tourData.data.listRatings.length;
    }
    return 0; // Default to 0 if there are no ratings
  };

  const averageRating = calculateAverageRating();
  //phân trang đánh giá
  const [currentPage, setCurrentPage] = useState<number>(0);
  const handlePageChange = (selectedPage: { selected: number }) => {
    setCurrentPage(selectedPage.selected);
  };
  const itemsPerPage = 3;
  const pageCount = Math.ceil(tour?.data.listRatings.length / itemsPerPage);
  const currentData: Rating[] = (tour?.data.listRatings.slice(
    currentPage * itemsPerPage,
    (currentPage + 1) * itemsPerPage
  ) || []) as Rating[];
  //end đánh giá
  const isLoggedIn = user != "";
  //map
  const iframeRef = useRef(null);

  useEffect(() => {
    if (iframeRef.current) {
      const iframeSrc = `https://maps.google.com/maps?width=600&height=400&hl=en&q=${encodeURIComponent(
        exact_location
      )}&t=&z=14&ie=UTF8&iwloc=B&output=embed`;
      iframeRef.current.src = iframeSrc;
    }
  }, [exact_location]);
  //end map

  //SEO

  const titleElement = document.querySelector("title");
  if (titleElement) {
    titleElement.innerText = tourData?.data?.tour.name + " - " + "VCDTT";
  }
  return (
    <>
      {/* <Loader /> */}
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
                {isLoading ? (
                <Skeleton active />
              ) : (
                  <h2>{tourData?.data?.tour.name}</h2>
              )}
                  <div>
                   
                    <div
                      id="carousel-thumb"
                      className="carousel slide carousel-fade carousel-thumbnails"
                      data-ride="carousel"
                      data-interval="false"
                    >

                      <div className="carousel-inner" role="listbox">
                        <div className="carousel-item active">
                        {isLoading ? (
                            <Skeleton.Image active style={{ width: '800px', height: '400px',margin:'10px' }}/>

                            ) : (
                          <img
                            className="d-block img-tour-detail"
                            src={tourData?.data?.tour.main_img}
                            alt="First slide"
                          />
                            )}
                        </div>
                        {/* <div className="carousel-item">
                          <img
                            className="d-block w-100"
                            src="https://i.ibb.co/9p3Cnk9/slider-2.jpg"
                            alt="Second slide"
                          />
                        </div>
                        <div className="carousel-item">
                          <img
                            className="d-block w-100"
                            src="https://i.ibb.co/sC4SgqP/slider-3.jpg"
                            alt="Third slide"
                          />
                        </div> */}
                           
                        {imageGallery?.map(({ url }) => {
                          return (
                            
                            <div className="carousel-item ">
                              <img
                                className="d-block img-tour-detail"
                                src={url}
                                alt="First slide"
                              />
                            </div>
                          );
                        })}
                            
                      </div>
                          
                      <a
                        className="carousel-control-prev"
                        href="#carousel-thumb"
                        role="button"
                        data-slide="prev"
                      >
                        <span
                          className="carousel-control-prev-icon"
                          aria-hidden="true"
                        ></span>
                        <span className="sr-only">Previous</span>
                      </a>
                      <a
                        className="carousel-control-next"
                        href="#carousel-thumb"
                        role="button"
                        data-slide="next"
                      >
                        <span
                          className="carousel-control-next-icon"
                          aria-hidden="true"
                        ></span>
                        <span className="sr-only">Next</span>
                      </a>
                      {isLoading ? (
                         <Skeleton.Image active/>

                            ) : (
                      <ul className="carousel-indicator">
                        <li
                          data-target="#carousel-thumb"
                          data-slide-to="0"
                          className=" mx-1"
                          style={{ width: "80px" }}
                        >
                          <img
                            className="d-block img-fluid img-tour-detail-small"
                            src={tourData?.data?.tour.main_img}
                          />
                        </li>
                        {/* <li
                          data-target="#carousel-thumb"
                          data-slide-to="1"
                          style={{ width: "80px" }}
                          className="mx-1"
                        >
                          <img
                            className="d-block w-100 img-fluid"
                            src="https://i.ibb.co/9p3Cnk9/slider-2.jpg"
                          />
                        </li>
                        <li
                          data-target="#carousel-thumb"
                          data-slide-to="2"
                          style={{ width: "80px" }}
                          className="mx-1"
                        >
                          <img
                            className="d-block w-100 img-fluid"
                            src="https://i.ibb.co/sC4SgqP/slider-3.jpg"
                          />
                        </li> */}
                        
                        {imageGallery?.map((image, index) => {
                          const { url } = image;
                          return (
                            <li
                              data-target="#carousel-thumb"
                              data-slide-to={index + 1}
                              className="mx-1"
                              style={{ width: "80px" }}
                              key={index}
                            >
                              <img
                                className="d-block img-fluid img-tour-detail-small"
                                src={url}
                                alt={`Image ${index}`}
                              />
                            </li>
                          );
                        })}
                      </ul>
                            )}
                    </div>
                  </div>

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
                          <div
                            className="mt-3"
                            dangerouslySetInnerHTML={{
                              __html: tourData?.data?.tour.details,
                            }}
                          ></div>
                          {/* {tourData?.data?.tour.details} */}
                        </div>
                      </div>
                      <div
                        className="tab-pane"
                        id="program"
                        role="tabpanel"
                        aria-labelledby="program-tab"
                      >
                        {/* lịch trình */}
                        <div className="mt-3">
                          {tourData?.data?.tour.pathway}
                        </div>
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
                            Có {tour?.data.listRatings.length} đánh giá
                          </h3>
                          <div className="comment-area-inner">
                            {currentData.map(
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
                                            <h5 className="author-name strong">
                                              {user_name}
                                            </h5>
                                            <span className="post-on">
                                              {moment(created_at).format(
                                                "DD/MM/YYYY"
                                              )}
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
                                          <p
                                            className=""
                                            dangerouslySetInnerHTML={{
                                              __html: content,
                                            }}
                                          ></p>
                                        </div>
                                      </li>
                                      {admin_answer && ( // Check if admin has responded
                                        <li>
                                          <ol>
                                            <li>
                                              <div className="comment-content">
                                                <div className="comment-header">
                                                  <h5 className="author-name strong">
                                                    Admin
                                                  </h5>
                                                </div>
                                                <p
                                                  className=""
                                                  dangerouslySetInnerHTML={{
                                                    __html: admin_answer,
                                                  }}
                                                ></p>
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
                            <ReactPaginate
                              previousLabel={"<-"}
                              nextLabel={"->"}
                              breakLabel={"..."}
                              pageCount={pageCount}
                              onPageChange={handlePageChange}
                              containerClassName={"pagination"}
                              activeClassName={"active"}
                            />
                          </div>
                          <div className="comment-form-wrap">
                            <h3 className="comment-title">Đánh giá của bạn</h3>
                            {isLoggedIn ? (
                              tour === tourData &&
                              foundPurchase?.purchase_status == 3 ? (
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
                {isLoading ? (
                <Skeleton active />
              ) : (
                  <div className="package-price">
                    <h5 className="price rounded-2">
                      
                      <span> {formattedTourPrice} </span>
                    </h5>
                    <div className="start-wrap">
                      <div
                        className=""
                        title={`Rated ${averageRating} out of 5`}
                      >
                        <span className="w-90">
                          <Rate allowHalf disabled value={averageRating} />
                        </span>
                      </div>
                    </div>
                  </div>
              )}
               {isLoading ? (
                <Skeleton active />
              ) : (
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
                            className="quantity-form"
                            onChange={handleProductNumberChange}
                            type="number"
                            value={productNumber}
                          />
                          <br />
                          <input
                            className="quantity-form"
                            style={{
                              marginTop: "36px",
                            }}
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

                        <div className="col-sm-12">
                          {productNumber + productChildNumber > tourLimit ? (
                            <p style={{ color: "red" }} className="mt-2">
                              Số lượng vượt quá giới hạn tour. Nếu bạn thực sự
                              muốn đặt tour với số lượng lớn, hãy liên hệ trực
                              tiếp với chúng tôi
                            </p>
                          ) : (
                            <div></div>
                          )}
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
                                  exact_location,
                                  tourDuration,
                                  main_img,
                                }}
                              >
                                <button
                                  type="submit"
                                  name="submit"
                                  value="Đặt tour"
                                  disabled={
                                    productNumber + productChildNumber >
                                    tourLimit
                                  }
                                  className="btn-continue"
                                >
                                  Đặt tour
                                </button>
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
              )}
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
                    star,
                  }: Tour) => {
                    if (idArray.includes(id as number)) {
                      return (
                        <div className="col-lg-4 col-md-6" key={id}>
                          <div className="package-wrap">
                            <figure className="feature-image">
                              <Link to={`/tours/${id}`}>
                                <img
                                  className="w-full img-fixed"
                                  src={main_img}
                                  alt=""
                                />
                              </Link>
                            </figure>
                            <div className="package-price">
                              <h6 className="">
                                <span>
                                  {new Intl.NumberFormat("vi-VN", {
                                    style: "currency",
                                    currency: "VND",
                                  }).format(adult_price)}{" "}
                                  / người
                                </span>{" "}
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
                                    className=""
                                    dangerouslySetInnerHTML={{
                                      __html: details,
                                    }}
                                  ></span>
                                </div>

                                <div className="btn-wrap">
                                  <a href="#" className="button-text width-6">
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
                              <Link to={`/tours/${id}`}>
                                <img
                                  className="w-full img-fixed"
                                  src={main_img}
                                  alt=""
                                />
                              </Link>
                            </figure>
                            <div className="package-price">
                              <h6 className="">
                                <span>
                                  {new Intl.NumberFormat("vi-VN", {
                                    style: "currency",
                                    currency: "VND",
                                  }).format(adult_price)}{" "}
                                  / người
                                </span>{" "}
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
                                    className=""
                                    dangerouslySetInnerHTML={{
                                      __html: details,
                                    }}
                                  ></span>
                                </div>

                                <div className="btn-wrap">
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
