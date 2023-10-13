import React from "react";
import { Link } from "react-router-dom";
import { useNavigate } from "react-router-dom";

const BillSuccess = () => {
  const url = new URL(window.location.href);
  const searchParams = new URLSearchParams(url.search);
  const transactionStatus = searchParams.get("vnp_TransactionStatus");
  const navigate = useNavigate();
  return (
    <div className="container">
      {transactionStatus === "00" ? (
        <div>
          <div className="mt-10" style={{ height: "200px" }}></div>
          <h1>Thanh toán thành công</h1>
          <button className="button">
            <Link to={"/"}>Trở về trang chủ</Link>
          </button>
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
