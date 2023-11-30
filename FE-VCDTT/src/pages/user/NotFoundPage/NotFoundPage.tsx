const NotFoundPage = () => { 
    const backgroundImageUrl = '../../../../assets/images/404-img.jpg'; 

  const containerStyle = {
    background: `url(${backgroundImageUrl})`,
    backgroundSize: 'cover',
  };
  return (
   <>
   <div id="page" className="full-page">
        
        <main id="content" className="site-main" style={containerStyle}>
           <div className="no-content-section 404-page" >
              <div className="container">
                 <div className="no-content-wrap">
                    <span>404</span>
                    <h1>Oops! That page can't be found</h1>
                    <h4>It looks like nothing was found at this location. Maybe try one of the links below or a search?</h4>
                    
                 </div>
              </div>
              <div className="overlay"></div>
           </div>
        </main>
       
        <a id="backTotop" href="#" className="to-top-icon">
           <i className="fas fa-chevron-up"></i>
        </a>
        {/* <!-- custom search field html --> */}
           <div className="header-search-form" >
              <div className="container">
                 <div className="header-search-container">
                    <form className="search-form" role="search" method="get" >
                       <input type="text" name="s" placeholder="Enter your text..." />
                    </form>
                    <a href="#" className="search-close">
                       <i className="fas fa-times"></i>
                    </a>
                 </div>
              </div>
           </div>
        {/* <!-- header html end --> */}
     </div>
   </>
  )
}

export default NotFoundPage