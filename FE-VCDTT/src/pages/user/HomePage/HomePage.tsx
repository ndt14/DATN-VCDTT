import React from "react";
import "./HomePage.css";
import { Carousel } from "antd";

import { TourPreview } from "../../../componenets";

const HomePage = () => {
  return (
    <main id="content" className="site-main">
      {/* <!-- Home slider html start --> */}
      <section className="home-slider-section">
        <div className="home-slider">
          <div className="home-banner-items">
            <div className="banner-inner-wrap">
              <Carousel autoplay>
                <img src="assets/images/slider-banner-1.jpg" alt="" />

                <img src="assets/images/slider-banner-2.jpg" alt="" />
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
            <div className="input-group width-col-9 flex-grow-1">
              <label> Tìm kiếm địa điểm * </label>
              <input type="text" name="s" placeholder="Nhập địa điểm" />
            </div>

            <div className="input-group width-col-3">
              <label className="screen-reader-text"> Tìm kiếm </label>
              <input
                type="submit"
                name="travel-search"
                value="TÌM KIẾM"
                className="rounded "
              />
            </div>
          </div>
        </div>
      </div>
      {/* <!-- search search field html end --> */}

      {/* <!-- Home packages section html start --> */}
      <section className="package-section">
        <div className="container">
          <div className="section-heading text-center">
            <div className="row">
              <div className="col-lg-8 offset-lg-2">
                <h5 className="dash-style">KHÁM PHÁ CÁC ĐỊA DANH NỔI TIẾNG</h5>
                <h2 className="">TOUR NỔI BẬT</h2>
                <p>
                  Mollit voluptatem perspiciatis convallis elementum corporis
                  quo veritatis aliquid blandit, blandit torquent, odit placeat.
                  Adipiscing repudiandae eius cursus? Nostrum magnis maxime
                  curae placeat.
                </p>
              </div>
            </div>
          </div>
          <div className="package-inner">
            <div className="row">
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
            </div>
            <div className="btn-wrap text-center">
              <a href="#" className="button-primary">
                XEM TẤT CẢ TOUR
              </a>
            </div>
          </div>
        </div>
      </section>
      {/*  */}

      {/*  */}
      <section className="special-section">
        <div className="container">
          <div className="section-heading text-center">
            <div className="row">
              <div className="col-lg-8 offset-lg-2">
                <h5 className="dash-style">TOUR ĐỀ XUẤT & GIẢM GIÁ</h5>
                <h2>TOUR GIẢM GIÁ</h2>
                <p>
                  Mollit voluptatem perspiciatis convallis elementum corporis
                  quo veritatis aliquid blandit, blandit torquent, odit placeat.
                  Adipiscing repudiandae eius cursus? Nostrum magnis maxime
                  curae placeat.
                </p>
              </div>
            </div>
          </div>
          <div className="special-inner">
            <div className="row">
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
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
                <h5 className="dash-style">KHÁM PHÁ CÁC ĐỊA DANH NỔI TIẾNG</h5>
                <h2 className="">DANH SÁCH CÁC TOUR</h2>
                <p>
                  Mollit voluptatem perspiciatis convallis elementum corporis
                  quo veritatis aliquid blandit, blandit torquent, odit placeat.
                  Adipiscing repudiandae eius cursus? Nostrum magnis maxime
                  curae placeat.
                </p>
              </div>
            </div>
          </div>
          <div className="package-inner">
            <div className="row">
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
              <TourPreview></TourPreview>
            </div>
            <div className="btn-wrap text-center ">
              <a href="#" className="button-primary rounded">
                XEM TẤT CẢ TOUR
              </a>
            </div>
          </div>
        </div>
      </section>
      {/*  */}
      <section className="activity-section">
        <div className="container">
          <div className="section-heading text-center">
            <div className="row">
              <div className="col-lg-8 offset-lg-2">
                <h5 className="dash-style">TRAVEL BY ACTIVITY</h5>
                <h2>LÝ DO NÊN ĐẶT TOUR VỚI VCDTT</h2>
                <p>
                  Mollit voluptatem perspiciatis convallis elementum corporis
                  quo veritatis aliquid blandit, blandit torquent, odit placeat.
                  Adipiscing repudiandae eius cursus? Nostrum magnis maxime
                  curae placeat.
                </p>
              </div>
            </div>
          </div>
          <div className="activity-inner row">
            <div className="col-lg-2 col-md-4 col-sm-6">
              <div className="activity-item">
                <div className="activity-icon">
                  <a href="#">
                    <img src="assets/images/icon6.png" alt="" />
                  </a>
                </div>
                <div className="activity-content">
                  <h4>
                    <a href="#">Adventure</a>
                  </h4>
                  <p>15 Destination</p>
                </div>
              </div>
            </div>
            <div className="col-lg-2 col-md-4 col-sm-6">
              <div className="activity-item">
                <div className="activity-icon">
                  <a href="#">
                    <img src="assets/images/icon10.png" alt="" />
                  </a>
                </div>
                <div className="activity-content">
                  <h4>
                    <a href="#">Trekking</a>
                  </h4>
                  <p>12 Destination</p>
                </div>
              </div>
            </div>
            <div className="col-lg-2 col-md-4 col-sm-6">
              <div className="activity-item">
                <div className="activity-icon">
                  <a href="#">
                    <img src="assets/images/icon9.png" alt="" />
                  </a>
                </div>
                <div className="activity-content">
                  <h4>
                    <a href="#">Camp Fire</a>
                  </h4>
                  <p>7 Destination</p>
                </div>
              </div>
            </div>
            <div className="col-lg-2 col-md-4 col-sm-6">
              <div className="activity-item">
                <div className="activity-icon">
                  <a href="#">
                    <img src="assets/images/icon8.png" alt="" />
                  </a>
                </div>
                <div className="activity-content">
                  <h4>
                    <a href="#">Off Road</a>
                  </h4>
                  <p>15 Destination</p>
                </div>
              </div>
            </div>
            <div className="col-lg-2 col-md-4 col-sm-6">
              <div className="activity-item">
                <div className="activity-icon">
                  <a href="#">
                    <img src="assets/images/icon7.png" alt="" />
                  </a>
                </div>
                <div className="activity-content">
                  <h4>
                    <a href="#">Camping</a>
                  </h4>
                  <p>13 Destination</p>
                </div>
              </div>
            </div>
            <div className="col-lg-2 col-md-4 col-sm-6">
              <div className="activity-item">
                <div className="activity-icon">
                  <a href="#">
                    <img src="assets/images/icon11.png" alt="" />
                  </a>
                </div>
                <div className="activity-content">
                  <h4>
                    <a href="#">Exploring</a>
                  </h4>
                  <p>25 Destination</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
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
                <h5 className="dash-style">BLOG CỦA VCDTT</h5>
                <h2>CÁC BÀI VIẾT MỚI NHẤT</h2>
                <p>
                  Mollit voluptatem perspiciatis convallis elementum corporis
                  quo veritatis aliquid blandit, blandit torquent, odit placeat.
                  Adipiscing repudiandae eius cursus? Nostrum magnis maxime
                  curae placeat.
                </p>
              </div>
            </div>
          </div>
          <div className="row">
            <div className="col-md-6 col-lg-4">
              <article className="post">
                <figure className="feature-image">
                  <a href="#">
                    <img src="../../../../assets/images/img17.jpg" alt="" />
                  </a>
                </figure>
                <div className="entry-content">
                  <h3>
                    <a href="#">
                      Life is a beautiful journey not a destination
                    </a>
                  </h3>
                  <div className="entry-meta">
                    <span className="byline">
                      <a href="#">Demoteam</a>
                    </span>
                    <span className="posted-on">
                      <a href="#">August 17, 2021</a>
                    </span>
                    <span className="comments-link">
                      <a href="#">No Comments</a>
                    </span>
                  </div>
                </div>
              </article>
            </div>
            <div className="col-md-6 col-lg-4">
              <article className="post">
                <figure className="feature-image">
                  <a href="#">
                    <img src="../../../../assets/images/img18.jpg" alt="" />
                  </a>
                </figure>
                <div className="entry-content">
                  <h3>
                    <a href="#">Take only memories, leave only footprints</a>
                  </h3>
                  <div className="entry-meta">
                    <span className="byline">
                      <a href="#">Demoteam</a>
                    </span>
                    <span className="posted-on">
                      <a href="#">August 17, 2021</a>
                    </span>
                    <span className="comments-link">
                      <a href="#">No Comments</a>
                    </span>
                  </div>
                </div>
              </article>
            </div>
            <div className="col-md-6 col-lg-4">
              <article className="post">
                <figure className="feature-image">
                  <a href="#">
                    <img src="../../../../assets/images/img19.jpg" alt="" />
                  </a>
                </figure>
                <div className="entry-content">
                  <h3>
                    <a href="#">Journeys are best measured in new friends</a>
                  </h3>
                  <div className="entry-meta">
                    <span className="byline">
                      <a href="#">Demoteam</a>
                    </span>
                    <span className="posted-on">
                      <a href="#">August 17, 2021</a>
                    </span>
                    <span className="comments-link">
                      <a href="#">No Comments</a>
                    </span>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>
      </section>
      {/* <!-- blog html end -->
             <!-- Home testimonial section html start --> */}
      <section className="best-section">
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
      </section>
      {/* <!-- testimonial html end -->
            <!-- Home contact details section html start --> */}

      {/* <!--  contact details html end --> */}
    </main>
  );
};

export default HomePage;
