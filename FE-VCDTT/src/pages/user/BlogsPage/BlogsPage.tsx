import "./BlogsPage.css";
import Loader from "../../../componenets/User/Loader";

import { useGetBlogsQuery } from "../../../api/blogs";
import { Blog } from "../../../interfaces/Blog";
import { Link } from "react-router-dom";
import ReactPaginate from "react-paginate";
import { useState } from "react";

const BlogsPage = () => {
  const backgroundImageUrl = "assets/images/inner-banner.jpg";
  const containerStyle = {
    background: `url(${backgroundImageUrl})`,
    backgroundSize: "cover",
  };

  const handlePageChange = (selectedPage: { selected: number }) => {
    setCurrentPage(selectedPage.selected);
  };
  const [currentPage, setCurrentPage] = useState<number>(0);
  const { data } = useGetBlogsQuery();
  console.log(data);
  const itemsPerPage = 6;
  const pageCount = Math.ceil(data?.data?.blogs.length / itemsPerPage);
  const currentData: Blog[] = (data?.data?.blogs.slice(
    currentPage * itemsPerPage,
    (currentPage + 1) * itemsPerPage
  ) || []) as Blog[];
  console.log(currentData);

  return (
    <>
      <Loader />
      <div id="page" className="full-page">
        <main id="content" className="site-main">
          {/* <!-- Inner Banner html start--> */}
          <section className="inner-banner-wrap">
            <div className="inner-baner-container" style={containerStyle}>
              <div className="container">
                <div className="inner-banner-content">
                  <h1 className="inner-title">Blogs</h1>
                </div>
              </div>
            </div>
            <div className="inner-shape"></div>
          </section>
          {/* <!-- Inner Banner html end--> */}
          <div className="archive-section blog-archive">
            <div className="archive-inner">
              <div className="container">
                <div className="row">
                  <div className="col-lg-8 primary right-sidebar">
                    {/* Call API */}
                    <div className="grid row">
                      {currentData?.map(({ id, main_img, title }: Blog) => {
                        return (
                          <div className="grid-item col-md-6" key={id}>
                            <article className="post">
                              <figure className="feature-image">
                                <Link to={`${id}`}>
                                  <img src={main_img} alt="" />
                                </Link>
                              </figure>
                              <div className="entry-content">
                                <Link to={`${id}`}>
                                  <h3>{title}</h3>
                                </Link>
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
                                <p>
                                  Praesent, risus adipisicing donec! Cras.
                                  Lobortis id aliquip taciti repudiandae porro
                                  dolore facere officia! Natoque mollitia
                                  ultrices convallis nisl suscipit
                                </p>
                                <a href="#" className="button-text">
                                  CONTINUE READING..
                                </a>
                              </div>
                            </article>
                          </div>
                        );
                      })}
                    </div>
                    <ReactPaginate
                      previousLabel={"Back"}
                      nextLabel={"Next"}
                      breakLabel={"..."}
                      pageCount={pageCount}
                      onPageChange={handlePageChange}
                      containerClassName={"pagination"}
                      activeClassName={"active"}
                    />
                    {/* <!-- blog post item html end -->
                           <!-- pagination html start--> */}
                    {/* <div className="post-navigation-wrap">
                      <nav>
                        <ul className="pagination">
                          <li>
                            <a href="#">
                              <i className="fas fa-arrow-left"></i>
                            </a>
                          </li>
                          <li className="active">
                            <a href="#">1</a>
                          </li>
                          <li>
                            <a href="#">..</a>
                          </li>
                          <li>
                            <a href="#">5</a>
                          </li>
                          <li>
                            <a href="#">
                              <i className="fas fa-arrow-right"></i>
                            </a>
                          </li>
                        </ul>
                      </nav>
                    </div> */}
                    {/* <!-- pagination html start--> */}
                  </div>
                  {/* <div className="col-lg-4 secondary">
                    <div className="sidebar">
                      <aside className="widget author_widget">
                        <h3 className="widget-title">ABOUT AUTHOR</h3>
                        <div className="widget-content text-center">
                          <div className="profile">
                            <figure className="avatar">
                              <a href="#">
                                <img src="assets/images/img21.jpg" alt="" />
                              </a>
                            </figure>
                            <div className="text-content">
                              <div className="name-title">
                                <h3>
                                  <a href="https://demo.bosathemes.com/bosa/photography/james-watson/">
                                    James Watson
                                  </a>
                                </h3>
                              </div>
                              <p>
                                Accumsan? Aliquet nobis doloremque, aliqua?
                                Inceptos voluptatem, duis tempore optio quae
                                animi viverra distinctio cumque vivamus, earum
                                congue, anim velit
                              </p>
                            </div>
                            <div className="socialgroup">
                              <ul>
                                <li>
                                  {" "}
                                  <a target="_blank" href="#">
                                    {" "}
                                    <i className="fab fa-facebook"></i>{" "}
                                  </a>{" "}
                                </li>
                                <li>
                                  {" "}
                                  <a target="_blank" href="#">
                                    {" "}
                                    <i className="fab fa-google"></i>{" "}
                                  </a>{" "}
                                </li>
                                <li>
                                  {" "}
                                  <a target="_blank" href="#">
                                    {" "}
                                    <i className="fab fa-twitter"></i>{" "}
                                  </a>{" "}
                                </li>
                                <li>
                                  {" "}
                                  <a target="_blank" href="#">
                                    {" "}
                                    <i className="fab fa-instagram"></i>{" "}
                                  </a>{" "}
                                </li>
                                <li>
                                  {" "}
                                  <a target="_blank" href="#">
                                    {" "}
                                    <i className="fab fa-pinterest"></i>{" "}
                                  </a>{" "}
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </aside>
                      <aside className="widget widget_latest_post widget-post-thumb">
                        <h3 className="widget-title">Recent Post</h3>
                        <ul>
                          <li>
                            <figure className="post-thumb">
                              <a href="#">
                                <img src="assets/images/img17.jpg" alt="" />
                              </a>
                            </figure>
                            <div className="post-content">
                              <h5>
                                <a href="#">
                                  Someday I’m going to be free and travel
                                </a>
                              </h5>
                              <div className="entry-meta">
                                <span className="posted-on">
                                  <a href="#">August 17, 2021</a>
                                </span>
                                <span className="comments-link">
                                  <a href="#">No Comments</a>
                                </span>
                              </div>
                            </div>
                          </li>
                          <li>
                            <figure className="post-thumb">
                              <a href="#">
                                <img src="assets/images/img18.jpg" alt="" />
                              </a>
                            </figure>
                            <div className="post-content">
                              <h5>
                                <a href="#">
                                  Enjoying the beauty of the great nature
                                </a>
                              </h5>
                              <div className="entry-meta">
                                <span className="posted-on">
                                  <a href="#">August 17, 2021</a>
                                </span>
                                <span className="comments-link">
                                  <a href="#">No Comments</a>
                                </span>
                              </div>
                            </div>
                          </li>
                          <li>
                            <figure className="post-thumb">
                              <a href="#">
                                <img src="assets/images/img19.jpg" alt="" />
                              </a>
                            </figure>
                            <div className="post-content">
                              <h5>
                                <a href="#">
                                  Let’s start adventure with best tripo guides
                                </a>
                              </h5>
                              <div className="entry-meta">
                                <span className="posted-on">
                                  <a href="#">August 17, 2021</a>
                                </span>
                                <span className="comments-link">
                                  <a href="#">No Comments</a>
                                </span>
                              </div>
                            </div>
                          </li>
                          <li>
                            <figure className="post-thumb">
                              <a href="#">
                                <img src="assets/images/img34.jpg" alt="" />
                              </a>
                            </figure>
                            <div className="post-content">
                              <h5>
                                <a href="#">
                                  Journeys are best measured in new friends
                                </a>
                              </h5>
                              <div className="entry-meta">
                                <span className="posted-on">
                                  <a href="#">August 17, 2021</a>
                                </span>
                                <span className="comments-link">
                                  <a href="#">No Comments</a>
                                </span>
                              </div>
                            </div>
                          </li>
                          <li>
                            <figure className="post-thumb">
                              <a href="#">
                                <img src="assets/images/img35.jpg" alt="" />
                              </a>
                            </figure>
                            <div className="post-content">
                              <h5>
                                <a href="#">
                                  Take only memories, leave only footprints
                                </a>
                              </h5>
                              <div className="entry-meta">
                                <span className="posted-on">
                                  <a href="#">August 17, 2021</a>
                                </span>
                                <span className="comments-link">
                                  <a href="#">No Comments</a>
                                </span>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </aside>
                      <aside className="widget widget_social">
                        <h3 className="widget-title">Social share</h3>
                        <div className="social-icon-wrap">
                          <div className="social-icon social-facebook">
                            <a href="#">
                              <i className="fab fa-facebook-f"></i>
                              <span>Facebook</span>
                            </a>
                          </div>
                          <div className="social-icon social-pinterest">
                            <a href="#">
                              <i className="fab fa-pinterest"></i>
                              <span>Pinterest</span>
                            </a>
                          </div>
                          <div className="social-icon social-whatsapp">
                            <a href="#">
                              <i className="fab fa-whatsapp"></i>
                              <span>WhatsApp</span>
                            </a>
                          </div>
                          <div className="social-icon social-linkedin">
                            <a href="#">
                              <i className="fab fa-linkedin"></i>
                              <span>Linkedin</span>
                            </a>
                          </div>
                          <div className="social-icon social-twitter">
                            <a href="#">
                              <i className="fab fa-twitter"></i>
                              <span>Twitter</span>
                            </a>
                          </div>
                          <div className="social-icon social-google">
                            <a href="#">
                              <i className="fab fa-google-plus-g"></i>
                              <span>Google</span>
                            </a>
                          </div>
                        </div>
                      </aside>
                    </div>
                  </div> */}
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </>
  );
};

export default BlogsPage;
