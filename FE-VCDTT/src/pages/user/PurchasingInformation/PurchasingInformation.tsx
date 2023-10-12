import React, { useState, ChangeEvent } from "react";
import "./PurchasingInformation.css";
import { useLocation } from "react-router-dom";
import { useAddBillMutation } from "../../../api/bill";

type Props = {};

const PurchasingInformation = (props: Props) => {
  const[addBill] = useAddBillMutation();
  const location = useLocation();
  const {
    tourData,
    productNumber,
    productChildNumber,
    price,
    childPrice,
    formattedResultPrice,
    dateTour,
  } = location.state;
  const parts = dateTour.split("-");
  const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
  // Xử lý xác nhận thông tin form
  const [formData, setFormData] = useState({
    user_info: "",
    email: "",
    phone_number: "",
    message: "",
  });
  const handleChange = (
    e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement>
  ) => {
    const { name, value } = e.target;
    setFormData((prevFormData) => ({
      ...prevFormData,
      [name]: value,
    }));
  };

  const handleSubmit = (e: FormEvent) => {
    e.preventDefault();
    
    const variables = {
      user_info: formData.user_info,
      email: formData.email,
      phone_number: formData.phone_number,
      // Add other variables as needed
    };
  console.log(variables);
  
    addBill(variables)
      .then((response) => {
        // Handle the response here
      alert("mua thành công")
        console.log(response);
      

      })
      .catch((error) => {
        // Handle any errors here
        console.error(error);
      });

   
  };
  // console.log(onChange);
  const formattedTourPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price);
  const formattedTourChildPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(childPrice);
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
                  <form onSubmit={handleSubmit}>
                    <h3>Thông tin liên hệ</h3>
                    <div className="row">
                      <div className="col-sm-4">
                        <div className="form-group">
                          <label>Danh xưng</label>
                          <select className="input-border">
                            <option value="0">Ông</option>
                            <option value="0">Bà</option>
                            <option value="0">Cô</option>
                          </select>
                        </div>
                        {/* {selectedTitle === "" && <div className="validation-error">Please select a title.</div>} */}
                      </div>
                      <div className="col-sm-12">
                        <div className="form-group">
                          <label className="d-inline-flex">
                            Họ và tên <div className=" ml-1 text-danger">*</div>
                          </label>
                          <input
                            type="text"
                            name="user_info"
                            value={formData.user_info}
                            onChange={handleChange}
                            className="input-border"
                          />
                        </div>
                        {/* {nameError && <div className="validation-error text-danger">{nameError}</div>} */}
                      </div>

                      <div className="col-sm-6">
                        <div className="form-group">
                          <label className="d-inline-flex">
                            Số điện thoại{" "}
                            <div className=" ml-1 text-danger">*</div>
                          </label>
                          <input
                            type="text"
                            name="phone_number"
                            value={formData.phone_number}
                            onChange={handleChange}
                            className="input-border"
                          />
                        </div>
                        {/* {phoneNumberError && <div className="validation-error text-danger">{phoneNumberError}</div>} */}
                      </div>
                      <div className="col-sm-6">
                        <div className="form-group">
                          <label className="d-inline-flex">
                            Email <div className=" ml-1 text-danger">*</div>
                          </label>
                          <input
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            className="input-border"
                          />
                        </div>
                        {/* {emailError && <div className="validation-error text-danger">{emailError}</div>} */}
                      </div>
                      <div className="col-sm-12">
                        <div className="form-group">
                          <label>Yêu cầu đặc biệt </label>
                          <textarea
                            rows={6}
                            placeholder="Yêu cầu đặc biệt dành cho tour"
                            className="border"
                          ></textarea>
                        </div>
                      </div>
                    </div>

                    <h3>Thông tin địa điểm</h3>
                    <iframe
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.0877378831387!2d105.77566300940596!3d21.069157686311605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3134552c4daa2e41%3A0xc52e6ea7f463d8a0!2zNDk1IMSQLiBD4buVIE5odeG6vywgQ-G7lSBOaHXhur8sIFThu6sgTGnDqm0sIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1695805354232!5m2!1svi!2s"
                      width="600"
                      height="450"
                      style={{ border: 0 }}
                      loading="lazy"
                      referrerPolicy="no-referrer-when-downgrade"
                    ></iframe>

                    <h3 className="mt-4">Thanh toán</h3>
                    <div className="row mt-2">
                      <div className="col-sm-6">
                        <p>Giá bạn phải trả</p>
                      </div>

                      <div className="col-sm-6">
                        <p>{formattedResultPrice}</p>
                      </div>

                      <div className="col-sm-6">
                        <p>Trẻ em({productChildNumber}x)</p>
                        <p>Người lớn({productNumber}x)</p>
                      </div>

                      <div className="col-sm-6">
                        <p> {formattedTourPrice}</p>
                        <p>{formattedTourChildPrice}</p>
                      </div>
                      <div className="coupon-field">
                        {/* <label>Have a Coupon? <a href="#">Click here to enter your code</a></label> */}
                        <div className="form-group">
                          <input
                            type="text"
                            name="coupon"
                            placeholder="Nhập mã giảm giá"
                            className="input-border"
                          />
                          <input
                            type="submit"
                            name="submit"
                            value="Áp mã giảm giá"
                            className="border"
                          />
                        </div>
                      </div>
                    </div>
                    {/* Button trigger modal xác nhận thông tin */}
                    <button
                      type="button"
                      data-toggle="modal"
                      data-target="#confirmTourForm"
                      className="btn-continue"
                    >
                      Tiếp tục
                    </button>
                  </form>
                  {/* Modal xác nhận thông tin */}
                  <div className="">
                    <div
                      className="modal fade"
                      id="confirmTourForm"
                      role="dialog"
                      aria-labelledby="exampleModalLabel"
                      aria-hidden="true"
                    >
                      <div className="modal-dialog" role="document">
                        <div className="modal-content">
                          <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalLabel">
                              Xác nhận thông tin
                            </h5>
                            <button
                              type="button"
                              className="close"
                              data-dismiss="modal"
                              aria-label="Close"
                            >
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div className="modal-body">
                            <form onSubmit={handleSubmit}>
                              <div className="row">
                                <div className="form-group col-6">
                                  <label htmlFor="">Họ và tên</label>
                                  <input
                                    type="text"
                                    name="name"
                                    value={formData.user_info}
                                    disabled
                                  />{" "}
                                </div>
                                <div className="form-group col-6">
                                  <label htmlFor="">Số điện thoại</label>
                                  <input
                                    type="text"
                                    name="phone_number"
                                    value={formData.phone_number}
                                    disabled
                                  />{" "}
                                </div>
                                <div className="form-group col-6">
                                  <label htmlFor="">Email</label>
                                  <input
                                    type="email"
                                    name="email"
                                    value={formData.email}
                                    disabled
                                  />
                                </div>
                                <div className="form-group col-6">
                                  <label htmlFor="">Ngày đặt tour</label>
                                  <input
                                    type="text"
                                    name="tour_start_time"
                                    value={formattedDate}
                                    disabled
                                  />
                                </div>
                                <div className="form-group col-6">
                                  <label htmlFor="">Số lượng trẻ em</label>
                                  <input
                                    type="text"
                                    name="child_count"
                                    value={productChildNumber}
                                    disabled
                                  />
                                </div>
                                <div className="form-group col-6">
                                  <label htmlFor="">Số lượng người lớn</label>
                                  <input
                                    type="text"
                                    name="adult_count"
                                    value={productNumber}
                                    disabled
                                  />
                                </div>
                              </div>

                              <div className="form-group">
                                <label htmlFor="">Giá tour</label>
                                <input
                                  type="text"
                                  name="created_at"
                                  value={formattedResultPrice}
                                  disabled
                                />
                              </div>
                              <div className="form-group">
                                <label htmlFor="">Phương thức thanh toán</label>
                                <div className="mr-3">
                                  <input
                                    type="radio"
                                    name="payment_status"
                                    className="mr-2"
                                  />
                                  Tiền mặt
                                </div>
                                <input
                                  type="radio"
                                  name="payment_status"
                                  className="mr-2"
                                />
                                Ngân hàng
                              </div>
                              <button type="submit" className="btn btn-primary">
                                Xác nhận thanh toán
                              </button>
                            </form>
                          </div>
                          <div className="modal-footer">
                            <button
                              type="button"
                              className="btn btn-secondary"
                              data-dismiss="modal"
                            >
                              Close
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-md-4">
                <aside className="sidebar">
                  <div className="widget-bg widget-table-summary">
                    <h4 className="bg-title">Tóm tắt tour</h4>
                    <hr />
                    <h5 className="mt-2">{tourData?.data?.tour.name}</h5>
                    <figure className="feature-image">
                      <img src={tourData?.data?.tour.main_img} alt="" />
                    </figure>
                    <div className="row mt-2">
                      <div className="col-sm-6">
                        <p>Ngày đặt tour</p>
                      </div>

                      <div className="col-sm-6">
                        <p>{formattedDate}</p>
                      </div>

                      <div className="col-sm-6">
                        <p>Áp dụng cho</p>
                      </div>

                      <div className="col-sm-6">
                        <p>Người lớn : {productNumber}</p>
                        <p>Trẻ em : {productChildNumber}</p>
                      </div>
                    </div>
                  </div>
                </aside>
              </div>
            </div>
          </div>
        </div>
      </main>
    </>
  );
};

export default PurchasingInformation;
