import Loader from '../../../componenets/User/Loader';
import { useGetFaqsQuery } from '../../../api/faqs';
import { Faq } from '../../../interfaces/Faq';
import SecondaryBanner from '../../../componenets/User/SecondaryBanner';
import { useState } from 'react';
import ReactPaginate from 'react-paginate';


const FaqsPage = () => {
   const {data} = useGetFaqsQuery();
   console.log(data);
   
   //  const backgroundImageUrl = 'assets/images/inner-banner.jpg'; 

   //  const containerStyle = {
   //    background: `url(${backgroundImageUrl})`,
   //    backgroundSize: 'cover', 
   //  };
   const dataTitle = "Faqs"

   //Phâm tramg
   const [currentPage, setCurrentPage] = useState<number>(0);
   const handlePageChange = (selectedPage: { selected: number }) => {
     setCurrentPage(selectedPage.selected);
   };
   const itemsPerPage = 8;
   const pageCount = Math.ceil(
      data?.data?.faqs.length / itemsPerPage
   );
   const currentData: Faq[] = (data?.data?.faqs.slice(
     currentPage * itemsPerPage,
     (currentPage + 1) * itemsPerPage
   ) || []) as Faq[];

   //end
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
                      <div className="col-lg-12">
                         <div className="faq-content-wrap">
                            <div className="section-heading">
                               <h5 className="dash-style">Mọi câu hỏi</h5>
                               <h2>Một số câu hỏi thường gặp</h2>
                               
                            </div>
                            <div className="accordion" id="accordionOne">
                            {currentData?.map(({ id, question, answer }: Faq) => {
  const collapseId = `collapse${id}`;
  return (
    <div className="card" key={id}>
      <div className="card-header" id={`heading${id}`}>
        <h4 className="mb-0">
          <button
            className="btn btn-link"
            type="button"
            data-toggle="collapse"
            data-target={`#${collapseId}`}
            aria-expanded="false"
            aria-controls={collapseId}
          >
            {question}
          </button>
        </h4>
      </div>
      <div
        id={collapseId}
        className="collapse"
        aria-labelledby={`heading${id}`}
        data-parent="#accordionOne"
      >
        <div className="card-body">  <p
                                            className=""
                                            dangerouslySetInnerHTML={{
                                              __html: answer||""
                                            }}
                                          ></p></div>
      </div>
    </div>
  );
})}
 <ReactPaginate
                previousLabel={"<-"}
                nextLabel={"->"}
                breakLabel={"..."}
                pageCount={pageCount}
                onPageChange={handlePageChange}
                containerClassName={"pagination"}
                activeClassName={"active"}
              />


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