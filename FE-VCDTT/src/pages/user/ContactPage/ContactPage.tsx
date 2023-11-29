import Loader from '../../../componenets/User/Loader';
import { useEffect, useRef } from 'react';
import emailjs from '@emailjs/browser';
import { useGetAddressQuery, useGetEmailWebQuery, useGetWebPhoneNumber1Query } from '../../../api/setting';
import { Setting } from '../../../interfaces/Setting';


const ContactPage = () => {
    const backgroundImageUrl = '../../../../assets/images/inner-banner.jpg'; 

    const containerStyle = {
      background: `url(${backgroundImageUrl})`,
      backgroundSize: 'cover', 
    }
    const form = useRef<HTMLFormElement>(null!);

    const sendEmail = (e: React.FormEvent<HTMLFormElement>) => {
      e.preventDefault();
    
      // Custom validation logic
      const formData = new FormData(form.current!);
      const userName = formData.get('user_name') as string;
      const userEmail = formData.get('user_email') as string;
      const userMessage = formData.get('message') as string;
    
      if (!userName || !userEmail || !userMessage) {
        alert('Please fill in all fields.');
        return;
      }
    
      // Additional validation checks...
    
      // Email sending logic
      emailjs.sendForm('service_16qayq1', 'template_k4djrti', form.current, 'Fxm2qPKfOG7-dvxv8')
        .then((result) => {
          console.log(result.text);
          alert('liên hệ thành công');
        })
        .catch((error) => {
          console.log(error.text);
          alert('liên hệ không thành công');
        });
    };
    
    const {data: dataPhone} = useGetWebPhoneNumber1Query()
    const {data: dataEmail} = useGetEmailWebQuery()
    const {data: dataAddress} = useGetAddressQuery()
    const iframeRef = useRef<HTMLIFrameElement>(null);

    useEffect(() => {
      if (dataAddress) {
        dataAddress.data.keyvalue.forEach(({ id, value }: Setting) => {
          const iframeSrc = `https://maps.google.com/maps?width=600&height=400&hl=en&q=${encodeURIComponent(
            value
          )}&t=&z=14&ie=UTF8&iwloc=B&output=embed`;
  
          const iframe = iframeRef.current;
          if (iframe) {
            iframe.src = iframeSrc;
          }
        });
      }
    }, [dataAddress]);
   
  return (
   <>
   <Loader/>
     <div id="page" className="full-page">
        
        <main id="content" className="site-main">
           {/* <!-- Inner Banner html start--> */}
           <section className="inner-banner-wrap">
              <div className="inner-baner-container" style={containerStyle}>
                 <div className="container">
                    <div className="inner-banner-content">
                       <h1 className="inner-title">Liên hệ chúng tôi</h1>
                    </div>
                 </div>
              </div>
              <div className="inner-shape"></div>
           </section>
           {/* <!-- Inner Banner html end-->
           <!-- contact form html start --> */}
           <div className="contact-page-section">
              <div className="contact-form-inner">
                 <div className="container">
                    <div className="row">
                       <div className="col-md-6">
                          <div className="contact-from-wrap">
                             <div className="section-heading">
                                <h5 className="dash-style">Liên Lạc</h5>
                                <h2>Liên hệ với chúng tôi để biết thêm thông tin</h2>
                               
                             </div>
                             <form className="contact-from" ref={form} onSubmit={sendEmail}>
                                 <label>Tên</label>
      <input type="text" name="user_name" required/>
      <label>Email</label>
      <input type="email" name="user_email" required/>
      <label>Tin nhắn</label>
      <textarea name="message" required />
      <input type="submit" value="Gửi" />
                             </form>
                          </div>
                       </div>
                       <div className="col-md-6">
                          <div className="contact-detail-wrap">
                             <h3>Cần giúp đỡ ?? Cứ liên lạc nếu cần !</h3>
                           
                             <div className="details-list">
                                <ul>
                                   <li>
                                      <span className="icon">
                                         <i className="fas fa-map-signs"></i>
                                      </span>
                                      <div className="details-content">
                                         <h4>ĐỊa chỉ</h4>
                                         {dataAddress?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                             <span key={id}>{value}</span>
                                         )
                                         })}
                                         
                                      </div>
                                   </li>
                                   <li>
                                      <span className="icon">
                                         <i className="fas fa-envelope-open-text"></i>
                                      </span>
                                      <div className="details-content">
                                         <h4>Email</h4>
                                         {dataEmail?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                             <span key={id}>{value}</span>
                                         )
                                         })}
                                      </div>
                                   </li>
                                   <li>
                                      <span className="icon">
                                         <i className="fas fa-phone-volume"></i>
                                      </span>
                                      <div className="details-content">
                                         <h4>Số điện thoại</h4>
                                         {dataPhone?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                             <span key={id}>{value}</span>
                                         )
                                         })}
                                      </div>
                                   </li>
                                </ul>
                             </div>
                             <div className="contct-social social-links">
                                <h3>Theo dõi chúng tôi trên mạng xã hội</h3>
                                <ul>
                                   <li><a href="#"><i className="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                                   <li><a href="#"><i className="fab fa-twitter" aria-hidden="true"></i></a></li>
                                   <li><a href="#"><i className="fab fa-instagram" aria-hidden="true"></i></a></li>
                                   <li><a href="#"><i className="fab fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
              <div className="map-section">
              <iframe
                            ref={iframeRef}
                            width="600"
                            height="450"
                            style={{ border: 0 }}
                            loading="lazy"
                            referrerPolicy="no-referrer-when-downgrade"
                          ></iframe>
               </div>
           </div>
           {/* <!-- contact form html end --> */}
        </main>
       
     </div>
   </>
  )
}

export default ContactPage