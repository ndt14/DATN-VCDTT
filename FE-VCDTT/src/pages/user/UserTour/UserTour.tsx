import React, { useRef } from "react";
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { useGetBillsWithUserIDQuery } from "../../../api/bill";
import { useGetUserByIdQuery } from "../../../api/user";
import { Bill } from "../../../interfaces/Bill";

const UserTour = () => {
  const user = JSON.parse(localStorage.getItem("user"));
  const userId = user?.id;
  const { data: TourData } = useGetBillsWithUserIDQuery(userId | "");
  const { data: userData } = useGetUserByIdQuery(userId || "");

  const userName = userData?.data?.user.name;

  const userEmail = userData?.data?.user.email;
  const TourList = TourData?.data?.purchase_history;
  console.log(TourList);
  const formatNumber = (number: number) => {
    return Math.floor(number).toString(); // or parseInt(number.toString(), 10).toString()
  };

  const goToPayment = (id: number) => {
    const VnpayURL = `http://be-vcdtt.datn-vcdtt.test/api/vnpay-payment/${id}`;
    window.location.href = VnpayURL;
  };

  const [showModal, setShowModal] = useState({});

  const handleButtonClick = (id: any) => {
    setShowModal((prevState) => ({
      ...prevState,
      [id]: true,
    }));
  };

  const handleCloseModal = (id: any) => {
    setShowModal((prevState) => ({
      ...prevState,
      [id]: false,
    }));
  };

  return (
    <div>
      <section className="inner-banner-wrap">
        <div
          className="inner-baner-container"
          style={{
            backgroundImage: `url(../../../../assets/images/bg/bg1.jpg)`,
          }}
        >
          <div className="container">
            <div className="inner-banner-content">
              <h1 className="inner-title">Tìm kiếm tour</h1>
            </div>
          </div>
        </div>
        <div className="inner-shape"></div>
      </section>
      <section className="container" style={{ marginBottom: "200px" }}>
        <div className="row">
          <div className="col-4">
            <div className="border">
              <div className="d-flex p-3">
                <div>
                  <img
                    style={{ width: "70px" }}
                    src="../../../../assets/images/travel.png"
                    alt=""
                  />
                </div>
                <div>
                  <h3>{userName} </h3>
                  <p>{userEmail}</p>
                </div>
              </div>
              <hr />
              {/* Left panel */}

              {/* <Link
                to={"/user/profile"}
                className="nav row "
                id="myTab"
                role="tablist"
              >
                <button className=" border-0 btn w-100" type="button">
                  Hồ sơ
                </button>
              </Link>

              <Link
                to={"/user/profile"}
                className="nav row "
                id="myTab"
                role="tablist"
              >
                <button className="border-0 btn w-100" type="button">
                  Tour đã đặt
                </button>
              </Link>

              <Link
                to={"/user/profile"}
                className="nav row "
                id="myTab"
                role="tablist"
              >
                <button className=" border-0 btn w-100" type="button">
                  Tour yêu thích
                </button>
              </Link> */}
              {/* <div className="">
                <div className="">
                  <nav id="navigation" className="">
                    <ul>
                      <ul>
                        <li>
                          <Link to="user/profile">Thông tin cá nhân</Link>
                        </li>
                        <li>
                          <Link to="user/tours">Tour đã mua</Link>
                        </li>
                        <li>
                          <Link to="user/favorite">Tour yêu thích</Link>
                        </li>
                      </ul>
                    </ul>
                  </nav>
                </div>
              </div> */}
              <nav className="nav flex-column">
                <Link className="nav-link" to={"/user/profile"}>
                  Thông tin cá nhân
                </Link>
                <Link className="nav-link active" to={"/user/tours"}>
                  Tour đã đặt
                </Link>
                <Link className="nav-link" to={"/user/favorite"}>
                  Tour yêu thích
                </Link>
              </nav>

              {/* End left panel */}
            </div>
          </div>
          <div className="col-8">
            {/*  */}

            <h3>Danh sách tour</h3>
            {TourList?.map(
              ({
                id,
                name,
                tour_name,
                email,
                adult_count,
                child_count,
                tour_adult_price,
                tour_child_price,
                coupon_percentage,
                coupon_fixed,
                tour_start_time,
                tour_end_time,
                transaction_id,
                payment_status,
                purchase_status,
                phone_number,
              }: Bill) => {
                const handleGoToPayment = () => {
                  if (id) {
                    goToPayment(id);
                  }
                };
                let tourStatus;
                if (purchase_status === 0) {
                  tourStatus = "Cần thanh toán";
                } else if (payment_status === 1) {
                  tourStatus = "Đang đợi Admin xác nhận";
                } else if (payment_status === 2) {
                  tourStatus = "Admin đã xác nhận, chờ tới ngày đi tour";
                } else if (payment_status === 3) {
                  tourStatus = "Còn 1 ngày tới ngày đi tour";
                } else if (payment_status === 4) {
                  tourStatus = "Tour đang diễn ra";
                } else if (payment_status === 5) {
                  tourStatus = "Tour đã kết thúc";
                } else if (payment_status === 6) {
                  tourStatus = "Admin đã hủy";
                } else if (payment_status === 7) {
                  tourStatus = "Bạn đã hủy";
                } else if (payment_status === 8) {
                  tourStatus = "Đơn tự động hủy do quá hạn thanh toán";
                } else if (payment_status === 9) {
                  tourStatus = "Đã hoàn tiền do hủy tour";
                }

                const finalPrice =
                  coupon_percentage == 0 || null
                    ? adult_count * tour_adult_price +
                      child_count * tour_child_price -
                      coupon_fixed
                    : (adult_count * tour_adult_price +
                        child_count * tour_child_price) *
                      (1 - coupon_percentage / 100);
                const formattedFinalPrice = new Intl.NumberFormat("vi-VN", {
                  style: "currency",
                  currency: "VND",
                }).format(finalPrice);
                return (
                  <div className="p-3 my-3 shadow" key={id}>
                    <p>
                      Mã đơn: <span className="fw-bold">{id}</span>
                    </p>
                    <p>
                      Mã giao dịch VNPAY:{" "}
                      <span className="fw-bold">{transaction_id}</span>
                    </p>
                    <p>
                      Tên tour: <span className="fw-bold">{tour_name}</span>
                    </p>
                    <p>
                      Giá:{" "}
                      <span className="fw-bold">{formattedFinalPrice}</span>
                    </p>

                    <button
                      type="button"
                      data-toggle="modal"
                      data-target={`#bill-${id}`}
                    >
                      Chi tiết đơn hàng
                    </button>
                    <div
                      className="modal fade"
                      id={`bill-${id}`}
                      role="dialog"
                      aria-labelledby="exampleModalLabel"
                      aria-hidden="true"
                    >
                      <div className="modal-dialog" role="document">
                        <div className="modal-content">
                          <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalLabel">
                              Chi tiết đơn hàng
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
                            <h3>Thông tin khách hàng</h3>
                            <p>
                              Họ và tên: <span className="fw-bold">{name}</span>
                            </p>
                            <p>
                              Số điện thoại:{" "}
                              <span className="fw-bold">{phone_number}</span>
                            </p>
                            <p>
                              Email: <span className="fw-bold">{email}</span>
                            </p>
                            <hr className="mb-3" />
                            <h3>Thông tin tour</h3>
                            <p>
                              Mã số thanh toán VNPAY:{" "}
                              <span className="fw-bold">{transaction_id}</span>
                            </p>
                            <p>
                              Tên tour:{" "}
                              <span className="fw-bold">{tour_name}</span>
                            </p>
                            <div className="d-flex justify-content-between mb-3">
                              <div>
                                Số lượng trẻ em:{" "}
                                <span className="fw-bold">{child_count}</span>
                              </div>
                              <div>
                                Số lượng người lớn:{" "}
                                <span className="fw-bold">{adult_count}</span>
                              </div>
                            </div>
                            {coupon_percentage == 0 || null ? (
                              <p>
                                Coupon:{" "}
                                <span className="fw-bold">
                                  Giảm {coupon_fixed}đ
                                </span>
                              </p>
                            ) : (
                              <p>
                                Coupon:{" "}
                                <span className="fw-bold">
                                  Giảm {coupon_percentage}%
                                </span>
                              </p>
                            )}
                            <p>
                              Giá tour:{" "}
                              <span className="fw-bold">
                                {formattedFinalPrice}
                              </span>
                            </p>

                            <p>Ngày bắt đầu tour: {tour_start_time}</p>
                            <p>Ngày kết thúc tour: {tour_end_time}</p>
                            <p>Trạng thái thanh toán: {tourStatus}</p>
                            {payment_status == 0 ? (
                              <button onClick={handleGoToPayment}>
                                Đi đến thanh toán
                              </button>
                            ) : (
                              <div></div>
                            )}
                            {payment_status && payment_status > 3 ? (
                              <div></div>
                            ) : (
                              <button>Hủy tour</button>
                            )}
                          </div>
                        </div>
                      </div>
                    </div>

                    {/* {payment_status == 0 ? (
                      <div>
                        <p>
                          Trạng thái:{" "}
                          <span className="text-danger">Chưa thanh toán</span>
                        </p>
                        <button
                          onClick={handleGoToPayment}
                          className="button btn-continue"
                        >
                          Đi đến thanh toán
                        </button>
                      </div>
                    ) : (
                      <div>
                        <p>
                          Trạng thái:{" "}
                          <span className="text-primary">Đã thanh toán</span>
                        </p>
                      </div>
                    )} */}
                  </div>
                );
              }
            )}
          </div>
        </div>
      </section>
    </div>
  );
};

export default UserTour;
