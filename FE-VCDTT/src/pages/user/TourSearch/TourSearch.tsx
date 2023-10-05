import React from "react";
// import "./TourSearch.css";
import { useState } from "react";

const TourSearch = () => {
  const [showGridSearch, setShowGridSearch] = useState(false);
  const [showListSearch, setShowListSearch] = useState(true);
  const [isButtonListClicked, setIsButtonListClicked] = useState(true);
  const [isButtonGridClicked, setIsButtonGridClicked] = useState(false);
  const buttonColor = isButtonGridClicked ? "#E06A69" : "gray";
  const buttonColor2 = isButtonListClicked ? "#E06A69" : "gray";

  const handleGridSearch = () => {
    setShowGridSearch(true);
    setShowListSearch(false);
    setIsButtonGridClicked(true);
    setIsButtonListClicked(false);
  };
  const handleListSearch = () => {
    setShowGridSearch(false);
    setShowListSearch(true);
    setIsButtonListClicked(true);
    setIsButtonGridClicked(false);
  };
  return (
    <div>
      <section
        className="breadcrumb-main pb-20 pt-14"
        style={{ backgroundImage: `url(images/bg/bg1.jpg)` }}
      >
        <div
          className="section-shape section-shape1 top-inherit bottom-0"
          style={{ backgroundImage: `url(images/bg/bg1.jpg)` }}
        ></div>
        <div className="breadcrumb-outer">
          <div className="container">
            <div className="breadcrumb-content text-center">
              <h1 className="mb-3">Tour List</h1>
              <nav aria-label="breadcrumb" className="d-block">
                <ul className="breadcrumb">
                  <li className="breadcrumb-item">
                    <a href="#">Home</a>
                  </li>
                  <li className="breadcrumb-item active" aria-current="page">
                    Tour Lists Rightside
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
        <div className="dot-overlay"></div>
      </section>
      <section className="trending pt-6 pb-0 bg-lgrey">
        <div className="container">
          <div className="row flex-row-reverse">
            <div className="col-lg-8">
              <div className="list-results d-flex align-items-center justify-content-between">
                <div className="list-results-sort">
                  <p className="m-0">Showing 1-5 of 80 results</p>
                </div>
                <div className="click-menu d-flex align-items-center justify-content-between">
                  <div className="change-list f-active me-2">
                    {/* List button */}
                    <button
                      className="border-0 text-white "
                      style={{ backgroundColor: buttonColor2 }}
                      onClick={handleListSearch}
                    >
                      <i className="fa fa-bars rounded border-0 py-1"></i>
                    </button>
                  </div>
                  <div className="change-grid me-2">
                    <button
                      className="border-0 text-white "
                      style={{ backgroundColor: buttonColor }}
                      onClick={handleGridSearch}
                    >
                      <i className="fa fa-th rounded  py-1"></i>
                    </button>
                  </div>
                  <div className="sortby d-flex align-items-center justify-content-between ml-2">
                    <select className="niceSelect">
                      <option value="1">Sort By</option>
                      <option value="2">Average rating</option>
                      <option value="3">Price: low to high</option>
                      <option value="4">Price: high to low</option>
                    </select>
                  </div>
                </div>
              </div>

              <div>
                {/*  */}
                {showListSearch && (
                  <div>
                    <div
                      id="tourList"
                      className="destination-list accordion-collapse collapse show"
                      aria-labelledby="buttonList"
                      data-bs-parent="#tourSearch"
                    >
                      <div className="accordion-body">
                        <div className="trend-full bg-white rounded box-shadow overflow-hidden p-4 mb-4">
                          <div className="row">
                            <div className="col-lg-4 col-md-3">
                              <div className="trend-item2 rounded">
                                <a href="tour-single.html"></a>
                                <div className="color-overlay"></div>
                              </div>
                            </div>
                            <div className="col-lg-5 col-md-6">
                              <div className="trend-content position-relative text-md-start text-center">
                                <small>6+ Hours | Full Day Tours</small>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">
                                    Leeds Castle, Cliffs Of Dover
                                  </a>
                                </h3>
                                <h6 className="theme mb-0">
                                  <i className="icon-location-pin"></i> Croatia
                                </h6>
                                <p className="mt-4 mb-0">
                                  Taking Safety Measures <br />
                                  <a href="#">
                                    <span className="theme">
                                      {" "}
                                      Free cancellation
                                    </span>
                                  </a>
                                </p>
                              </div>
                            </div>
                            <div className="col-lg-3 col-md-3">
                              <div className="trend-content text-md-end text-center">
                                <div className="rating">
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                </div>
                                <small>200 Reviews</small>
                                <div className="trend-price my-2">
                                  <span className="mb-0">From</span>
                                  <h3 className="mb-0">$125</h3>
                                  <small>Per Adult</small>
                                </div>
                                <a href="tour-single.html" className="nir-btn">
                                  View Detail
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div className="trend-full bg-white rounded box-shadow overflow-hidden p-4 mb-4">
                          <div className="row">
                            <div className="col-lg-4 col-md-3">
                              <div className="trend-item2 rounded">
                                <a href="tour-single.html"></a>
                                <div className="color-overlay"></div>
                              </div>
                            </div>
                            <div className="col-lg-5 col-md-6">
                              <div className="trend-content position-relative text-md-start text-center">
                                <small>6+ Hours | Full Day Tours</small>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">
                                    Adriatic Adventure–Zagreb To Athens
                                  </a>
                                </h3>
                                <h6 className="theme mb-0">
                                  <i className="icon-location-pin"></i> Greece
                                </h6>
                                <p className="mt-4 mb-0">
                                  Taking Safety Measures <br />
                                  <a href="#">
                                    <span className="theme">
                                      {" "}
                                      Free cancellation
                                    </span>
                                  </a>
                                </p>
                              </div>
                            </div>
                            <div className="col-lg-3 col-md-3">
                              <div className="trend-content text-md-end text-center">
                                <div className="rating">
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                </div>
                                <small>200 Reviews</small>
                                <div className="trend-price my-2">
                                  <span className="mb-0">From</span>
                                  <h3 className="mb-0">$160</h3>
                                  <small>Per Adult</small>
                                </div>
                                <a href="tour-single.html" className="nir-btn">
                                  View Detail
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div className="trend-full bg-white rounded box-shadow overflow-hidden p-4 mb-4">
                          <div className="row">
                            <div className="col-lg-4 col-md-3">
                              <div className="trend-item2 rounded">
                                <a href="tour-single.html"></a>
                                <div className="color-overlay"></div>
                              </div>
                            </div>
                            <div className="col-lg-5 col-md-6">
                              <div className="trend-content position-relative text-md-start text-center">
                                <small>6+ Hours | Full Day Tours</small>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">
                                    The Spanish Riviera Cost Bay
                                  </a>
                                </h3>
                                <h6 className="theme mb-0">
                                  <i className="icon-location-pin"></i> Spain
                                </h6>
                                <p className="mt-4 mb-0">
                                  Taking Safety Measures <br />
                                  <a href="#">
                                    <span className="theme">
                                      {" "}
                                      Free cancellation
                                    </span>
                                  </a>
                                </p>
                              </div>
                            </div>
                            <div className="col-lg-3 col-md-3">
                              <div className="trend-content text-md-end text-center">
                                <div className="rating">
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                </div>
                                <small>200 Reviews</small>
                                <div className="trend-price my-2">
                                  <span className="mb-0">From</span>
                                  <h3 className="mb-0">$160</h3>
                                  <small>Per Adult</small>
                                </div>
                                <a href="tour-single.html" className="nir-btn">
                                  View Detail
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div className="trend-full bg-white rounded box-shadow overflow-hidden p-4 mb-4">
                          <div className="row">
                            <div className="col-lg-4 col-md-3">
                              <div className="trend-item2 rounded">
                                <a href="tour-single.html"></a>
                                <div className="color-overlay"></div>
                              </div>
                            </div>
                            <div className="col-lg-5 col-md-6">
                              <div className="trend-content position-relative text-md-start text-center">
                                <small>6+ Hours | Full Day Tours</small>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">
                                    Adriatic Adventure–Zagreb To Athens
                                  </a>
                                </h3>
                                <h6 className="theme mb-0">
                                  <i className="icon-location-pin"></i> Greece
                                </h6>
                                <p className="mt-4 mb-0">
                                  Taking Safety Measures <br />
                                  <a href="#">
                                    <span className="theme">
                                      {" "}
                                      Free cancellation
                                    </span>
                                  </a>
                                </p>
                              </div>
                            </div>
                            <div className="col-lg-3 col-md-3">
                              <div className="trend-content text-md-end text-center">
                                <div className="rating">
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                </div>
                                <small>200 Reviews</small>
                                <div className="trend-price my-2">
                                  <span className="mb-0">From</span>
                                  <h3 className="mb-0">$160</h3>
                                  <small>Per Adult</small>
                                </div>
                                <a href="tour-single.html" className="nir-btn">
                                  View Detail
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div className="trend-full bg-white rounded box-shadow overflow-hidden p-4 mb-4">
                          <div className="row">
                            <div className="col-lg-4 col-md-3">
                              <div className="trend-item2 rounded">
                                <a
                                  href="tour-single.html"
                                  style={{
                                    backgroundImage: `url("images/destination/destination13.jpg")`,
                                  }}
                                ></a>
                                <div className="color-overlay"></div>
                              </div>
                            </div>
                            <div className="col-lg-5 col-md-6">
                              <div className="trend-content position-relative text-md-start text-center">
                                <small>6+ Hours | Full Day Tours</small>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">
                                    Highlights scenery of Vietnam
                                  </a>
                                </h3>
                                <h6 className="theme mb-0">
                                  <i className="icon-location-pin"></i> Vietnam
                                </h6>
                                <p className="mt-4 mb-0">
                                  Taking Safety Measures <br />
                                  <a href="#">
                                    <span className="theme">
                                      {" "}
                                      Free cancellation
                                    </span>
                                  </a>
                                </p>
                              </div>
                            </div>
                            <div className="col-lg-3 col-md-3">
                              <div className="trend-content text-md-end text-center">
                                <div className="rating">
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                  <span className="fa fa-star checked"></span>
                                </div>
                                <small>200 Reviews</small>
                                <div className="trend-price my-2">
                                  <span className="mb-0">From</span>
                                  <h3 className="mb-0">$160</h3>
                                  <small>Per Adult</small>
                                </div>
                                <a href="tour-single.html" className="nir-btn">
                                  View Detail
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div className="text-center">
                          <a href="#" className="nir-btn">
                            Load More{" "}
                            <i className="fa fa-long-arrow-alt-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                )}
                {/*  */}
                {showGridSearch && (
                  <div>
                    <div className="destination-list ">
                      <div className="accordion-item">
                        <div className="row">
                          <div className="col-lg-6 col-md-6 mb-4">
                            <div className="trend-item rounded box-shadow">
                              <div className="trend-image position-relative">
                                <img
                                  src="images/trending/trending2.jpg"
                                  alt="image"
                                />
                                <div className="color-overlay"></div>
                              </div>
                              <div className="trend-content p-4 pt-5 position-relative">
                                <div className="trend-meta bg-theme white px-3 py-2 rounded">
                                  <div className="entry-author">
                                    <i className="icon-calendar"></i>
                                    <span className="fw-bold">
                                      {" "}
                                      9 Days Tours
                                    </span>
                                  </div>
                                </div>
                                <h5 className="theme mb-1">
                                  <i className="flaticon-location-pin"></i>{" "}
                                  Croatia
                                </h5>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">Piazza Castello</a>
                                </h3>
                                <div className="rating-main d-flex align-items-center pb-2">
                                  <div className="rating">
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                  </div>
                                  <span className="ms-2">(12)</span>
                                </div>
                                <p className=" border-b pb-2 mb-2">
                                  Duis aute irure dolor in reprehenderit in
                                  voluptate velit esse cillum
                                </p>
                                <div className="entry-meta">
                                  <div className="entry-author d-flex align-items-center">
                                    <p className="mb-0">
                                      <span className="theme fw-bold fs-5">
                                        {" "}
                                        $170.00
                                      </span>{" "}
                                      | Per person
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div className="col-lg-6 col-md-6 mb-4">
                            <div className="trend-item box-shadow rounded">
                              <div className="trend-image position-relative">
                                <img
                                  src="images/trending/trending3.jpg"
                                  alt="image"
                                />
                                <div className="color-overlay"></div>
                              </div>
                              <div className="trend-content p-4 pt-5 position-relative">
                                <div className="trend-meta bg-theme white px-3 py-2 rounded">
                                  <div className="entry-author">
                                    <i className="icon-calendar"></i>
                                    <span className="fw-bold">
                                      {" "}
                                      9 Days Tours
                                    </span>
                                  </div>
                                </div>
                                <h5 className="theme mb-1">
                                  <i className="flaticon-location-pin"></i>{" "}
                                  Greece
                                </h5>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">Santorini, Oia</a>
                                </h3>
                                <div className="rating-main d-flex align-items-center pb-2">
                                  <div className="rating">
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                  </div>
                                  <span className="ms-2">(38)</span>
                                </div>
                                <p className=" border-b pb-2 mb-2">
                                  Duis aute irure dolor in reprehenderit in
                                  voluptate velit esse cillum
                                </p>
                                <div className="entry-meta">
                                  <div className="entry-author d-flex align-items-center">
                                    <p className="mb-0">
                                      <span className="theme fw-bold fs-5">
                                        {" "}
                                        $180.00
                                      </span>{" "}
                                      | Per person
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div className="col-lg-6 col-md-6 mb-4">
                            <div className="trend-item box-shadow rounded">
                              <div className="trend-image position-relative">
                                <img
                                  src="images/trending/trending4.jpg"
                                  alt="image"
                                />
                                <div className="color-overlay"></div>
                              </div>
                              <div className="trend-content p-4 pt-5 position-relative">
                                <div className="trend-meta bg-theme white px-3 py-2 rounded">
                                  <div className="entry-author">
                                    <i className="icon-calendar"></i>
                                    <span className="fw-bold">
                                      {" "}
                                      9 Days Tours
                                    </span>
                                  </div>
                                </div>
                                <h5 className="theme mb-1">
                                  <i className="flaticon-location-pin"></i>{" "}
                                  Maldives
                                </h5>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">
                                    Hurawalhi Island
                                  </a>
                                </h3>
                                <div className="rating-main d-flex align-items-center pb-2">
                                  <div className="rating">
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                  </div>
                                  <span className="ms-2">(18)</span>
                                </div>
                                <p className=" border-b pb-2 mb-2">
                                  Duis aute irure dolor in reprehenderit in
                                  voluptate velit esse cillum
                                </p>
                                <div className="entry-meta">
                                  <div className="entry-author d-flex align-items-center">
                                    <p className="mb-0">
                                      <span className="theme fw-bold fs-5">
                                        {" "}
                                        $260.00
                                      </span>{" "}
                                      | Per person
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div className="col-lg-6 col-md-6 mb-4">
                            <div className="trend-item box-shadow rounded">
                              <div className="trend-image position-relative">
                                <img
                                  src="images/trending/trending1.jpg"
                                  alt="image"
                                />
                                <div className="color-overlay"></div>
                              </div>
                              <div className="trend-content p-4 pt-5 position-relative">
                                <div className="trend-meta bg-theme white px-3 py-2 rounded">
                                  <div className="entry-author">
                                    <i className="icon-calendar"></i>
                                    <span className="fw-bold">
                                      {" "}
                                      5 Days Tours
                                    </span>
                                  </div>
                                </div>
                                <h5 className="theme mb-1">
                                  <i className="flaticon-location-pin"></i>{" "}
                                  Greece
                                </h5>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">Santorini, Oia</a>
                                </h3>
                                <div className="rating-main d-flex align-items-center pb-2">
                                  <div className="rating">
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                  </div>
                                  <span className="ms-2">(38)</span>
                                </div>
                                <p className=" border-b pb-2 mb-2">
                                  Duis aute irure dolor in reprehenderit in
                                  voluptate velit esse cillum
                                </p>
                                <div className="entry-meta">
                                  <div className="entry-author d-flex align-items-center">
                                    <p className="mb-0">
                                      <span className="theme fw-bold fs-5">
                                        {" "}
                                        $180.00
                                      </span>{" "}
                                      | Per person
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div className="col-lg-6 col-md-6 mb-4">
                            <div className="trend-item rounded box-shadow">
                              <div className="trend-image position-relative">
                                <img
                                  src="images/trending/trending2.jpg"
                                  alt="image"
                                />
                                <div className="color-overlay"></div>
                              </div>
                              <div className="trend-content p-4 pt-5 position-relative">
                                <div className="trend-meta bg-theme white px-3 py-2 rounded">
                                  <div className="entry-author">
                                    <i className="icon-calendar"></i>
                                    <span className="fw-bold">
                                      {" "}
                                      9 Days Tours
                                    </span>
                                  </div>
                                </div>
                                <h5 className="theme mb-1">
                                  <i className="flaticon-location-pin"></i>{" "}
                                  Croatia
                                </h5>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">Piazza Castello</a>
                                </h3>
                                <div className="rating-main d-flex align-items-center pb-2">
                                  <div className="rating">
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                  </div>
                                  <span className="ms-2">(12)</span>
                                </div>
                                <p className=" border-b pb-2 mb-2">
                                  Duis aute irure dolor in reprehenderit in
                                  voluptate velit esse cillum
                                </p>
                                <div className="entry-meta">
                                  <div className="entry-author d-flex align-items-center">
                                    <p className="mb-0">
                                      <span className="theme fw-bold fs-5">
                                        {" "}
                                        $170.00
                                      </span>{" "}
                                      | Per person
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div className="col-lg-6 col-md-6 mb-4">
                            <div className="trend-item box-shadow rounded">
                              <div className="trend-image position-relative">
                                <img
                                  src="images/trending/trending3.jpg"
                                  alt="image"
                                />
                                <div className="color-overlay"></div>
                              </div>
                              <div className="trend-content p-4 pt-5 position-relative">
                                <div className="trend-meta bg-theme white px-3 py-2 rounded">
                                  <div className="entry-author">
                                    <i className="icon-calendar"></i>
                                    <span className="fw-bold">
                                      {" "}
                                      9 Days Tours
                                    </span>
                                  </div>
                                </div>
                                <h5 className="theme mb-1">
                                  <i className="flaticon-location-pin"></i>{" "}
                                  Greece
                                </h5>
                                <h3 className="mb-1">
                                  <a href="tour-single.html">Santorini, Oia</a>
                                </h3>
                                <div className="rating-main d-flex align-items-center pb-2">
                                  <div className="rating">
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                    <span className="fa fa-star checked"></span>
                                  </div>
                                  <span className="ms-2">(38)</span>
                                </div>
                                <p className=" border-b pb-2 mb-2">
                                  Duis aute irure dolor in reprehenderit in
                                  voluptate velit esse cillum
                                </p>
                                <div className="entry-meta">
                                  <div className="entry-author d-flex align-items-center">
                                    <p className="mb-0">
                                      <span className="theme fw-bold fs-5">
                                        {" "}
                                        $180.00
                                      </span>{" "}
                                      | Per person
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div className="col-lg-12">
                            <div className="text-center">
                              <a href="#" className="nir-btn">
                                Load More{" "}
                                <i className="fa fa-long-arrow-alt-right"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                )}
              </div>
              {/*  */}
            </div>
            <div className="col-lg-4 pe-lg-4">
              <div className="sidebar-sticky">
                <div className="list-sidebar">
                  <div className="sidebar-item mb-4">
                    <h3>Categories Type</h3>
                    <ul className="sidebar-category1">
                      <li>
                        <input type="checkbox" checked /> Tours{" "}
                        <span className="float-end">92</span>
                      </li>
                      <li>
                        <input type="checkbox" /> Attractions{" "}
                        <span className="float-end">22</span>
                      </li>
                      <li>
                        <input type="checkbox" /> Day Trips{" "}
                        <span className="float-end">35</span>
                      </li>
                      <li>
                        <input type="checkbox" /> Outdoor Activities{" "}
                        <span className="float-end">41</span>
                      </li>
                      <li>
                        <input type="checkbox" /> Concert & Show{" "}
                        <span className="float-end">11</span>
                      </li>
                      <li>
                        <input type="checkbox" /> Indoor{" "}
                        <span className="float-end">61</span>
                      </li>
                      <li>
                        <input type="checkbox" /> Sight Seeing{" "}
                        <span className="float-end">18</span>
                      </li>
                      <li>
                        <input type="checkbox" /> Travels{" "}
                        <span className="float-end">88</span>
                      </li>
                    </ul>
                  </div>
                  <div className="sidebar-item mb-4">
                    <h3>Duration Type</h3>
                    <ul className="sidebar-category1">
                      <li>
                        <input type="checkbox" checked /> up to 1 hour{" "}
                        <span className="float-end">92</span>
                      </li>
                      <li>
                        <input type="checkbox" /> 1 to 2 hour{" "}
                        <span className="float-end">22</span>
                      </li>
                      <li>
                        <input type="checkbox" /> 2 to 4 hour{" "}
                        <span className="float-end">35</span>
                      </li>
                      <li>
                        <input type="checkbox" /> 4 to 8 hour{" "}
                        <span className="float-end">41</span>
                      </li>
                      <li>
                        <input type="checkbox" /> 8 to 1 Day{" "}
                        <span className="float-end">11</span>
                      </li>
                      <li>
                        <input type="checkbox" /> 1 Day to 2 Days{" "}
                        <span className="float-end">61</span>
                      </li>
                    </ul>
                  </div>
                  <div className="sidebar-item mb-4">
                    <h3>Duration Type</h3>
                    <div className="range-slider mt-0">
                      <p className="text-start mb-2">Price Range</p>
                      <div
                        data-min="0"
                        data-max="2000"
                        data-unit="$"
                        data-min-name="min_price"
                        data-max-name="max_price"
                        className="range-slider-ui ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                        aria-disabled="false"
                      >
                        <span className="min-value">0 $</span>
                        <span className="max-value">20000 $</span>
                        <div className="ui-slider-range ui-widget-header ui-corner-all full"></div>
                      </div>
                      <div className="clearfix"></div>
                    </div>
                  </div>
                  {/* <div className="sidebar-item">
                    <h3>Related Destinations</h3>
                    <div className="sidebar-destination">
                      <div className="row about-slider">
                        <div className="col-lg-4 col-md-6 col-sm-6 mb-4">
                          <div className="trend-item1">
                            <div className="trend-image position-relative rounded">
                              <img
                                src="images/destination/destination17.jpg"
                                alt="image"
                              />
                              <div className="trend-content d-flex align-items-center justify-content-between position-absolute bottom-0 p-4 w-100 z-index">
                                <div className="trend-content-title">
                                  <h5 className="mb-0">
                                    <a
                                      href="tour-single.html"
                                      className="theme1"
                                    >
                                      Italy
                                    </a>
                                  </h5>
                                  <h4 className="mb-0 white">Caspian Valley</h4>
                                </div>
                                <span className="white bg-theme p-1 px-2 rounded">
                                  18 Tours
                                </span>
                              </div>
                              <div className="color-overlay"></div>
                            </div>
                          </div>
                        </div>
                        <div className="col-lg-4 col-md-6 col-sm-6 mb-4">
                          <div className="trend-item1">
                            <div className="trend-image position-relative rounded">
                              <img
                                src="images/destination/destination14.jpg"
                                alt="image"
                              />
                              <div className="trend-content d-flex align-items-center justify-content-between position-absolute bottom-0 p-4 w-100 z-index">
                                <div className="trend-content-title">
                                  <h5 className="mb-0">
                                    <a
                                      href="tour-single.html"
                                      className="theme1"
                                    >
                                      Tokyo
                                    </a>
                                  </h5>
                                  <h4 className="mb-0 white">Japan</h4>
                                </div>
                                <span className="white bg-theme p-1 px-2 rounded">
                                  21 Tours
                                </span>
                              </div>
                              <div className="color-overlay"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> */}
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default TourSearch;
