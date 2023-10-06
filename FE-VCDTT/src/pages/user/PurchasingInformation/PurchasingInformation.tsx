import React from 'react'

type Props = {}

const PurchasingInformation = (props: Props) => {
  return (
   <>
    <main id="content" className="site-main">
            {/* <!-- Inner Banner html start--> */}
            <section className="inner-banner-wrap">
               <div className="inner-baner-container">
                  <div className="container">
                     <div className="inner-banner-content">
                        <h1 className="inner-title">Checkout</h1>
                     </div>
                  </div>
               </div>
               <div className="inner-shape"></div>
            </section>
            {/* <!-- Inner Banner html end--> */}
            <div className="checkout-section">
               <div className="container">
                  <div className="row">
                     <div className="col-md-8 right-sidebar">
                        <div className="checkout-field-wrap">
                           <h3>Thông tin liên hệ</h3> 
                           <div className="coupon-field">
                              <label>Have a Coupon? <a href="#">Click here to enter your code</a></label>
                              <div className="form-group">
                                 <input type="text" name="coupon" placeholder="Coupon code"/>
                                 <input type="submit" name="submit" value="Apply coupon"/>
                              </div>
                           </div>
                           <div className="row">
                              <div className="col-sm-6">
                                 <div className="form-group">
                                   <label>First Name *</label>
                                   <input type="text" name="name"/>
                                 </div>
                              </div>
                            <div className="col-sm-6">
                              <div className="form-group">
                                <label>last Name *</label>
                                <input type="text" name="name"/>
                              </div>
                            </div>
                            <div className="col-sm-12">
                              <div className="form-group">
                                 <label>Company Name (optional)</label>
                                 <input type="text" name="name"/>
                              </div>
                            </div>
                            <div className="col-sm-12">
                              <div className="form-group">
                                 <label>Country *</label>
                                 <select>
                                    <option value="0">France</option>
                                    <option value="0">England</option>
                                    <option value="0">Brazil</option>
                                 </select>
                              </div>
                            </div>
                            <div className="col-sm-12">
                              <label>Street address *</label>
                              <div className="row">
                                 <div className="col-sm-6">
                                    <div className="form-group">
                                       <input type="text" name="name" placeholder="Street name"/>
                                    </div>
                                 </div>
                                 <div className="col-sm-6">
                                    <div className="form-group">
                                       <input type="text" name="address" placeholder="Street name (optional)"/>
                                    </div>
                                 </div>
                              </div>
                            </div>
                            <div className="col-sm-6">
                              <div className="form-group">
                                 <label>Postcode / ZIP *</label>
                                 <input type="text" name="name"/>
                              </div>
                            </div>
                            <div className="col-sm-6">
                              <div className="form-group">
                                 <label>Town / City *</label>
                                 <input type="text" name="name"/>
                              </div>
                            </div>
                            <div className="col-sm-6">
                              <div className="form-group">
                                 <label>Province *</label>
                                 <select>
                                    <option value="0">Bedfordshire</option>
                                    <option value="0">Essex</option>
                                    <option value="0">Suffolk</option>
                                 </select>
                              </div>
                            </div>
                            <div className="col-sm-6">
                              <div className="form-group">
                                 <label>Phone *</label>
                                 <input type="text" name="name"/>
                              </div>
                            </div>
                            <div className="col-sm-12">
                              <div className="form-group">
                                 <label>Email address *</label>
                                 <input type="email" name="name"/>
                              </div>
                            </div>
                            <div className="col-sm-12">
                              <div className="form-group">
                                 <label>Additional Informarion </label>
                                 <textarea rows={6} placeholder="Notes about your order, eg.special notes for delivery"></textarea>
                              </div>
                            </div>
                           </div>
                        </div>
                     </div>
                     <div className="col-md-4">
                        <aside className="sidebar">
                           <div className="widget-bg widget-table-summary">
                              <h4 className="bg-title">Our order</h4>
                              <table>
                                 <tbody>
                                    <tr>
                                       <td>
                                          Album X 1
                                       </td>
                                       <td className="text-right">
                                          $300
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          Beanie X 5
                                       </td>
                                       <td className="text-right">
                                          $34
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <strong>Subtotal</strong>
                                       </td>
                                       <td className="text-right">
                                          $334
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          tax
                                       </td>
                                       <td className="text-right">
                                          13%
                                       </td>
                                    </tr>
                                    <tr className="total">
                                       <td>
                                          <strong>Total cost</strong>
                                       </td>
                                       <td className="text-right">
                                          <strong>$480</strong>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <div className="widget-bg widget-paymet-bank">
                              <div className="payment-wrap">
                                 <h4 className="bg-title">Payment</h4>
                                 <div className="form-group">
                                    <div className="custom-radio-field">
                                       <label>
                                          <input type="radio" checked name="s" value="1"/>
                                          <span className="radio-field"></span>
                                          Direct bank transfer
                                       </label>
                                    </div>
                                    <div className="desc">
                                       Make your payment directly into our bank accound. please use your Order ID as the payment reference. Your order will not not be shipped until the funds have cleared in our account.
                                    </div>
                                 </div>
                                 <div className="form-group">
                                    <div className="custom-radio-field">
                                       <label>
                                          <input type="radio" name="s" value="2"/>
                                          <span className="radio-field"></span>
                                          Check payment
                                       </label>
                                    </div>
                                 </div>
                                 <div className="form-group">
                                    <div className="custom-radio-field">
                                       <label>
                                          <input type="radio" name="s" value="3"/>
                                          <span className="radio-field"></span>
                                          Cash on delivery
                                       </label>
                                    </div>
                                 </div>
                                 <div className="form-group">
                                    <div className="custom-radio-field">
                                       <label>
                                          <input type="radio" name="s" value="4"/>
                                          <span className="radio-field"></span>
                                          Paypal
                                          <img src="assets/images/cards.png" alt=""/>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                              <button className="button-primary">Place Order</button>
                           </div>
                        </aside>
                     </div>
                  </div>
               </div>
            </div>
         </main>
   </>
  )
}

export default PurchasingInformation