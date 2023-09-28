import React from 'react'

type Props = {}

const BlogDetail = (props: Props) => {
    const backgroundImageUrl = '../../../../assets/images/inner-banner.jpg'; 

    const containerStyle = {
      background: `url(${backgroundImageUrl})`,
      backgroundSize: 'cover', 
    };

  return (
   <>
   <div id="page" className="full-page">
        
        <main id="content" className="site-main">
           {/* <!-- Inner Banner html start--> */}
           <section className="inner-banner-wrap">
              <div className="inner-baner-container" style={containerStyle}>
                 <div className="container">
                    <div className="inner-banner-content">
                       <h1 className="inner-title">Journeys are best measured in new friends</h1>
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
                 </div>
              </div>
              <div className="inner-shape"></div>
           </section>
           {/* <!-- Inner Banner html end--> */}
           <div className="single-post-section">
              <div className="single-post-inner">
                 <div className="container">
                    <div className="row">
                       <div className="col-lg-8 primary right-sidebar">
                          {/* <!-- single blog post html start --> */}
                          <figure className="feature-image">
                             <img src="../../../../assets/images/img30.jpg" alt=""/>
                          </figure>
                          <article className="single-content-wrap">
                             <h3>Cupiditate hic provident, repudiandae delectus debitis hac alias curabitur, sequi minim sapien scelerisque dolorem id.</h3>
                             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis varius ligula non tellus euismod fermentum. Nulla quis enim ut est dapibus luctus quis quis enim. Ut bibendum ultricies nisl ut aliquam. Ut in arcu id nunc elementum ultricies eu eget lacus nam at neque lorem.</p>
                             <blockquote>
                                <p>Sagittis perferendis? Leo nobis irure egestas excepturi ipsam nascetur elementum, montes. Torquent, soluta, ac nihil.</p>
                             </blockquote>
                             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis varius ligula non tellus euismod fermentum. Nulla quis enim ut est dapibus luctus quis quis enim. Ut bibendum ultricies nisl ut aliquam. Ut in arcu id nunc elementum ultricies eu eget lacus nam at neque lorem.</p>
                          </article>
                          <div className="meta-wrap">
                             <div className="tag-links">
                                <a href="#">Destination</a>,
                                <a href="#">hiking</a>,
                                <a href="#">Travel Dairies</a>,
                                <a href="#">Travelling</a>,
                                <a href="#">Trekking</a>
                             </div>
                          </div>
                          <div className="post-socail-wrap">
                             <div className="social-icon-wrap">
                                <div className="social-icon social-facebook">
                                   <a href="#">
                                      <i className="fab fa-facebook-f"></i>
                                      <span>Facebook</span>
                                   </a>
                                </div>
                                <div className="social-icon social-google">
                                   <a href="#">
                                      <i className="fab fa-google-plus-g"></i>
                                      <span>Google</span>
                                   </a>
                                </div>
                                <div className="social-icon social-pinterest">
                                   <a href="#">
                                      <i className="fab fa-pinterest"></i>
                                      <span>Pinterest</span>
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
                             </div>
                          </div>
                          <div className="author-wrap">
                             <div className="author-thumb">
                                <img src="../../../../assets/images/user-img.png" alt="" />
                             </div>
                             <div className="author-content">
                                <h3 className="author-name">Demoteam</h3>
                                <p>Anim eligendi error magnis. Pretium fugiat cubilia ullamcorper adipisci, lobortis repellendus sit culpa maiores!</p>
                                <a href="#" className="button-text">VIEW ALL POSTS  </a>
                             </div>
                          </div>
                          {/* <!-- post comment html -->
                         
                          <!-- blog post item html end --> */}
                       </div>
                       <div className="col-lg-4 secondary">
                          <div className="sidebar">
                             <aside className="widget author_widget">
                                <h3 className="widget-title">ABOUT AUTHOR</h3>
                                <div className="widget-content text-center"> 
                                   <div className="profile"> 
                                      <figure className="avatar"> 
                                         <a href="#"> 
                                            <img src="../../../../assets/images/img21.jpg" alt="" /> 
                                         </a> 
                                      </figure> 
                                      <div className="text-content"> 
                                         <div className="name-title"> 
                                            <h3> 
                                               <a href="https://demo.bosathemes.com/bosa/photography/james-watson/">James Watson</a>
                                            </h3> 
                                         </div> 
                                         <p>Accumsan? Aliquet nobis doloremque, aliqua? Inceptos voluptatem, duis tempore optio quae animi viverra distinctio cumque vivamus, earum congue, anim velit</p> 
                                      </div> 
                                      <div className="socialgroup"> 
                                         <ul> 
                                            <li> <a target="_blank" href="#"> <i className="fab fa-facebook"></i> </a> </li> 
                                            <li> <a target="_blank" href="#"> <i className="fab fa-google"></i> </a> </li> 
                                            <li> <a target="_blank" href="#"> <i className="fab fa-twitter"></i> </a> </li> 
                                            <li> <a target="_blank" href="#"> <i className="fab fa-instagram"></i> </a> </li> 
                                            <li> <a target="_blank" href="#"> <i className="fab fa-pinterest"></i> </a> </li> 
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
                                         <a href="#"><img src="../../../../assets/images/img17.jpg" alt="" /></a>
                                      </figure>
                                      <div className="post-content">
                                         <h5>
                                            <a href="#">Someday I’m going to be free and travel</a>
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
                                         <a href="#"><img src="../../../../assets/images/img18.jpg" alt="" /></a>
                                      </figure>
                                      <div className="post-content">
                                         <h5>
                                            <a href="#">Enjoying the beauty of the great nature</a>
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
                                         <a href="#"><img src="../../../../assets/images/img19.jpg" alt="" /></a>
                                      </figure>
                                      <div className="post-content">
                                         <h5>
                                            <a href="#">Let’s start adventure with best tripo guides</a>
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
                                         <a href="#"><img src="../../../../assets/images/img34.jpg" alt="" /></a>
                                      </figure>
                                      <div className="post-content">
                                         <h5>
                                            <a href="#">Journeys are best measured in new friends</a>
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
                                         <a href="#"><img src="../../../../assets/images/img35.jpg" alt="" /></a>
                                      </figure>
                                      <div className="post-content">
                                         <h5>
                                            <a href="#">Take only memories, leave only footprints</a>
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
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </main>
     </div>
   </>
  )
}

export default BlogDetail