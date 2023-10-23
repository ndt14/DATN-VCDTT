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
  // const userId = userData.id;
  // console.log(billId);
  // console.log(typeof billId);

  const { data: billData } = useGetBillByIdQuery(billId || "");
  // console.log(billData);

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
    <div className="container">
      {transactionStatus === "00" ? (
        <div>
          <div className="mt-10" style={{ height: "200px" }}></div>
          <h1>Thanh toán thành công</h1>
          <div>
            <h3>Hóa đơn</h3>
            <div className="border">
              <p>Mã thanh toán: {transactionId}</p>
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
          <h1>Thanh toán thất bại</h1>
          <button className="rounded text-white">
            <Link to={"/"}>Trở về trang chủ</Link>
          </button>
        </div>
      )}
    </div>
  );
};

export default BillSuccess;
