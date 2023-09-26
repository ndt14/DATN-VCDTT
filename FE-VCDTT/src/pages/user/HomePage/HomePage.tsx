import React from "react";

const HomePage = () => {
  return (
    <main id="content" className="site-main">
      {/* <!-- Home slider html start --> */}
      <section className="home-slider-section">
        <div className="home-slider">
          <div className="home-banner-items">
            <div className="banner-inner-wrap"></div>
            <div className="banner-content-wrap">
              <div className="container">
                <div className="banner-content text-center">
                  <h2 className="banner-title">TRAVELLING AROUND THE WORLD</h2>
                  <p>
                    Taciti quasi, sagittis excepteur hymenaeos, id temporibus
                    hic proident ullam, eaque donec delectus tempor consectetur
                    nunc, purus congue? Rem volutpat sodales! Mollit. Minus
                    exercitationem wisi.
                  </p>
                  <a href="#" className="button-primary">
                    CONTINUE READING
                  </a>
                </div>
              </div>
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
            <div className="input-group">
              <label> Search Destination* </label>
              <input type="text" name="s" placeholder="Enter Destination" />
            </div>

            <div className="input-group width-col-3">
              <label className="screen-reader-text"> Search </label>
              <input type="submit" name="travel-search" value="INQUIRE NOW" />
            </div>
          </div>
        </div>
      </div>
      {/* <!-- search search field html end --> */}
      <section className="destination-section">
        <div className="container">
          <div className="section-heading">
            <div className="row align-items-end">
              <div className="col-lg-7">
                <h2>TOP NOTCH DESTINATION</h2>
              </div>
              <div className="col-lg-5">
                <div className="section-disc">
                  Aperiam sociosqu urna praesent, tristique, corrupti
                  condimentum asperiores platea ipsum ad arcu. Nostrud. Aut
                  nostrum, ornare quas provident laoreet nesciunt.
                </div>
              </div>
            </div>
          </div>
          <div className="destination-inner destination-three-column">
            <div className="row">
              <div className="col-lg-7">
                <div className="row">
                  <div className="col-sm-6">
                    <div className="desti-item overlay-desti-item">
                      <figure className="desti-image">
                        <img
                          className="w-full"
                          src="assets/images/img1.jpg"
                          alt=""
                        />
                      </figure>
                      <div className="meta-cat bg-meta-cat">
                        <a href="#">THAILAND</a>
                      </div>
                      <div className="desti-content">
                        <h3>
                          <a href="#">Disney Land</a>
                        </h3>
                        <div className="rating-start" title="Rated 5 out of 4">
                          <span className="w-1/2"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className="col-sm-6">
                    <div className="desti-item overlay-desti-item">
                      <figure className="desti-image">
                        <img
                          className="w-full"
                          src="assets/images/img2.jpg"
                          alt=""
                        />
                      </figure>
                      <div className="meta-cat bg-meta-cat">
                        <a href="#">NORWAY</a>
                      </div>
                      <div className="desti-content">
                        <h3>
                          <a href="#">Besseggen Ridge</a>
                        </h3>
                        <div className="rating-start" title="Rated 5 out of 5">
                          <span className="w-full"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-lg-5">
                <div className="row">
                  <div className="col-md-6 col-xl-12">
                    <div className="desti-item overlay-desti-item">
                      <figure className="desti-image">
                        <img
                          className="w-full"
                          src="assets/images/img3.jpg"
                          alt=""
                        />
                      </figure>
                      <div className="meta-cat bg-meta-cat">
                        <a href="#">NEW ZEALAND</a>
                      </div>
                      <div className="desti-content">
                        <h3>
                          <a href="#">Oxolotan City</a>
                        </h3>
                        <div className="rating-start" title="Rated 5 out of 5">
                          <span className="w-full"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className="col-md-6 col-xl-12">
                    <div className="desti-item overlay-desti-item">
                      <figure className="desti-image">
                        <img
                          className="w-full"
                          src="assets/images/img4.jpg"
                          alt=""
                        />
                      </figure>
                      <div className="meta-cat bg-meta-cat">
                        <a href="#">SINGAPORE</a>
                      </div>
                      <div className="desti-content">
                        <h3>
                          <a href="#">Marina Bay Sand City</a>
                        </h3>
                        <div
                          className="rating-start"
                          title="Rated 5 out of 4"
                        ></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="btn-wrap text-center">
              <a href="#" className="button-primary">
                MORE DESTINATION
              </a>
            </div>
          </div>
        </div>
      </section>
      {/* <!-- Home packages section html start --> */}
      <section className="package-section">
        <div className="container">
          <div className="section-heading text-center">
            <div className="row">
              <div className="col-lg-8 offset-lg-2">
                <h5 className="dash-style">EXPLORE GREAT PLACES</h5>
                <h2 className="">POPULAR PACKAGES</h2>
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
              <div className="col-lg-4 col-md-6">
                <div className="package-wrap">
                  <figure className="feature-image">
                    <a href="#">
                      <img
                        className="w-full"
                        src="assets/images/img5.jpg"
                        alt=""
                      />
                    </a>
                  </figure>
                  <div className="package-price">
                    <h6>
                      <span>$1,900 </span> / per person
                    </h6>
                  </div>
                  <div className="package-content-wrap">
                    <div className="package-meta text-center">
                      <ul>
                        <li>
                          <i className="far fa-clock"></i>
                          7D/6N
                        </li>
                        <li>
                          <i className="fas fa-user-friends"></i>
                          People: 5
                        </li>
                        <li>
                          <i className="fas fa-map-marker-alt"></i>
                          Malaysia
                        </li>
                      </ul>
                    </div>
                    <div className="package-content">
                      <h3>
                        <a href="#">
                          Sunset view of beautiful lakeside resident
                        </a>
                      </h3>
                      <div className="review-area">
                        <span className="review-text">(25 reviews)</span>
                        <div className="rating-start" title="Rated 5 out of 5">
                          <span className="w-3/5"></span>
                        </div>
                      </div>
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                        luctus nec ullam. Ut elit tellus, luctus nec ullam elit
                        tellpus.
                      </p>
                      <div className="btn-wrap">
                        <a href="#" className="button-text width-6">
                          Book Now<i className="fas fa-arrow-right"></i>
                        </a>
                        <a href="#" className="button-text width-6">
                          Wish List<i className="far fa-heart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-lg-4 col-md-6">
                <div className="package-wrap">
                  <figure className="feature-image">
                    <a href="#">
                      <img
                        className="w-full"
                        src="assets/images/img6.jpg"
                        alt=""
                      />
                    </a>
                  </figure>
                  <div className="package-price">
                    <h6>
                      <span>$1,230 </span> / per person
                    </h6>
                  </div>
                  <div className="package-content-wrap">
                    <div className="package-meta text-center">
                      <ul>
                        <li>
                          <i className="far fa-clock"></i>
                          5D/4N
                        </li>
                        <li>
                          <i className="fas fa-user-friends"></i>
                          People: 8
                        </li>
                        <li>
                          <i className="fas fa-map-marker-alt"></i>
                          Canada
                        </li>
                      </ul>
                    </div>
                    <div className="package-content">
                      <h3>
                        <a href="#">Experience the natural beauty of island</a>
                      </h3>
                      <div className="review-area">
                        <span className="review-text">(17 reviews)</span>
                        <div className="rating-start" title="Rated 5 out of 5">
                          <span className="w-full"></span>
                        </div>
                      </div>
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                        luctus nec ullam. Ut elit tellus, luctus nec ullam elit
                        tellpus.
                      </p>
                      <div className="btn-wrap">
                        <a href="#" className="button-text width-6">
                          Book Now<i className="fas fa-arrow-right"></i>
                        </a>
                        <a href="#" className="button-text width-6">
                          Wish List<i className="far fa-heart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-lg-4 col-md-6">
                <div className="package-wrap">
                  <figure className="feature-image">
                    <a href="#">
                      <img
                        className="w-full"
                        src="assets/images/img7.jpg"
                        alt=""
                      />
                    </a>
                  </figure>
                  <div className="package-price">
                    <h6>
                      <span>$2,000 </span> / per person
                    </h6>
                  </div>
                  <div className="package-content-wrap">
                    <div className="package-meta text-center">
                      <ul>
                        <li>
                          <i className="far fa-clock"></i>
                          6D/5N
                        </li>
                        <li>
                          <i className="fas fa-user-friends"></i>
                          People: 6
                        </li>
                        <li>
                          <i className="fas fa-map-marker-alt"></i>
                          Portugal
                        </li>
                      </ul>
                    </div>
                    <div className="package-content">
                      <h3>
                        <a href="#">Vacation to the water city of Portugal</a>
                      </h3>
                      <div className="review-area">
                        <span className="review-text">(22 reviews)</span>
                        <div className="rating-start" title="Rated 5 out of 5">
                          <span className="w-4/5"></span>
                        </div>
                      </div>
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                        luctus nec ullam. Ut elit tellus, luctus nec ullam elit
                        tellpus.
                      </p>
                      <div className="btn-wrap">
                        <a href="#" className="button-text width-6">
                          Book Now<i className="fas fa-arrow-right"></i>
                        </a>
                        <a href="#" className="button-text width-6">
                          Wish List<i className="far fa-heart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="btn-wrap text-center">
              <a href="#" className="button-primary">
                VIEW ALL PACKAGES
              </a>
            </div>
          </div>
        </div>
      </section>
      {/* <!-- packages html end -->
            <!-- Home callback section html start --> */}

      {/* <!-- callback html end -->
            <!-- Home activity section html start --> */}
      <section className="activity-section">
        <div className="container">
          <div className="section-heading text-center">
            <div className="row">
              <div className="col-lg-8 offset-lg-2">
                <h5 className="dash-style">TRAVEL BY ACTIVITY</h5>
                <h2>ADVENTURE & ACTIVITY</h2>
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
                    <img
                      className="mx-auto"
                      src="assets/images/icon6.png"
                      alt=""
                    />
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
                    <img
                      className="mx-auto"
                      src="assets/images/icon10.png"
                      alt=""
                    />
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
                    <img
                      className="mx-auto"
                      src="assets/images/icon9.png"
                      alt=""
                    />
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
                    <img
                      className="mx-auto"
                      src="assets/images/icon8.png"
                      alt=""
                    />
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
                    <img
                      className="mx-auto"
                      src="assets/images/icon7.png"
                      alt=""
                    />
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
                    <img
                      className="mx-auto"
                      src="assets/images/icon11.png"
                      alt=""
                    />
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
      {/* <!-- activity html end -->
            <!-- Home special section html start --> */}
      <section className="special-section">
        <div className="container">
          <div className="section-heading text-center">
            <div className="row">
              <div className="col-lg-8 offset-lg-2">
                <h5 className="dash-style">TRAVEL OFFER & DISCOUNT</h5>
                <h2>SPECIAL TRAVEL OFFER</h2>
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
              <div className="col-md-6 col-lg-4">
                <div className="special-item">
                  <figure className="special-img">
                    <img
                      className="w-full"
                      src="assets/images/img9.jpg"
                      alt=""
                    />
                  </figure>
                  <div className="badge-dis">
                    <span>
                      <strong>20%</strong>
                      off
                    </span>
                  </div>
                  <div className="special-content">
                    <div className="meta-cat">
                      <a href="#">CANADA</a>
                    </div>
                    <h3>
                      <a href="#">Experience the natural beauty of glacier</a>
                    </h3>
                    <div className="package-price">
                      Price:
                      <del>$1500</del>
                      <ins>$1200</ins>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-md-6 col-lg-4">
                <div className="special-item">
                  <figure className="special-img">
                    <img
                      className="w-full"
                      src="assets/images/img10.jpg"
                      alt=""
                    />
                  </figure>
                  <div className="badge-dis">
                    <span>
                      <strong>15%</strong>
                      off
                    </span>
                  </div>
                  <div className="special-content">
                    <div className="meta-cat">
                      <a href="#">NEW ZEALAND</a>
                    </div>
                    <h3>
                      <a href="#">Trekking to the mountain camp site</a>
                    </h3>
                    <div className="package-price">
                      Price:
                      <del>$1300</del>
                      <ins>$1105</ins>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-md-6 col-lg-4">
                <div className="special-item">
                  <figure className="special-img">
                    <img
                      className="w-full"
                      src="assets/images/img11.jpg"
                      alt=""
                    />
                  </figure>
                  <div className="badge-dis">
                    <span>
                      <strong>15%</strong>
                      off
                    </span>
                  </div>
                  <div className="special-content">
                    <div className="meta-cat">
                      <a href="#">MALAYSIA</a>
                    </div>
                    <h3>
                      <a href="#">Sunset view of beautiful lakeside city</a>
                    </h3>
                    <div className="package-price">
                      Price:
                      <del>$1800</del>
                      <ins>$1476</ins>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      {/* <!-- special html end -->
            <!-- Home special section html start --> */}

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
                <h5 className="dash-style">FROM OUR BLOG</h5>
                <h2>OUR RECENT POSTS</h2>
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
                    <img src="assets/images/img17.jpg" alt="" />
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
                    <img src="assets/images/img18.jpg" alt="" />
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
                    <img src="assets/images/img19.jpg" alt="" />
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

      {/* <!-- testimonial html end -->
            <!-- Home contact details section html start --> */}

      {/* <!--  contact details html end --> */}
    </main>
  );
};

export default HomePage;
