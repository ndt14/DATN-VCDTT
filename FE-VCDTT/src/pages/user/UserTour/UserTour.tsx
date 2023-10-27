import React from "react";
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { useGetBillsWithUserIDQuery } from "../../../api/bill";
import { Bill } from "../../../interfaces/Bill";

const UserTour = () => {
  const user = JSON.parse(localStorage.getItem("user"));
  const userId = user?.id;
  const { data: TourData } = useGetBillsWithUserIDQuery(userId | "");
  const TourList = TourData?.data?.purchase_history;
  console.log(TourList);
  const formatNumber = (number: number) => {
    return Math.floor(number).toString(); // or parseInt(number.toString(), 10).toString()
  };

  const goToPayment = (id: number) => {
    const VnpayURL = `http://be-vcdtt.datn-vcdtt.test/api/vnpay-payment/${id}`;
    window.location.href = VnpayURL;
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
                  <h3>Vũ Hồng Thái </h3>
                  <p>hongthai96961996@gmail.com</p>
                </div>
              </div>
              <hr />
              {/* Left panel */}

              <Link
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
              </Link>

              {/* End left panel */}
            </div>
          </div>
          <div className="col-8">
            {/*  */}

            <h3>Danh sách tour</h3>
            {TourList?.map(
              ({
                id,
                tour_name,
                adult_count,
                child_count,
                tour_adult_price,
                tour_child_price,
                coupon_percentage,
                tour_start_time,
                transaction_id,
                payment_status,
              }: Bill) => {
                const handleGoToPayment = () => {
                  if (id) {
                    goToPayment(id);
                  }
                };
                return (
                  <div className="border p-3 my-3" key={id}>
                    <p>Tên tour: {tour_name}</p>
                    <p>Số lượng người lớn: {adult_count}</p>
                    <p>Số lương trẻ em: {child_count}</p>
                    <p>
                      Giá:
                      {formatNumber(
                        (adult_count * tour_adult_price +
                          child_count * tour_child_price) *
                          (1 - coupon_percentage / 100)
                      )}{" "}
                      đ
                    </p>
                    <p>Ngày đi : {tour_start_time}</p>
                    <p>Mã giao dịch: {transaction_id}</p>

                    {payment_status == 1 ? (
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
                    )}
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
