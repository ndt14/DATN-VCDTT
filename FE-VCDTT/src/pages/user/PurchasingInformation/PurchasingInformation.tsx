import React, { useState, ChangeEvent, useEffect, FormEvent } from "react";
import "./PurchasingInformation.css";
import { useLocation } from "react-router-dom";
import { useAddBillMutation } from "../../../api/bill";
import { useCheckCouponMutation } from "../../../api/coupon";
import { useFormik } from "formik";
import * as Yup from "yup";
import { useNavigate } from "react-router-dom";

type Props = {};

const PurchasingInformation = (props: Props) => {
  //validate
  interface FormValues {
    name: string;
    email: string;
    phone_number: string;
    message: string;
    honorific: string;
  }
  const formik = useFormik<FormValues>({
    initialValues: {
      name: "",
      email: "",
      phone_number: "",
      message: "",
      honorific: "",
    },
    validationSchema: Yup.object({
      name: Yup.string().required("Nhập tên"),
      email: Yup.string()
        .email("Sai định dạng email")
        .required("Email không được để trống"),
      phone_number: Yup.string().required("Nhập số điện thoại"),
      honorific: Yup.string().required("Please select an option"),
    }),
    onSubmit: (values) => {
      console.log(values);
    },
    validateOnMount: true,
  });

  useEffect(() => {
    formik.validateForm();
  }, []);

  const isSubmitDisabled = Object.keys(formik.errors).length > 0;
  //
  const navigate = useNavigate();

  const [checkCoupon] = useCheckCouponMutation();
  const [addBill] = useAddBillMutation();
  const location = useLocation();
  const {
    tourData,
    productNumber,
    productChildNumber,
    price,
    childPrice,
    formattedResultPrice,
    dateTour,
    tourName,
    tourLocation,
    tourPrice,
    tourChildPrice,
  } = location.state;
  const parts = dateTour.split("-");
  const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
  const userData = JSON.parse(localStorage.getItem("user"));
  const userName = userData?.name;
  const userId = userData?.id;
  const userEmail = userData?.email;
  const phoneNumber = userData?.phone_number;
  const userAddress = userData?.address;
  const userLogIn = localStorage.getItem("isLoggedIn");

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
  // Coupon
  const [percentage, setPercentage] = useState<number>(0);
  const [couponName, setCouponName] = useState();
  const [formCoupon, setFormCoupon] = useState({
    user_id: userId ? userId : "",
    coupon_code: "",
  });

  const finalPrice =
    ((productNumber * price + productChildNumber * childPrice) *
      (100 - percentage)) /
    100;
  // console.log(finalPrice);
  const formattedFinalPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(finalPrice);

  const handleCouponChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setFormCoupon((prevValues) => ({
      ...prevValues,
      [name]: value,
    }));
  };

  const handleCouponSubmit = (e: FormEvent) => {
    e.preventDefault();
    // console.log(formCoupon);
    checkCoupon(formCoupon)
      .then((response) => {
        alert(response?.data?.message);
        const discount = response?.data?.coupon.percentage_price;
        const coupon_name = response?.data?.coupon.name;
        console.log(coupon_name);
        setPercentage(discount);
        setCouponName(coupon_name);
      })
      .catch((error) => {
        // Handle any errors here
        console.error(error);
      });
  };
  //

  const handleSubmit = (e: FormEvent) => {
    e.preventDefault();

    const variables = {
      name: formik.values.name,
      user_id: userId,
      tour_name: tourName,
      child_count: productChildNumber,
      adult_count: productNumber,
      tour_start_time: formattedDate,
      tour_location: tourLocation,
      tour_child_price: tourChildPrice,
      tour_adult_price: tourPrice,
      email: formik.values.email,
      phone_number: formik.values.phone_number,
      suggestion: formik.values.message,
      gender: parseInt(formik.values.honorific),
      coupon_name: couponName,
      coupon_percentage: percentage,
      tour_sale_percentage: 0,
    };
    console.log(variables);
    console.log(couponName);
    localStorage.setItem("tempUser", JSON.stringify(variables));

    addBill(variables)
      .then((response) => {
        alert("Đặt tour thành công");
        const billID = response?.data?.data?.purchase_history.id;
        console.log(billID);
        localStorage.setItem("billIdSuccess", JSON.stringify(billID));
        const VnpayURL = `http://be-vcdtt.datn-vcdtt.test/api/vnpay-payment/${billID}`;
        window.location.href = VnpayURL;
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
                  <form onSubmit={formik.handleSubmit}>
                    <h3>Thông tin liên hệ</h3>
                    <div className="row">
                      <div className="col-sm-4">
                        <div className="form-group">
                          <label>Danh xưng</label>
                          <select
                            className="input-border"
                            name="honorific"
                            value={formik.values.honorific}
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                          >
                            <option value="">-- Lựa chọn --</option>
                            <option value="1">Ông</option>
                            <option value="2">Bà</option>
                            <option value="3">Khác</option>
                          </select>
                          {formik.touched.honorific &&
                            formik.errors.honorific && (
                              <p className="text-danger">
                                {formik.errors.honorific}
                              </p>
                            )}
                        </div>
                        {/* {selectedTitle === "" && <div className="validation-error">Please select a title.</div>} */}
                      </div>
                      <div className="col-sm-12">
                        <div className="form-group">
                          <label htmlFor="name" className="d-inline-flex">
                            Họ và tên <div className=" ml-1 text-danger">*</div>
                          </label>
                          <input
                            type="text"
                            id="name"
                            name="name"
                            value={userName ? userName : formik.values.name}
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                            className="input-border"
                          />
                          {formik.touched.name && formik.errors.name && (
                            <p className="text-danger">{formik.errors.name}</p>
                          )}
                        </div>
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
                            value={
                              phoneNumber
                                ? phoneNumber
                                : formik.values.phone_number
                            }
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                            className="input-border"
                          />
                          {formik.touched.phone_number &&
                            formik.errors.phone_number && (
                              <p className="text-danger">
                                {formik.errors.phone_number}
                              </p>
                            )}
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
                            id="email"
                            name="email"
                            value={userEmail ? userEmail : formik.values.email}
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                            className="input-border"
                          />
                          {formik.touched.email && formik.errors.email && (
                            <p className="text-danger">{formik.errors.email}</p>
                          )}
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
                            name="message"
                            value={formik.values.message}
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
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
                        <p> {formattedTourChildPrice}</p>
                        <p>{formattedTourPrice}</p>
                      </div>
                      {percentage !== 0 ? (
                        <div className="col-sm-6">
                          <p>
                            {" "}
                            Giá sau khi nhập coupon:{" "}
                            <span className="fs-4 text-danger fw-bold">
                              {formattedFinalPrice}
                            </span>
                          </p>
                        </div>
                      ) : (
                        <div></div>
                      )}
                    </div>
                    {/* Button trigger modal xác nhận thông tin */}
                    <button
                      type="button"
                      data-toggle="modal"
                      data-target="#confirmTourForm"
                      className="btn-continue"
                      disabled={isSubmitDisabled}
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
                                    value={
                                      userName ? userName : formik.values.name
                                    }
                                    disabled
                                  />{" "}
                                </div>
                                <div className="form-group col-6">
                                  <label htmlFor="">Số điện thoại</label>
                                  <input
                                    type="text"
                                    name="phone_number"
                                    value={
                                      phoneNumber
                                        ? phoneNumber
                                        : formik.values.phone_number
                                    }
                                    disabled
                                  />{" "}
                                </div>
                                <div className="form-group col-6">
                                  <label htmlFor="">Email</label>
                                  <input
                                    type="email"
                                    name="email"
                                    value={
                                      userEmail
                                        ? userEmail
                                        : formik.values.email
                                    }
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
                              {percentage !== 0 ? (
                                <div className="form-group">
                                  <label htmlFor="">
                                    Giá tour sau khi nhập coupon
                                  </label>
                                  <input
                                    type="text"
                                    name="created_at"
                                    value={formattedFinalPrice}
                                    disabled
                                  />
                                </div>
                              ) : (
                                <div></div>
                              )}
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
                  <div className="coupon-field">
                    <h4>Nhập coupon</h4>
                    {userLogIn == "true" ? (
                      <form onSubmit={handleCouponSubmit}>
                        <div className="form-group row">
                          <input
                            type="text"
                            name="coupon_code"
                            placeholder="Nhập mã giảm giá"
                            className="input-border col-8"
                            value={formCoupon.coupon_code}
                            onChange={handleCouponChange}
                          />
                          <input
                            type="hidden"
                            name="user_id"
                            className="input-border"
                            value={formCoupon.user_id}
                          />
                          <button className="btn-continue col-4" type="submit">
                            Submit
                          </button>
                        </div>
                      </form>
                    ) : (
                      <div>
                        <p className="text-danger">
                          Bạn hãy đăng nhập hoặc đăng ký tài khoản mới để có thể
                          sử dụng coupon giảm giá
                        </p>
                      </div>
                    )}
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
