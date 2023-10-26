import React from "react";
import { Link } from "react-router-dom";
import { useNavigate } from "react-router-dom";
import { useGetBillByIdQuery, useUpdateBillMutation } from "../../../api/bill";
import { useState, useEffect } from "react";
import { Bill } from "../../../interfaces/Bill";
import { MouseEventHandler } from "react";

const BillSuccess = () => {
  const url = new URL(window.location.href);
  const searchParams = new URLSearchParams(url.search);
  const transactionStatus = searchParams.get("vnp_TransactionStatus");
  const transactionId = searchParams.get("vnp_TransactionNo");
  console.log(transactionId);
  const billId = JSON.parse(localStorage.getItem("billIdSuccess"));
  const userData = JSON.parse(localStorage.getItem("user"));
  const loginStatus = JSON.parse(localStorage.getItem("isLoggedIn"));
  const tempUserData = JSON.parse(localStorage.getItem("tempUser"));
  const userName = loginStatus == true ? userData.name : tempUserData.name;
  // const userAddress = loginStatus == true? userData.address: tempUserData.address
  const userEmail = loginStatus == true ? userData.email : tempUserData.email;
  const phoneNumber =
    loginStatus == true ? userData.phone_number : tempUserData.phone_number;
  // const userId = userData.id;
  // console.log(billId);
  // console.log(typeof billId);

  const { data: billData } = useGetBillByIdQuery(billId || "");
  // console.log(billData);
  const totalAdultPrice =
    billData?.data.purchase_history.tour_adult_price *
    billData?.data.purchase_history.adult_count;
  const totalChildPrice =
    billData?.data.purchase_history.tour_child_price *
    billData?.data.purchase_history.child_count;
  const totalPrice = totalAdultPrice + totalChildPrice;
  const discount = billData?.data.purchase_history.coupon_percentage
    ? billData?.data.purchase_history.coupon_percentage
    : billData?.data.purchase_history.coupon_fixed;
  const finalPrice = billData?.data.purchase_history.coupon_percentage
    ? totalPrice * (1 - discount / 100)
    : totalPrice - discount;
  const formattedFinalPrice = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(finalPrice);

  const [updateBill] = useUpdateBillMutation();
  // const updatedBillData = {
  //   id: billId,
  //   transaction_id: transactionId !== null ? +transactionId : undefined,
  //   payment_status: 2,
  // };

  useEffect(() => {
    const updateBillAfterLoad = async () => {
      try {
        if (transactionStatus === "00") {
          const updatedBillData: Bill = {
            id: billId,
            transaction_id: transactionId !== null ? +transactionId : undefined,
            payment_status: 2,
          };
          await updateBill(updatedBillData);
        } else {
          const updatedBillData: Bill = {
            id: billId,
            transaction_id: transactionId !== null ? +transactionId : undefined,
            payment_status: 1,
          };
          await updateBill(updatedBillData);
        }
      } catch (error) {
        console.error("Error updating bill:", error);
      }
    };

    updateBillAfterLoad();
  }, []);

  const navigate = useNavigate();
  return (
    <div>
      <section className="inner-banner-wrap">
        <div className="inner-baner-container">
          <div className="container">
            <div className="inner-banner-content">
              <h1 className="inner-title">Thanh toán</h1>
            </div>
          </div>
        </div>
        <div className="inner-shape"></div>
      </section>
      <div className="container">
        {transactionStatus === "00" ? (
          <div>
            <h2 className="text-success">Thanh toán thành công</h2>
            <div>
              <div className="border p-3">
                {/* <p>Mã thanh toán: {transactionId}</p> */}
                <div className="d-flex justify-content-between">
                  {/* <h2>Hóa đơn</h2> */}
                  <div>{/* <h3>VCDTT</h3> */}</div>
                </div>
                <div className="d-flex justify-content-between">
                  <div>
                    <h3>Đơn vị mua hàng</h3>
                    <h4>Họ và tên: {userName}</h4>
                    <p>Email: {userEmail}</p>
                    <p>Số điện thoại: {phoneNumber}</p>
                  </div>
                  <div>
                    <h3>Đơn vị bán hàng</h3>
                    <h3>VCDTT</h3>
                    <img
                      style={{ width: "150px" }}
                      src="../../../../assets/images/VCDTT_logo-removebg-preview.png"
                      alt=""
                    />
                    <p>Mã số thanh toán: {transactionId}</p>
                  </div>
                </div>
                <div className="mt-5">
                  Tên tour: {billData?.data.purchase_history.tour_name}
                  <div className="d-flex justify-content-between"></div>
                  <table className="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Thành tiền</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">Người lớn</th>
                        <td>{billData?.data.purchase_history.adult_count}</td>
                        <td>
                          {billData?.data.purchase_history.tour_adult_price}
                        </td>
                        <td>{totalAdultPrice}</td>
                      </tr>
                      <tr>
                        <th scope="row">Trẻ em</th>
                        <td>{billData?.data.purchase_history.child_count}</td>
                        <td>
                          {billData?.data.purchase_history.tour_child_price}
                        </td>
                        <td>{totalChildPrice}</td>
                      </tr>
                      <tr>
                        <th scope="row">Tổng</th>
                        <td className="text-end" colSpan={3}>
                          {totalPrice}
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Coupon</th>
                        {billData?.data.purchase_history.coupon_percentage !=
                        null ? (
                          <td className="text-end" colSpan={3}>
                            -{" "}
                            {billData?.data.purchase_history.coupon_percentage}%
                          </td>
                        ) : (
                          <td className="text-end" colSpan={3}>
                            - {billData?.data.purchase_history.coupon_fixed}
                          </td>
                        )}
                      </tr>
                      <tr>
                        <th scope="row">Giá cuối</th>
                        <td
                          className="text-end fs-3 fw-bold text-success"
                          colSpan={3}
                        >
                          {formattedFinalPrice}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <button className="button">
              <Link to={"/"}>Trở về trang chủ</Link>
            </button>
            {/* <button onClick={handleSubmit}>Cập nhật</button> */}
          </div>
        ) : (
          <div>
            <div className="mt-10" style={{ height: "200px" }}></div>
            <h2 className="text-danger">Thanh toán thất bại</h2>
            <button className="rounded text-white bg-primary">
              <Link to={"/"}>Trở về trang chủ</Link>
            </button>
          </div>
        )}
      </div>
    </div>
  );
};

export default BillSuccess;
