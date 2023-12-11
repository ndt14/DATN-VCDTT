import React, { useState, useEffect, FormEvent, useRef } from "react";
import "./PurchasingInformation.css";
import { Link } from "react-router-dom";
import { useAddBillMutation } from "../../../api/bill";
import { useCheckCouponMutation } from "../../../api/coupon";
import { useFormik } from "formik";
import * as Yup from "yup";
import { ChangeEvent } from "react";
// import { useNavigate } from "react-router-dom";
import { useGetTourByIdQuery } from "../../../api/tours";
import CashPaymentModal from "../../../componenets/User/Modal/CashPaymentModal";
import { useGetBillsWithUserIDQuery } from "../../../api/bill";
import { useGetUserByIdQuery } from "../../../api/user";

import { Spin } from "antd";
import Button from "react-bootstrap/Button";
import Modal from "react-bootstrap/Modal";
// import { setTimeout } from "timers/promises";

// type Props = {};
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";
import SecondaryBanner from "../../../componenets/User/SecondaryBanner";

import { useParams } from "react-router-dom";

const MySwal = withReactContent(Swal);

const PurchasingInformation = () => {
  // dữ liệu lừ localStorage
  const userData = JSON.parse(localStorage.getItem("user") || "{}");
  const userId = userData?.id;

  //api
  const { id } = useParams<{ id: string }>();
  const split = id?.split("-");
  let tourId: number | undefined = undefined;
  if (split && split.length >= 1) {
    tourId = parseInt(split[0]);
  }
  console.log(tourId);

  const { data: tourData } = useGetTourByIdQuery(tourId || "");
  const tour_sale = tourData?.data.tour.sale_percentage;
  const price = (tourData?.data.tour.adult_price * (100 - tour_sale)) / 100;
  const childPrice =
    (tourData?.data.tour.child_price * (100 - tour_sale)) / 100;
  const productNumber = localStorage.getItem("adult");
  const productChildNumber = localStorage.getItem("child");
  console.log(typeof productNumber);
  const adult_count = parseInt(productNumber !== null ? productNumber : "", 10);
  const child_count = parseInt(
    productChildNumber !== null ? productChildNumber : "",
    10
  );
  const totalAdultPrice = price * adult_count;
  const totalChildPrice = childPrice * child_count;
  const lastPrice = totalAdultPrice + totalChildPrice;
  const formattedTourPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(totalAdultPrice);
  const formattedTourChildPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(totalChildPrice);
  const tourName = tourData?.data.tour.name;
  const tourLocation = tourData?.data.tour.location;
  const main_img = tourData?.data.tour.main_img;
  const exact_location = tourData?.data.tour.exact_location;

  const tourDuration = tourData?.data.tour.duration;

  const dateTour = localStorage.getItem("start_date");
  const splitDate = dateTour?.substring(1, 11);
  const formattedResultPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(lastPrice);
  console.log(productNumber);
  const parts = splitDate?.split("-");
  let formattedDate = "";
  if (parts && parts.length === 3) {
    const day = parts[2];
    const month = parts[1];
    const year = parts[0];
    formattedDate = `${day}-${month}-${year}`;
  } else {
    formattedDate = "Invalid date";
  }
  const duration = parseInt(tourDuration);

  const [day, month, year] = formattedDate.split("-");
  const startDateObject = new Date(`${year}-${month}-${day}`);
  const endDateObject = new Date(
    startDateObject.getTime() + duration * 24 * 60 * 60 * 1000
  );
  const endDate = endDateObject.toLocaleDateString("en-GB");
  const parts2 = endDate.split("/");
  const formattedEndDate = `${parts2[0]}-${parts2[1]}-${parts2[2]}`;
  // console.log(formattedEndDate);

  //

  // Check số tour người dùng đã đặt
  const { data: TourData } = useGetBillsWithUserIDQuery(userId || "");
  const [idArray, setIdArray] = useState<number[]>([]);
  useEffect(() => {
    if (TourData) {
      const tourIdPurchased = TourData.data.purchase_history;

      const array = tourIdPurchased.map(
        (item: { tour_id: number }) => item.tour_id
      );
      setIdArray(array);
    }
  }, []);
  // console.log(idArray);
  const count = idArray.reduce((accumulator, currentValue) => {
    if (currentValue === tourId) {
      return accumulator + 1;
    }
    return accumulator;
  }, 0);
  // console.log(count);

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
  // console.log(loading);

  const handleCheckboxChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setIsChecked(e.target.checked);
  };
  //

  useEffect(() => {
    formik.validateForm();
  }, []);

  //
  // const navigate = useNavigate();

  const [checkCoupon] = useCheckCouponMutation();
  const [addBill] = useAddBillMutation();

  const { data: userAPIData } = useGetUserByIdQuery(userId || "");
  // console.log(userAPIData?.data.user.name);
  const userName = userAPIData?.data.user.name;
  const userEmail = userAPIData?.data.user.email;
  const phoneNumber = userAPIData?.data.user.phone_number;
  const userAddress = userAPIData?.data.user.address;
  const userGender = userAPIData?.data.user.gender;
  const userLogIn = localStorage.getItem("isLoggedIn");

  const formik = useFormik<FormValues>({
    initialValues: {
      name: userName || "",
      email: userEmail ? userEmail : "",
      phone_number: phoneNumber ? phoneNumber : "",
      message: "",
      honorific: userGender ? userGender : "",
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
  useEffect(() => {
    if (userAPIData && userAPIData.data.user.name) {
      formik.setValues((prevValues) => ({
        ...prevValues,
        name: userAPIData.data.user.name,
        phone_number: userAPIData.data.user.phone_number,
        address: userAPIData.data.user.address,
        email: userAPIData.data.user.email,
        honorific: userAPIData.data.user.gender,
      }));
    }
  }, [userAPIData]);
  const isSubmitDisabled = Object.keys(formik.errors).length > 0;
  // Coupon
  const [couponData, setCouponData] = useState<{
    percentage: number | null;
    fixed: number | null;
    finalPrice: number;
    couponName: string;
    couponCode: string;
  }>({
    percentage: null,
    fixed: null,
    finalPrice: lastPrice,
    couponName: "",
    couponCode: "",
  });

  useEffect(() => {
    setCouponData((prevData) => ({
      ...prevData,
      finalPrice: lastPrice,
    }));
  }, [lastPrice]);

  const [formCoupon, setFormCoupon] = useState({
    user_id: userId ? userId : "",
    coupon_code: "",
  });

  useEffect(() => {
    let FPrice = totalAdultPrice + totalChildPrice;
    console.log(FPrice);

    if (couponData.percentage && couponData.percentage > 0) {
      FPrice = FPrice - (FPrice / 100) * couponData.percentage;
      setCouponData((prevData) => ({
        ...prevData,
        finalPrice: FPrice,
      }));
    } else if (couponData.fixed !== null) {
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
  console.log(couponData);

  const handleCouponSubmit = (e: FormEvent) => {
    e.preventDefault();
    console.log(formCoupon);
    checkCoupon(formCoupon)
      .then((response) => {
        if ("data" in response) {
          MySwal.fire({
            text: response?.data?.message,
            icon:
              response?.data?.message == "Mã giảm giá hợp lệ"
                ? "success"
                : "warning",
            // confirmButtonText: "OK",
          });
          // alert(response?.data?.message);

          const discountPercent = response?.data?.coupon.percentage_price;
          const discountFixed = response?.data?.coupon.fixed_price;
          const coupon_name = response?.data?.coupon.name;
          setCouponData({
            percentage: discountPercent ? discountPercent : null,
            fixed: discountFixed ? discountFixed : null,
            finalPrice: couponData.finalPrice,
            couponName: coupon_name !== undefined ? coupon_name : "",
            couponCode: formCoupon.coupon_code,
          });
        }
        // console.log(coupon_name);
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
  const [paymentMethod, setPaymentMethod] = useState("1");
  // console.log(paymentMethod);

  const [showPaymentModal, setShowPaymentModal] = useState(false);
  // const [showInfoModal, setShowInfoModal] = useState(false);
  const [show, setShow] = useState(false);

  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);

  const handlePaymentMethodChange = (e: ChangeEvent<HTMLInputElement>) => {
    setPaymentMethod(e.target.value);
  };
  // console.log(paymentMethod);

  // Khi bạn tắt modal CashPaymentModal, đặt showConfirmTourFormModal thành false
  const hideConfirmTourFormModal = () => {
    setShow(false);
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
      child_count:
        productChildNumber !== null ? parseInt(productChildNumber) : undefined,
      adult_count: productNumber !== null ? parseInt(productNumber) : undefined,
      tour_start_time: formattedDate,
      tour_end_time: formattedEndDate,
      tour_location: tourLocation,
      tour_child_price: childPrice,
      tour_adult_price: price,
      tour_image: main_img,
      email: formik.values.email,
      phone_number: formik.values.phone_number,
      suggestion: formik.values.message,
      gender: formik.values.honorific,
      coupon_name: couponData.couponName !== null ? couponData.couponName : "",
      coupon_code: couponData.couponCode ? couponData.couponCode : "none",
      coupon_percentage:
        couponData.percentage && couponData.percentage > 0
          ? couponData.percentage
          : null,
      coupon_fixed:
        couponData.percentage && couponData.percentage > 0
          ? null
          : couponData.fixed,
      tour_sale_percentage: 0,
      address: formik.values.address,
      purchase_status: 2,
      payment_status: 1,
      purchase_method: parseInt(paymentMethod),
      tour_duration: tourDuration,
      data: undefined,
    };
    console.log(variables);
    localStorage.setItem("tempUser", JSON.stringify(variables));
    console.log(couponData.couponName);

    let billID: number | undefined = undefined;
    try {
      const response = await addBill(variables);
      if ("data" in response) {
        billID = response.data.data.purchase_history.id;
        // Continue handling the successful response
      }
      localStorage.setItem("billIdSuccess", JSON.stringify(billID));

      if (paymentMethod === "1") {
        setLoading(false);
        try {
          // await MySwal.fire({
          //   title: "Chuyển khoản",
          //   text: "Đặt tour thành công",
          //   icon: "success",
          //   confirmButtonText: "OK",
          // });
          hideConfirmTourFormModal();
          setShowPaymentModal(true);
        } catch (error) {
          console.error("SweetAlert2 error:", error);
        }
      } else if (paymentMethod === "2") {
        setLoading(false);
        try {
          // await MySwal.fire({
          //   title: "VNPAY",
          //   text: "Đặt tour thành công",
          //   icon: "success",
          //   confirmButtonText: "OK",
          // });
          const VnpayURL = `http://be-vcdtt.datn-vcdtt.test/api/vnpay-payment/${billID}`;
          window.location.href = VnpayURL;
        } catch (error) {
          console.error("SweetAlert2 error:", error);
        }
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
    tour_child_price: childPrice,
    tour_adult_price: price,
    email: formik.values.email,
    phone_number: formik.values.phone_number,
    suggestion: formik.values.message,
    gender: formik.values.honorific,
    coupon_name: couponData.couponName,
    coupon_code: couponData.couponCode,
    coupon_percentage:
      couponData.percentage && couponData.percentage > 0
        ? couponData.percentage
        : null,
    coupon_fixed:
      couponData.percentage && couponData.percentage > 0
        ? null
        : couponData.fixed,
    tour_sale_percentage: 0,
    address: formik.values.address,
    purchase_status: 0,
    payment_status: 0,
    formattedFinalPrice: formattedFinalPrice,
  };
  // console.log(onChange);

  // Xử ký format giá tiền

  const formattedFixedPrice =
    couponData.fixed !== null
      ? new Intl.NumberFormat("vi-VN", {
          style: "currency",
          currency: "VND",
        }).format(couponData.fixed)
      : "";

  const iframeRef = useRef<HTMLIFrameElement>(null);

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
  //

  const openWindow = () => {
    window.open("https://vcdtt.online/privacy_policy", "_blank");
  };
  const openWindow2 = () => {
    window.open("https://vcdtt.online/service_account", "_blank");
  };
  //banner
  const dataTitle = "Thanh toán";

  return (
    <>
      <main id="content" className="site-main">
        {/* <!-- Inner Banner html start--> */}
        <SecondaryBanner>{dataTitle}</SecondaryBanner>

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

                    {/* <h3>Thông tin địa điểm</h3>
                    <iframe
                      ref={iframeRef}
                      width="600"
                      height="450"
                      style={{ border: 0 }}
                      loading="lazy"
                      referrerPolicy="no-referrer-when-downgrade"
                    ></iframe> */}

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
                        <p>Người lớn ({productNumber}x)</p>
                        {lastPrice !== couponData.finalPrice ? (
                          <p>Coupon giảm giá: </p>
                        ) : (
                          <span></span>
                        )}
                      </div>

                      <div className="col-sm-6">
                        <p>{formattedTourChildPrice}</p>
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
                      lastPrice !== couponData.finalPrice ? (
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
                        <Button
                          type="button"
                          data-toggle="modal"
                          data-target="#confirmTourForm"
                          className="btn-continue"
                          disabled
                        >
                          Tiếp tục
                        </Button>
                        <p className="text-danger mt-2">
                          Hãy nhập đủ thông tin để tiếp tục
                        </p>
                      </div>
                    ) : (
                      <div>
                        {count >= 100 ? (
                          <div>
                            <Button
                              variant="primary"
                              onClick={handleShow}
                              disabled
                              className="btn-continue"
                            >
                              Tiếp tục
                            </Button>
                            <p className="text-danger mt-2">
                              Bạn đã vượt quá giới hạn số lần đặt tour này
                            </p>
                          </div>
                        ) : (
                          <div>
                            <Button
                              variant="primary"
                              onClick={handleShow}
                              className="btn-continue"
                            >
                              Tiếp tục
                            </Button>
                          </div>
                        )}
                      </div>
                    )}
                    <h3 className="mt-4">Thông tin địa điểm</h3>
                    <iframe
                      ref={iframeRef}
                      width="600"
                      height="450"
                      style={{ border: 0 }}
                      loading="lazy"
                      referrerPolicy="no-referrer-when-downgrade"
                    ></iframe>
                  </form>

                  <Modal show={show} onHide={handleClose}>
                    <Modal.Header closeButton>
                      <Modal.Title>Xác nhận thanh toán</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
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
                            <label htmlFor="">
                              Ngày kết thúc tour (dự kiến)
                            </label>
                            <input
                              type="text"
                              name="tour_start_time"
                              value={formattedEndDate}
                              disabled
                            />
                          </div>
                          <div className="form-group col-6">
                            <label htmlFor="">Giá tour</label>
                            <input
                              type="text"
                              name="created_at"
                              value={formattedFinalPrice}
                              disabled
                            />
                          </div>
                          <div className="form-group col-6">
                            <label htmlFor="">Số lượng trẻ em</label>
                            <input
                              type="text"
                              name="child_count"
                              value={
                                productChildNumber !== null
                                  ? productChildNumber
                                  : ""
                              }
                              disabled
                            />
                          </div>
                          <div className="form-group col-6">
                            <label htmlFor="">Số lượng người lớn</label>
                            <input
                              type="text"
                              name="adult_count"
                              value={
                                productNumber !== null ? productNumber : ""
                              }
                              disabled
                            />
                          </div>
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
                              value="1"
                              className="mr-2"
                              onChange={handlePaymentMethodChange}
                              checked={paymentMethod === "1"}
                            />
                            Chuyển khoản trực tiếp
                          </div>
                          <div>
                            <input
                              type="radio"
                              name="purchase_method"
                              value="2"
                              className="mr-2"
                              onChange={handlePaymentMethodChange}
                              checked={paymentMethod === "2"}
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
                          <Link
                            to={""}
                            className="text-primary"
                            onClick={openWindow}
                          >
                            Chính sách
                          </Link>{" "}
                          và&ensp;
                          <Link
                            to={""}
                            className="text-primary"
                            onClick={openWindow2}
                          >
                            Điều khoản
                          </Link>{" "}
                          của trang
                        </span>
                        <br />
                        <br />
                        {!isChecked ? (
                          <button
                            type="submit"
                            disabled
                            className="btn btn-secondary"
                          >
                            Thanh toán
                          </button>
                        ) : (
                          <div>
                            <button
                              type="submit"
                              className="btn btn-primary"
                              // disabled={loading}
                            >
                              Thanh toán
                              {loading == true ? (
                                <Spin className="ml-2" />
                              ) : (
                                <span></span>
                              )}
                            </button>
                          </div>
                        )}
                      </form>
                    </Modal.Body>
                    <Modal.Footer>
                      <Button variant="secondary" onClick={handleClose}>
                        Đóng
                      </Button>
                    </Modal.Footer>
                  </Modal>

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
                        <p>Ngày kết thúc tour(dự kiến)</p>
                      </div>

                      <div className="col-sm-6">
                        <p>{formattedEndDate}</p>
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
                    <h4>Nhập mã giảm giá</h4>
                    {userLogIn == "true" ? (
                      <form onSubmit={handleCouponSubmit}>
                        <div className="form-group row justify-content-center">
                          <input
                            type="text"
                            name="coupon_code"
                            placeholder="Nhập mã giảm giá"
                            className="input-border col-11"
                            value={formCoupon.coupon_code}
                            onChange={handleCouponChange}
                          />
                          <input
                            type="hidden"
                            name="user_id"
                            className="input-border"
                            value={formCoupon.user_id}
                          />
                          <button
                            className="btn-continue col-11 mt-2"
                            type="submit"
                          >
                            Xác nhận
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
