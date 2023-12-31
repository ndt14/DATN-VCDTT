import "./TourSearch.css";
// import { useState } from "react";
import { useParams } from "react-router-dom";
import { useGetCategoryByIdQuery } from "../../../api/category";
const TourSearch = () => {
  const { id } = useParams<{ id: string }>();
  const { data: cateData } = useGetCategoryByIdQuery(id || "");
  console.log(cateData);

  // const [showGridSearch, setShowGridSearch] = useState(false);
  // const [showListSearch, setShowListSearch] = useState(true);
  // const [isButtonListClicked, setIsButtonListClicked] = useState(true);
  // const [isButtonGridClicked, setIsButtonGridClicked] = useState(false);
 
  // //

  // const [sliderValues, setSliderValues] = useState([1000000, 20000000]);



  const titleElement = document.querySelector("title");
  if (titleElement) {
    titleElement.innerText = "Tìm kiếm tour";
  }

  return (
    <>
    <h1></h1>
    </>
    // <div>
    //   <section className="inner-banner-wrap">
    //     <div
    //       className="inner-baner-container"
    //       style={{
    //         backgroundImage: `url(../../../../assets/images/bg/bg1.jpg)`,
    //       }}
    //     >
    //       <div className="container">
    //         <div className="inner-banner-content">
    //           <h1 className="inner-title">Tìm kiếm tour</h1>
    //         </div>
    //       </div>
    //     </div>
    //     <div className="inner-shape"></div>
    //   </section>
    //   <section
    //     className="breadcrumb-main pb-20 pt-14"
    //     style={{ backgroundImage: `url(images/bg/bg1.jpg)` }}
    //   >
    //     <div
    //       className="section-shape section-shape1 top-inherit bottom-0"
    //       style={{ backgroundImage: `url(assets/images/bg/bg1.jpg)` }}
    //     ></div>
    //     <div className="breadcrumb-outer">
    //       <div className="container">
    //         <div className="breadcrumb-content text-center"></div>
    //       </div>
    //     </div>
    //     <div className="dot-overlay"></div>
    //   </section>
    //   <section className="trending pt-6 pb-0 bg-lgrey">
    //     <div className="container">
    //       <div className="row flex-row-reverse">
    //         <div className="col-lg-8">
    //           <div className="list-results d-flex align-items-center justify-content-between">
    //             <div className="list-results-sort w-50">
    //               <form className="">
    //                 <div className="d-flex" style={{ height: "48px" }}>
    //                   <input
    //                     className="form-control w-75"
    //                     style={{ height: "48px" }}
    //                     type="text"
    //                     placeholder="Tìm kiếm tour ..."
    //                   />
    //                   <button className="w-25 border-0 bg-primary text-white">
    //                     Tìm kiếm
    //                   </button>
    //                 </div>
    //               </form>
    //             </div>
    //             <div className="click-menu d-flex align-items-center justify-content-between">
    //               <div className="change-list f-active me-2">
    //                 {/* List button */}
    //                 <button
    //                   className="border-0 text-white rounded"
    //                   style={{
    //                     backgroundColor: buttonColor2,
    //                     width: "30px",
    //                     height: "30px",
    //                   }}
    //                   onClick={handleListSearch}
    //                 >
    //                   <i className="fa fa-bars  border-0 py-1"></i>
    //                 </button>
    //               </div>
    //               <div className="change-grid me-2">
    //                 <button
    //                   className="border-0 text-white rounded"
    //                   style={{
    //                     backgroundColor: buttonColor,
    //                     width: "30px",
    //                     height: "30px",
    //                   }}
    //                   onClick={handleGridSearch}
    //                 >
    //                   <i className="fa fa-th  py-1"></i>
    //                 </button>
    //               </div>
    //               <div className="sortby d-flex align-items-center justify-content-between ml-2">
    //                 <select className="niceSelect">
    //                   <option value="1">Sắp xếp theo</option>
    //                   <option value="2">Tour mới nhất</option>
    //                   <option value="3">Giá từ thấp đến cao</option>
    //                   <option value="4">Giá từ cao đến thấp</option>
    //                 </select>
    //               </div>
    //             </div>
    //           </div>

    //           <div>
    //             {/*  */}
    //             {showListSearch && (
    //               <div>
    //                 <Loader />
    //                 {/* <h4 className="my-3">Tìm thấy 2 tour</h4> */}
    //                 <div
    //                   id="tourList"
    //                   className="destination-list accordion-collapse collapse show"
    //                   aria-labelledby="buttonList"
    //                   data-bs-parent="#tourSearch"
    //                 >
    //                   <div className="accordion-body">
    //                     {cateData?.data.toursByCate.map(
    //                       ({
    //                         id,
    //                         name,
    //                         details,
    //                         main_img,
    //                         view_count,
    //                         adult_price,
    //                       }: Tour) => {
    //                         const formattedTourPrice = new Intl.NumberFormat(
    //                           "vi-VN",
    //                           {
    //                             style: "currency",
    //                             currency: "VND",
    //                           }
    //                         ).format(adult_price);
    //                         return (
    //                           <>
    //                             <div
    //                               className="trend-full bg-white rounded box-shadow overflow-hidden p-4 mb-4 border"
    //                               key={id}
    //                             >
    //                               <div className="row">
    //                                 <div className="col-lg-4 col-md-3">
    //                                   <div className="trend-item2 rounded">
    //                                     <a href="tour-single.html">
    //                                       <img
    //                                         className="w-full"
    //                                         src={main_img}
    //                                         alt=""
    //                                       />
    //                                     </a>
    //                                     <div className="color-overlay"></div>
    //                                   </div>
    //                                 </div>
    //                                 <div className="col-lg-5 col-md-6">
    //                                   <div className="trend-content position-relative text-md-start text-center">
    //                                     <h3 className="mb-1">
    //                                       <Link to={`/tours/${id}`}>
    //                                         {name}
    //                                       </Link>
    //                                     </h3>
    //                                     <h6 className="theme mb-0 my-2">
    //                                       <i className="icon-location-pin"></i>{" "}
    //                                       <span className="text-primary mt-2 fs-4">
    //                                         Greece
    //                                       </span>
    //                                     </h6>
    //                                   </div>
    //                                 </div>
    //                                 <div className="col-lg-3 col-md-3">
    //                                   <div className="trend-content text-md-end text-center">
    //                                     <div className="rating">
    //                                       <span className="fa fa-star checked"></span>
    //                                       <span className="fa fa-star checked"></span>
    //                                       <span className="fa fa-star checked"></span>
    //                                       <span className="fa fa-star checked"></span>
    //                                       <span className="fa fa-star checked"></span>
    //                                     </div>
    //                                     <small>{view_count} Reviews</small>
    //                                     <div className="trend-price my-2">
    //                                       <span className="mb-0">Từ</span>
    //                                       <h3 className="mb-0">
    //                                         {formattedTourPrice}
    //                                       </h3>
    //                                       <small>mỗi người lớn</small>
    //                                     </div>
    //                                     <a
    //                                       href="tour-single.html"
    //                                       className="nir-btn"
    //                                     >
    //                                       View Detail
    //                                     </a>
    //                                   </div>
    //                                 </div>
    //                               </div>
    //                             </div>
    //                           </>
    //                         );
    //                       }
    //                     )}
    //                   </div>
    //                 </div>
    //               </div>
    //             )}
    //             {/*  */}
    //             {showGridSearch && (
    //               <div>
    //                 <Loader />
    //                 <h4 className="my-3">Tìm thấy 2 tour</h4>
    //                 <div className="row my-3 destination-list accordion-collapse collapse show">
    //                   {cateData?.data.toursByCate.map(
    //                     ({
    //                       id,
    //                       name,
    //                       details,
    //                       main_img,
    //                       view_count,
    //                       adult_price,
    //                     }: Tour) => {
    //                       const formattedTourPrice = new Intl.NumberFormat(
    //                         "vi-VN",
    //                         {
    //                           style: "currency",
    //                           currency: "VND",
    //                         }
    //                       ).format(adult_price);
    //                       return (
    //                         <>
    //                           <div className="col-lg-6 col-md-6" key={id}>
    //                             <div className="package-wrap">
    //                               <figure className="feature-image">
    //                                 <Link to="tours/1">
    //                                   <img
    //                                     className="w-full"
    //                                     src={main_img}
    //                                     alt=""
    //                                   />
    //                                 </Link>
    //                               </figure>
    //                               <div className="package-price">
    //                                 <h6>
    //                                   <span>{formattedTourPrice}</span> / mỗi
    //                                   người
    //                                 </h6>
    //                               </div>
    //                               <div className="package-content-wrap">
    //                                 {/* <div className="package-meta text-center"></div> */}
    //                                 <div className="package-content">
    //                                   <h3 className="margin-top-12">
    //                                     <Link
    //                                       className="mt-12"
    //                                       to={`tours/${id}`}
    //                                     >
    //                                       {name}
    //                                     </Link>
    //                                   </h3>
    //                                   <div className="review-area">
    //                                     <span className="review-text">
    //                                       ({view_count} reviews)
    //                                     </span>
    //                                     <div
    //                                       className="rating-start"
    //                                       title="Rated 5 out of 5"
    //                                     >
    //                                       <span className="w-3/5"></span>
    //                                     </div>
    //                                   </div>
    //                                   <p>{details}</p>
    //                                   <div className="btn-wrap">
    //                                     <a
    //                                       href="#"
    //                                       className="button-text width-6"
    //                                     >
    //                                       Đặt ngay
    //                                       <i className="fas fa-arrow-right"></i>
    //                                     </a>
    //                                     <a
    //                                       href="#"
    //                                       className="button-text width-6"
    //                                     >
    //                                       Thêm vào yêu thích
    //                                       <i className="far fa-heart"></i>
    //                                     </a>
    //                                   </div>
    //                                 </div>
    //                               </div>
    //                             </div>
    //                           </div>
    //                         </>
    //                       );
    //                     }
    //                   )}
    //                 </div>
    //               </div>
    //             )}
    //           </div>
    //           {/*  */}
    //         </div>
    //         <div className="col-lg-4 pe-lg-4">
    //           <div className="sidebar-sticky">
    //             <div className="list-sidebar">
    //               <div className="sidebar-item mb-4">
    //                 <h3>Danh mục tour</h3>
    //                 <ul className="sidebar-category1">
    //                   <li>
    //                     <input type="checkbox" checked /> Miền Bắc{" "}
    //                     <span className="float-end">92</span>
    //                   </li>
    //                   <li>
    //                     <input type="checkbox" /> Miền Nam{" "}
    //                     <span className="float-end">22</span>
    //                   </li>
    //                   <li>
    //                     <input type="checkbox" /> Miền Trung{" "}
    //                     <span className="float-end">35</span>
    //                   </li>
    //                   <li>
    //                     <input type="checkbox" /> Vùng núi{" "}
    //                     <span className="float-end">41</span>
    //                   </li>
    //                   <li>
    //                     <input type="checkbox" /> Vùng biển{" "}
    //                     <span className="float-end">11</span>
    //                   </li>
    //                 </ul>
    //               </div>
    //               <div className="sidebar-item mb-4">
    //                 <h3>Độ dài tour</h3>
    //                 <ul className="sidebar-category1">
    //                   <li>
    //                     <input type="checkbox" checked /> Dưới 1 ngày{" "}
    //                     <span className="float-end">92</span>
    //                   </li>
    //                   <li>
    //                     <input type="checkbox" /> Từ 1 đến 2 ngày{" "}
    //                     <span className="float-end">22</span>
    //                   </li>
    //                   <li>
    //                     <input type="checkbox" /> Từ 2 đến 4 ngày{" "}
    //                     <span className="float-end">35</span>
    //                   </li>
    //                   <li>
    //                     <input type="checkbox" /> Từ 4 đến 7 ngày{" "}
    //                     <span className="float-end">41</span>
    //                   </li>
    //                   <li>
    //                     <input type="checkbox" /> Trên 1 tuần{" "}
    //                     <span className="float-end">11</span>
    //                   </li>
    //                   <li>
    //                     <input type="checkbox" /> Trên 1 tháng{" "}
    //                     <span className="float-end">61</span>
    //                   </li>
    //                 </ul>
    //               </div>
    //               <div className="sidebar-item mb-4">
    //                 <h3>Khoảng giá</h3>
    //                 <div>
    //                   <Range
    //                     step={100000}
    //                     min={1000000}
    //                     max={20000000}
    //                     values={sliderValues}
    //                     onChange={handleSliderChange}
    //                     renderTrack={({ props, children }) => (
    //                       <div
    //                         {...props}
    //                         style={{
    //                           ...props.style,
    //                           height: "6px",
    //                           backgroundColor: "#ddd",
    //                           borderRadius: "3px",
    //                         }}
    //                       >
    //                         {children}
    //                       </div>
    //                     )}
    //                     renderThumb={({ props }) => (
    //                       <div
    //                         {...props}
    //                         style={{
    //                           ...props.style,
    //                           height: "20px",
    //                           width: "20px",
    //                           backgroundColor: "#888",
    //                           borderRadius: "50%",
    //                           outline: "none",
    //                           display: "flex",
    //                           justifyContent: "center",
    //                           alignItems: "center",
    //                         }}
    //                       >
    //                         <div
    //                           style={{
    //                             height: "6px",
    //                             width: "6px",
    //                             backgroundColor: "#fff",
    //                             borderRadius: "50%",
    //                           }}
    //                         />
    //                       </div>
    //                     )}
    //                   />
    //                   <div className="d-flex justify-content-between mt-2">
    //                     <p> {sliderValues[0]} VNĐ</p>
    //                     <p>{sliderValues[1]} VNĐ</p>
    //                   </div>
    //                 </div>
    //               </div>
    //             </div>
    //           </div>
    //         </div>
    //       </div>
    //     </div>
    //   </section>
    // </div>
  );
};

export default TourSearch;
