import React, {
  useState,
  ChangeEvent,
  useEffect,
  FormEvent,
  useRef,
} from "react";
import "./PurchasingInformation.css";
import { useLocation } from "react-router-dom";
import { useAddBillMutation } from "../../../api/bill";
import { useCheckCouponMutation } from "../../../api/coupon";
import { useFormik } from "formik";
import * as Yup from "yup";
import { useNavigate } from "react-router-dom";
import { Link } from "react-router-dom";
import { useGetUserByIdQuery } from "../../../api/user";
import CashPaymentModal from "../../../componenets/User/Modal/CashPaymentModal";

import { Spin } from "antd";

// type Props = {};

const PurchasingInformation = () => {
  //validate
  interface FormValues {
    name: string;
    email: string;
    phone_number: string;
    message: string;
    honorific: number;
    address: string;
    method: number | null;
  }

  //
  const [isChecked, setIsChecked] = useState(false);
  const [loading, setLoading] = useState(false);
  console.log(loading);

  const handleCheckboxChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setIsChecked(e.target.checked);
  };
  //

  useEffect(() => {
    formik.validateForm();
  }, []);

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
    tourId,
    exact_location,
  } = location.state;
  const parts = dateTour.split("-");
  const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
  const userData = JSON.parse(localStorage.getItem("user"));
  const userId = userData?.id;
  // console.log(userId);

  // const { data: userData } = useGetUserByIdQuery(userId || "");
  // const {
  //   name: userName,
  //   email: userEmail,
  //   phone_number: phoneNumber,
  //   address: userAddress,
  //   gender: userGender,
  // } = userData?.data?.user ?? {};
  // console.log(userData);
  const userName = userData?.name;
  const userEmail = userData?.email;
  const phoneNumber = userData?.phone_number;
  const userAddress = userData?.address;
  const userGender = userData?.gender;
  const userLogIn = localStorage.getItem("isLoggedIn");

  // Xử lý xác nhận thông tin form
  // const [formData, setFormData] = useState({
  //   user_info: "",
  //   email: "",
  //   phone_number: "",
  //   message: "",
  // });
  // const handleChange = (
  //   e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement>
  // ) => {
  //   const { name, value } = e.target;
  //   setFormData((prevFormData) => ({
  //     ...prevFormData,
  //     [name]: value,
  //   }));
  // };

  const formik = useFormik<FormValues>({
    initialValues: {
      name: userName ? userName : "",
      email: userEmail ? userEmail : "",
      phone_number: phoneNumber ? phoneNumber : "",
      message: "",
      honorific: userGender ? userGender : null,
      address: userAddress ? userAddress : "",
      method: null,
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
  const isSubmitDisabled = Object.keys(formik.errors).length > 0;
  // Coupon
  const [couponData, setCouponData] = useState({
    percentage: 0,
    fixed: 0,
    finalPrice: 0,
    couponName: "",
    couponCode: "",
  });
  // console.log(couponData);

  const [formCoupon, setFormCoupon] = useState({
    user_id: userId ? userId : "",
    coupon_code: "",
  });

  useEffect(() => {
    let FPrice = childPrice + price;
    if (couponData.percentage > 0) {
      FPrice = FPrice - (FPrice / 100) * couponData.percentage;
      setCouponData((prevData) => ({
        ...prevData,
        finalPrice: FPrice,
      }));
    } else {
      FPrice = FPrice - couponData.fixed;
      setCouponData((prevData) => ({
        ...prevData,
        finalPrice: FPrice,
      }));
    }
  }, [
    productNumber,
    price,
    productChildNumber,
    childPrice,
    couponData.percentage,
    couponData.fixed,
  ]);
  const formattedFinalPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(couponData.finalPrice);
  const handleCouponSubmit = (e: FormEvent) => {
    e.preventDefault();
    console.log(formCoupon);
    checkCoupon(formCoupon)
      .then((response) => {
        alert(response?.data?.message);
        const discountPercent = response?.data?.coupon.percentage_price;
        const discountFixed = response?.data?.coupon.fixed_price;
        const coupon_name = response?.data?.coupon.name;
        // console.log(coupon_name);
        setCouponData({
          percentage: discountPercent ? discountPercent : null,
          fixed: discountFixed ? discountFixed : null,
          finalPrice: couponData.finalPrice,
          couponName: coupon_name,
          couponCode: formCoupon.coupon_code,
        });
      })
      .catch((error) => {
        // Handle any errors here
        console.error(error);
      });
  };
  // console.log(finalPrice);

  const handleCouponChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setFormCoupon((prevValues) => ({
      ...prevValues,
      [name]: value,
    }));
  };

  //
  const [paymentMethod, setPaymentMethod] = useState("0");
  console.log(paymentMethod);

  const [showPaymentModal, setShowPaymentModal] = useState(false);
  const handlePaymentMethodChange = (e) => {
    setPaymentMethod(e.target.value);
  };
  // console.log(paymentMethod);

  // Khi bạn tắt modal CashPaymentModal, đặt showConfirmTourFormModal thành false
  const hideConfirmTourFormModal = () => {
    const confirmTourFormModal = document.getElementById("confirmTourForm"); // Lấy modal confirmTourForm bằng id
    if (confirmTourFormModal) {
      confirmTourFormModal.classList.remove("show"); // Ẩn modal
    }
  };

  // Trong hàm handleCashPaymentModalClose, sau khi bạn đã đặt showPaymentModal thành false, gọi hàm hideConfirmTourFormModal để ẩn modal confirmTourForm
  const handleCashPaymentModalClose = () => {
    setShowPaymentModal(false);
    hideConfirmTourFormModal();
  };

  const handleSubmit = async (e: FormEvent) => {
    e.preventDefault();
    setLoading(true);

    const variables = {
      name: formik.values.name,
      user_id: userId,
      tour_name: tourName,
      tour_id: tourId,
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
      coupon_name: couponData.couponName,
      coupon_code: couponData.couponCode,
      coupon_percentage:
        couponData.percentage > 0 ? couponData.percentage : null,
      coupon_fixed: couponData.percentage > 0 ? null : couponData.fixed,
      tour_sale_percentage: 0,
      address: formik.values.address,
      purchase_status: 0,
      payment_status: 0,
      purchase_method: parseInt(paymentMethod),
    };
    console.log(variables);
    localStorage.setItem("tempUser", JSON.stringify(variables));
    console.log(couponData.couponName);

    try {
      const response = await addBill(variables);
      const billID = response?.data?.data?.purchase_history.id;
      console.log(billID);
      localStorage.setItem("billIdSuccess", JSON.stringify(billID));

      if (paymentMethod === "0") {
        setLoading(false);
        alert("Đặt tour thành công");
        hideConfirmTourFormModal();
        setShowPaymentModal(true);
      } else if (paymentMethod === "1") {
        setLoading(false);
        alert("Đặt tour thành công");
        const VnpayURL = `http://be-vcdtt.datn-vcdtt.test/api/vnpay-payment/${billID}`;
        window.location.href = VnpayURL;
      }
    } catch (error) {
      console.error(error);
    } finally {
      // console.log(".");
    }
  };
  const variables = {
    name: formik.values.name,
    user_id: userId,
    tour_name: tourName,
    tour_id: tourId,
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
    coupon_name: couponData.couponName,
    coupon_code: couponData.couponCode,
    coupon_percentage: couponData.percentage > 0 ? couponData.percentage : null,
    coupon_fixed: couponData.percentage > 0 ? null : couponData.fixed,
    tour_sale_percentage: 0,
    address: formik.values.address,
    purchase_status: 0,
    payment_status: 0,
    formattedFinalPrice: formattedFinalPrice,
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
  const formattedFixedPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(couponData.fixed);

  const iframeRef = useRef(null);

  useEffect(() => {
    if (iframeRef.current) {
      const iframeSrc = `https://maps.google.com/maps?width=600&height=400&hl=en&q=${encodeURIComponent(
        exact_location
      )}&t=&z=14&ie=UTF8&iwloc=B&output=embed`;
      iframeRef.current.src = iframeSrc;
    }
  }, [exact_location]);

  const titleElement = document.querySelector("title");
  if (titleElement) {
    titleElement.innerText = "Xác nhận thông tin";
  }
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

        {/*  */}
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
                            value={formik.values.name}
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
                            value={formik.values.phone_number}
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
                            value={formik.values.email}
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
                          <label className="d-inline-flex">Địa chỉ</label>
                          <input
                            type="text"
                            id="address"
                            name="address"
                            value={formik.values.address}
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
                      ref={iframeRef}
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
                        {formattedFinalPrice !== formattedResultPrice ? (
                          <p>Coupon giảm giá: </p>
                        ) : (
                          <span></span>
                        )}
                      </div>

                      <div className="col-sm-6">
                        <p> {formattedTourChildPrice}</p>
                        <p>{formattedTourPrice}</p>
                        {formattedFinalPrice !== formattedResultPrice ? (
                          <div>
                            {couponData.percentage != null ? (
                              <div>
                                <p>Giảm {couponData.percentage}%</p>
                              </div>
                            ) : (
                              <p>Giảm giá: {formattedFixedPrice}</p>
                            )}
                          </div>
                        ) : (
                          <div></div>
                        )}
                        <div></div>
                      </div>

                      {userLogIn == "true" &&
                      formattedFinalPrice !== formattedResultPrice ? (
                        <div className="col-sm-6">
                          <p>
                            Giá sau khi nhập coupon:{" "}
                            <span className="fs-4 text-danger fw-bold">
                              {formattedFinalPrice}
                            </span>
                          </p>
                        </div>
                      ) : (
                        <div className="col-sm-6"></div>
                      )}
                    </div>
                    {/* Button trigger modal xác nhận thông tin */}
                    {isSubmitDisabled ? (
                      <div>
                        <button
                          type="button"
                          data-toggle="modal"
                          data-target="#confirmTourForm"
                          className="btn-continue"
                          disabled
                        >
                          Tiếp tục
                        </button>
                        <p className="text-danger mt-2">
                          Hãy nhập đủ thông tin để tiếp tục
                        </p>
                      </div>
                    ) : (
                      <div>
                        <button
                          type="button"
                          data-toggle="modal"
                          data-target="#confirmTourForm"
                          className="btn-continue"
                        >
                          Tiếp tục
                        </button>
                      </div>
                    )}
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
                                    value={formik.values.name}
                                    disabled
                                  />{" "}
                                </div>
                                <div className="form-group col-6">
                                  <label htmlFor="">Số điện thoại</label>
                                  <input
                                    type="text"
                                    name="phone_number"
                                    value={formik.values.phone_number}
                                    disabled
                                  />{" "}
                                </div>
                                <div className="form-group col-6">
                                  <label htmlFor="">Email</label>
                                  <input
                                    type="email"
                                    name="email"
                                    value={formik.values.email}
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
                              {formattedResultPrice == formattedFinalPrice ? (
                                <div></div>
                              ) : (
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
                              )}

                              <div className="form-group">
                                <label htmlFor="">Phương thức thanh toán</label>
                                <div className="mr-3">
                                  <input
                                    type="radio"
                                    name="purchase_method"
                                    value="0"
                                    className="mr-2"
                                    onChange={handlePaymentMethodChange}
                                    checked={paymentMethod === "0"}
                                  />
                                  Thanh toán online
                                </div>
                                <div>
                                  <input
                                    type="radio"
                                    name="purchase_method"
                                    value="1"
                                    className="mr-2"
                                    onChange={handlePaymentMethodChange}
                                    checked={paymentMethod === "1"}
                                  />
                                  VNPAY
                                </div>
                              </div>
                              <input
                                type="checkbox"
                                checked={isChecked}
                                onChange={handleCheckboxChange}
                              />
                              <span className="ml-2">
                                Tôi đồng ý với{" "}
                                <Link to={"/privacy_policy"}>Chính sách</Link>{" "}
                                của trang
                              </span>
                              <br />
                              <br />
                              {!isChecked ? (
                                <button
                                  type="submit"
                                  disabled
                                  className="btn btn-primary"
                                >
                                  Xác nhận thanh toán
                                </button>
                              ) : (
                                <div>
                                  <button
                                    type="submit"
                                    className="btn btn-primary"
                                    // disabled={loading}
                                  >
                                    Xác nhận thanh toán
                                    {loading == true ? (
                                      <Spin className="ml-2" />
                                    ) : (
                                      <span></span>
                                    )}
                                  </button>
                                </div>
                              )}
                            </form>
                          </div>
                          <div className="modal-footer">
                            <button
                              aria-label="Close"
                              // disabled={isChecked == false}
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

                  {showPaymentModal ? (
                    <CashPaymentModal
                      show={showPaymentModal}
                      onHide={handleCashPaymentModalClose}
                      modalData={variables}
                    />
                  ) : null}
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
