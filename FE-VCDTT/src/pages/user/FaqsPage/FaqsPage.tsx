import Loader from '../../../componenets/User/Loader';
import { useGetFaqsQuery } from '../../../api/faqs';
import { Faq } from '../../../interfaces/Faq';
import SecondaryBanner from '../../../componenets/User/SecondaryBanner';


const FaqsPage = () => {
   const {data} = useGetFaqsQuery();
   console.log(data);
   
   //  const backgroundImageUrl = 'assets/images/inner-banner.jpg'; 

   //  const containerStyle = {
   //    background: `url(${backgroundImageUrl})`,
   //    backgroundSize: 'cover', 
   //  };
   const dataTitle = "Faqs"
  return (
    <>
    <Loader/>
    <div id="page" className="full-page">
       
       <main id="content" className="site-main">
          {/* <!-- Inner Banner html start--> */}

          <SecondaryBanner>{dataTitle}</SecondaryBanner>
          {/* <section className="inner-banner-wrap">
             <div className="inner-baner-container" style={containerStyle}>
                <div className="container">
                   <div className="inner-banner-content">
                      <h1 className="inner-title">Faq</h1>
                   </div>
                </div>
             </div>
             <div className="inner-shape"></div>
          </section> */}
          {/* <!-- Inner Banner html end-->
          <!-- faq html start --> */}
          <div className="faq-page-section">
             <div className="container">
                <div className="faq-page-container">
                   <div className="row">
                      <div className="col-lg-6">
                         <div className="faq-content-wrap">
                            <div className="section-heading">
                               <h5 className="dash-style">Mọi câu hỏi</h5>
                               <h2>Một số câu hỏi thường gặp</h2>
                               
                            </div>
                            <div className="accordion" id="accordionOne">
                            {data?.data?.faqs?.map(({id,question,answer}: Faq)=>{
    return(
      
      <div className="card" key={id}>
      <div className="card-header" id="headingOne">
         <h4 className="mb-0">
            <button className="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
             {question}
            </button>
         </h4>
      </div>
      <div id="collapseOne" className="collapse" aria-labelledby="headingOne" data-parent="#accordionOne">
         <div className="card-body">
          {answer}
         </div>
      </div>
   </div>
   
    )
})
}

                               {/* <div className="card">
                                  <div className="card-header" id="headingOne">
                                     <h4 className="mb-0">
                                        <button className="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                         HOW WE BECAME BEST AMONG OTHERS?
                                        </button>
                                     </h4>
                                  </div>
                                  <div id="collapseOne" className="collapse" aria-labelledby="headingOne" data-parent="#accordionOne">
                                     <div className="card-body">
                                       Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                     </div>
                                  </div>
                               </div>
                               <div className="card">
                                  <div className="card-header" id="headingTwo">
                                     <h4 className="mb-0">
                                        <button className="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                           WHAT WE OFFER TO YOU?
                                        </button>
                                     </h4>
                                  </div>
                                  <div id="collapseTwo" className="collapse" aria-labelledby="headingTwo" data-parent="#accordionOne">
                                     <div className="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                     </div>
                                  </div>
                               </div>
                               <div className="card">
                                  <div className="card-header" id="headingThree">
                                     <h4 className="mb-0">
                                        <button className="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                           HOW WE PROVIDE SERVICES FOR YOU?
                                        </button>
                                     </h4>
                                  </div>
                                  <div id="collapseThree" className="collapse" aria-labelledby="headingThree" data-parent="#accordionOne">
                                     <div className="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                     </div>
                                  </div>
                               </div>
                               <div className="card">
                                  <div className="card-header" id="headingFour">
                                     <h4 className="mb-0">
                                        <button className="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                           ARE WE AFFORDABLE TO HIRE?
                                        </button>
                                     </h4>
                                  </div>
                                  <div id="collapseFour" className="collapse" aria-labelledby="headingFour" data-parent="#accordionOne">
                                     <div className="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                     </div>
                                  </div>
                               </div> */}
                            </div>      
                         </div>
                      </div>
                      <div className="col-lg-6">
                         <div className="qsn-form-container">
                            <h3>STILL HAVE A QUESTION?</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullam corper</p>
                            <form>
                               <p>
                                  <input type="text" name="name" placeholder="Your Name*"/>
                               </p>
                               <p>
                                  <input type="email" name="email" placeholder="Your Email*"/>
                               </p>
                               <p>
                                  <input type="number" name="number" placeholder="Your Number*"/>
                               </p>
                               <p>
                                  <textarea rows={8} placeholder="Enter your message"/>
                               </p>
                               <p>
                                  <input type="submit" name="submit" value="SUBMIT QUESTIONS" />
                               </p>
                            </form>
                         </div>
                      </div>
                   </div>
                </div>
                <div className="faq-page-container">
                   <div className="row">
                      <div className="col-lg-5">
                         <div className="faq-testimonial">
                            <figure className="faq-image">
                               <img src="assets/images/img37.jpg" alt="" />
                            </figure>
                            <div className="testimonial-content">
                               <span className="quote-icon">
                                  <i className="fas fa-quote-left"></i>
                               </span>
                               <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."</p>
                            </div>
                         </div>
                      </div>
                      <div className="col-lg-7">
                         <div className="faq-content-wrap pl-20">
                            <div className="section-heading">
                               <h5 className="dash-style">QUESTIONS/ANSWERS</h5>
                               <h2>BENEFITS & WHAT WE DO?</h2>
                            </div>
                            <div className="accordion" id="accordionTwo">
                               <div className="card">
                                  <div className="card-header" id="headingOne">
                                     <h4 className="mb-0">
                                        <button className="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                           HOW DO YOU MANAGE TO TRAVEL THE WORLD?
                                        </button>
                                     </h4>
                                  </div>
                                  <div id="collapseOne" className="collapse" aria-labelledby="headingOne" data-parent="#accordionTwo">
                                     <div className="card-body">
                                       Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                     </div>
                                  </div>
                               </div>
                               <div className="card">
                                  <div className="card-header" id="headingTwo">
                                     <h4 className="mb-0">
                                        <button className="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                           HOW DID YOU MANAGE YOUR CLIENTS?
                                        </button>
                                     </h4>
                                  </div>
                                  <div id="collapseTwo" className="collapse" aria-labelledby="headingTwo" data-parent="#accordionTwo">
                                     <div className="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                     </div>
                                  </div>
                               </div>
                               <div className="card">
                                  <div className="card-header" id="headingThree">
                                     <h4 className="mb-0">
                                        <button className="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                           HOW TO TRAVEL WITH YOUR TIPS?
                                        </button>
                                     </h4>
                                  </div>
                                  <div id="collapseThree" className="collapse" aria-labelledby="headingThree" data-parent="#accordionTwo">
                                     <div className="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                     </div>
                                  </div>
                               </div>
                               <div className="card">
                                  <div className="card-header" id="headingFour">
                                     <h4 className="mb-0">
                                        <button className="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                           WHAT LOW BUDGET DESTINATIONS DO YOU RECOMMEND?
                                        </button>
                                     </h4>
                                  </div>
                                  <div id="collapseFour" className="collapse" aria-labelledby="headingFour" data-parent="#accordionTwo">
                                     <div className="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                     </div>
                                  </div>
                               </div>
                            </div>      
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          {/* <!-- faq html end --> */}
       </main>
    </div>
    </>
  )
}

export default FaqsPage