

const TourDetail = () => {
    const backgroundImageUrl = '../../../../assets/images/inner-banner.jpg'; // Đường dẫn tới hình ảnh nền

    const containerStyle = {
      background: `url(${backgroundImageUrl})`,
      backgroundSize: 'cover', 
    };
  return (
   <>
    <main id="content" className="site-main">
            {/* <!-- Inner Banner html start--> */}
            <section className="inner-banner-wrap">
               <div className="inner-baner-container" style={containerStyle}>
                  <div className="container">
                     <div className="inner-banner-content">
                        <h1 className="inner-title">Package Detail</h1>
                     </div>
                  </div>
               </div>
               <div className="inner-shape"></div>
            </section>
            {/* <!-- Inner Banner html end--> */}
            <div className="single-tour-section">
               <div className="container">
                  <div className="row">
                     <div className="col-lg-8">
                        <div className="single-tour-inner">
                           <h2>EXPERIENCE THE NATURAL BEAUTY OF ISLAND</h2>
                           <figure className="feature-image">
                              <img src="../../../../assets/images/img27.jpg" alt="" />
                              <div className="package-meta text-center">
                                 <ul>
                                    <li>
                                       <i className="far fa-clock"></i>
                                       6 days / 5 night
                                    </li>
                                    <li>
                                       <i className="fas fa-user-friends"></i>
                                       People: 4
                                    </li>
                                    <li>
                                       <i className="fas fa-map-marked-alt"></i>
                                       Norway
                                    </li>
                                 </ul>
                              </div>
                           </figure>
                           <div className="tab-container">
                              <ul className="nav nav-tabs" id="myTab" role="tablist">
                                 <li className="nav-item">
                                    <a className="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">DESCRIPTION</a>
                                 </li>
                                 <li className="nav-item">
                                    <a className="nav-link" id="program-tab" data-toggle="tab" href="#program" role="tab" aria-controls="program" aria-selected="false">PROGRAM</a>
                                 </li>
                                 <li className="nav-item">
                                    <a className="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">REVIEW</a>
                                 </li>
                                 <li className="nav-item">
                                    <a className="nav-link" id="map-tab" data-toggle="tab" href="#map" role="tab" aria-controls="map" aria-selected="false">Map</a>
                                 </li>
                              </ul>
                              <div className="tab-content" id="myTabContent">
                                 <div className="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                    <div className="overview-content">
                                       <p>Occaecat pariatur! Quaerat ligula, ab, consequuntur orci mus ultricies praesent aute blandit beatae nisl aut, totam mauris rhoncus? Tellus netus fringilla className auctor dui. Dolores excepteur, doloribus, blanditiis aliquip nisl. Occaecat iusto? Provident sociis rerum. Amet, asperiores molestie varius eos! Libero, fermentum fermentum totam! Sunt praesentium, totam. Excepteur platea nisl. Convallis aliquam? Iaculis erat ipsa molestie, quod, vestibulum reiciendis, maxime nostra, integer unde officiis quo integer unde officiis quo.</p>
                                       <p>Occaecat pariatur! Quaerat ligula, ab, consequuntur orci mus ultricies praesent aute blandit beatae nisl aut, totam mauris rhoncus? Tellus netus fringilla className auctor dui. Dolores excepteur, doloribus, blanditiis aliquip nisl..</p>
                                       <ul>
                                         <li>- Travel cancellation insurance</li> 
                                         <li>- Breakfast and dinner included</li>
                                         <li>- Health care included</li>
                                         <li>- Transfer to the airport and return to the agency</li>
                                         <li>- Lorem ipsum dolor sit amet, consectetur adipiscing</li>
                                       </ul>
                                    </div>
                                 </div>
                                 <div className="tab-pane" id="program" role="tabpanel" aria-labelledby="program-tab">
                                    <div className="itinerary-content">
                                       <h3>Program <span>( 4 days )</span></h3>
                                       <p>Dolores maiores dicta dolore. Natoque placeat libero sunt sagittis debitis? Egestas non non qui quos, semper aperiam lacinia eum nam! Pede beatae. Soluta, convallis irure accusamus voluptatum ornare saepe cupidatat.</p>
                                    </div>
                                    <div className="itinerary-timeline-wrap">
                                       <ul>
                                          <li>
                                             <div className="timeline-content">
                                                <div className="day-count">Day <span>1</span></div>
                                                <h4>Ancient Rome Visit</h4>
                                                <p>Nostra semper ultricies eu leo eros orci porta provident, fugit? Pariatur interdum assumenda, qui aliquip ipsa! Dictum natus potenti pretium.</p>
                                             </div>
                                          </li>
                                          <li>
                                             <div className="timeline-content">
                                                <div className="day-count">Day <span>2</span></div>
                                                <h4>Classic Rome Sightseeing</h4>
                                                <p>Nostra semper ultricies eu leo eros orci porta provident, fugit? Pariatur interdum assumenda, qui aliquip ipsa! Dictum natus potenti pretium.</p>
                                             </div>
                                          </li>
                                          <li>
                                             <div className="timeline-content">
                                                <div className="day-count">Day <span>3</span></div>
                                                <h4>Vatican City Visit</h4>
                                                <p>Nostra semper ultricies eu leo eros orci porta provident, fugit? Pariatur interdum assumenda, qui aliquip ipsa! Dictum natus potenti pretium.</p>
                                             </div>
                                          </li>
                                          <li>
                                             <div className="timeline-content">
                                                <div className="day-count">Day <span>4</span></div>
                                                <h4>Italian Food Tour</h4>
                                                <p>Nostra semper ultricies eu leo eros orci porta provident, fugit? Pariatur interdum assumenda, qui aliquip ipsa! Dictum natus potenti pretium.</p>
                                             </div>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <div className="tab-pane" id="review" role="tabpanel" aria-labelledby="review-tab">
                                    <div className="summary-review">
                                       <div className="review-score">
                                          <span>4.9</span>
                                       </div>
                                       <div className="review-score-content">
                                          <h3>
                                             Excellent
                                             <span>( Based on 24 reviews )</span>
                                          </h3>
                                          <p>Tincidunt iaculis pede mus lobortis hendrerit eveniet impedit aenean mauris qui, pharetra rem doloremque laboris euismod deserunt non, cupiditate, vestibulum.</p>
                                       </div>
                                    </div>
                                    {/* <!-- review comment html --> */}
                                    <div className="comment-area">
                                       <h3 className="comment-title">3 Reviews</h3>
                                       <div className="comment-area-inner">
                                          <ol>
                                             <li>
                                                <figure className="comment-thumb">
                                                   <img src="../../../../assets/images/img20.jpg" alt=""/>
                                                </figure>
                                                <div className="comment-content">
                                                   <div className="comment-header">
                                                      <h5 className="author-name">Tom Sawyer</h5>
                                                      <span className="post-on">Jana 10 2020</span>
                                                      <div className="rating-wrap">
                                                         <div className="rating-start" title="Rated 5 out of 5">
                                                            <span className="w-90"></span>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <p>Officia amet posuere voluptates, mollit montes eaque accusamus laboriosam quisque cupidatat dolor pariatur, pariatur auctor.</p>
                                                   <a href="#" className="reply"><i className="fas fa-reply"></i>Reply</a>
                                                </div>
                                             </li>
                                             <li>
                                                <ol>
                                                   <li>
                                                      <figure className="comment-thumb">
                                                         <img src="../../../../assets/images/img21.jpg" alt=""/>
                                                      </figure>
                                                      <div className="comment-content">
                                                         <div className="comment-header">
                                                            <h5 className="author-name">John Doe</h5>
                                                            <span className="post-on">Jana 10 2020</span>
                                                            <div className="rating-wrap">
                                                               <div className="rating-start" title="Rated 5 out of 5">
                                                                  <span className="w-90"></span>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <p>Officia amet posuere voluptates, mollit montes eaque accusamus laboriosam quisque cupidatat dolor pariatur, pariatur auctor.</p>
                                                         <a href="#" className="reply"><i className="fas fa-reply"></i>Reply</a>
                                                      </div>
                                                   </li>
                                                </ol>
                                             </li>
                                          </ol>
                                          <ol>
                                             <li>
                                                <figure className="comment-thumb">
                                                   <img src="../../../../assets/images/img22.jpg" alt=""/>
                                                </figure>
                                                <div className="comment-content">
                                                   <div className="comment-header">
                                                      <h5 className="author-name">Jaan Smith</h5>
                                                      <span className="post-on">Jana 10 2020</span>
                                                      <div className="rating-wrap">
                                                         <div className="rating-start" title="Rated 5 out of 5">
                                                            <span></span>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <p>Officia amet posuere voluptates, mollit montes eaque accusamus laboriosam quisque cupidatat dolor pariatur, pariatur auctor.</p>
                                                   <a href="#" className="reply"><i className="fas fa-reply"></i>Reply</a>
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
                                                <input type="text" name="name" placeholder="Name" />
                                             </p>
                                             <p>
                                                <input type="text" name="name" placeholder="Last name"/>
                                             </p>
                                             <p>
                                                <input type="email" name="email" placeholder="Email"/>
                                             </p>
                                             <p>
                                                <input type="text" name="subject" placeholder="Subject"/>
                                             </p>
                                             <p>
                                                <textarea rows={6} placeholder="Your review"></textarea>
                                             </p>
                                             <p>
                                                <input type="submit" name="submit" value="Submit" />
                                             </p>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                                 <div className="tab-pane" id="map" role="tabpanel" aria-labelledby="map-tab">
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
                     <div className="col-lg-4">
                        <div className="sidebar">
                           <div className="package-price">
                              <h5 className="price">
                                 <span>$649</span> / per person
                              </h5>
                              <div className="start-wrap">
                                 <div className="rating-start" title="Rated 5 out of 5">
                                    <span className="w-60"></span>
                                 </div>
                              </div>
                           </div>
                           <div className="widget-bg booking-form-wrap">
                              <h4 className="bg-title">Booking</h4>
                              <form className="booking-form">
                                 <div className="row">
                                    <div className="col-sm-12">
                                       <div className="form-group">
                                          <input name="name_booking" type="text" placeholder="Full Name"/>
                                       </div>
                                    </div>
                                    <div className="col-sm-12">
                                       <div className="form-group">
                                          <input name="email_booking" type="text" placeholder="Email"/>
                                       </div>
                                    </div>
                                    <div className="col-sm-12">
                                       <div className="form-group">
                                          <input name="phone_booking" type="text" placeholder="Number"/>
                                       </div>
                                    </div>
                                    <div className="col-sm-12">
                                       <div className="form-group">
                                          <input className="input-date-picker" type="text" name="s" autoComplete="off" placeholder="Date"/>
                                       </div>
                                    </div>
                                    <div className="col-sm-12">
                                       <h4 className="">Add Options</h4>
                                    </div>
                                    <div className="col-sm-6">
                                       <div className="form-group">
                                          <label className="checkbox-list">
                                             <input type="checkbox" name="s" />
                                             <span className="custom-checkbox"></span>
                                             Tour guide
                                          </label>
                                       </div>
                                    </div>
                                    <div className="col-sm-6">
                                       <div className="form-group">
                                          <label className="checkbox-list">
                                             <input type="checkbox" name="s" />
                                             <span className="custom-checkbox"></span>
                                             Insurance 
                                          </label>
                                       </div>
                                    </div>
                                    <div className="col-sm-6">
                                       <div className="form-group">
                                          <label className="checkbox-list">
                                             <input type="checkbox" name="s"/>
                                             <span className="custom-checkbox"></span>
                                             Dinner
                                          </label>
                                       </div>
                                    </div>
                                    <div className="col-sm-6">
                                       <div className="form-group">
                                          <label className="checkbox-list">
                                             <input type="checkbox" name="s"/>
                                             <span className="custom-checkbox"></span>
                                             Bike rent
                                          </label>
                                       </div>
                                    </div>
                                    <div className="col-sm-12">
                                       <div className="form-group submit-btn">
                                          <input type="submit" name="submit" value="Boook Now"/>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                           <div className="widget-bg information-content text-center">
                              <h5>TRAVEL TIPS</h5>
                              <h3>NEED TRAVEL RELATED TIPS & INFORMATION</h3>
                              <p>Mollit voluptatem perspiciatis convallis elementum corporis quo veritatis aliquid blandit, blandit torquent, odit placeat. </p>
                              <a href="#" className="button-primary">GET A QUOTE</a>
                           </div>
                          
                        </div>
                     </div>
                  </div>
               </div>
            </div>
           
         </main>
   </>
  )
}

export default TourDetail