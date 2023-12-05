import { Link, useParams } from "react-router-dom";
import {
  useGetBillByIdQuery,
  useGetBillsWithUserIDQuery,
} from "../../../api/bill";
import { useEffect, useState } from "react";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import { Tour } from "../../../interfaces/Tour";
import { NotFoundPage } from "..";

const BillPrint = () => {
  const { id } = useParams<{ id: string | undefined }>();
  console.log(typeof id);
  let billId: number = 0;
  if (id === undefined) {
    // Handle the case when id is undefined
    // For example, you can set a default value or show an error message
  } else {
    billId = parseInt(id);
    // Rest of your code using billId
  }
  const { data: billData } = useGetBillByIdQuery(id || "");
  // console.log(billData?.data.purchase_history);
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  const userId = user?.id;

  // const totalAdultPrice =
  //   billData?.data?.purchase_history?.tour_adult_price *
  //   billData?.data?.purchase_history?.adult_count;
  // const totalChildPrice =
  //   billData?.data.purchase_history.tour_child_price *
  //   billData?.data.purchase_history.child_count;
  // const totalPrice = totalAdultPrice + totalChildPrice;
  // const discount = billData?.data.purchase_history.coupon_percentage
  //   ? billData?.data.purchase_history.coupon_percentage
  //   : billData?.data.purchase_history.coupon_fixed;
  // const finalPrice = billData?.data.purchase_history.coupon_percentage
  //   ? totalPrice * (1 - discount / 100)
  //   : totalPrice - discount;
  // const formattedFinalPrice = new Intl.NumberFormat("vi-VN", {
  //   style: "currency",
  //   currency: "VND",
  // }).format(finalPrice);

  const handlePrintPDF = () => {
    const input = document.getElementById("pdfBill");
    if (input) {
      html2canvas(input)
        .then((canvas) => {
          const imgData = canvas.toDataURL("image/png");
          const pdf = new jsPDF();
          const pdfWidth = pdf.internal.pageSize.getWidth();
          const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
          pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
          const pdfData = pdf.output("blob");
          const pdfUrl = URL.createObjectURL(pdfData);
          window.open(pdfUrl);
        })
        .catch((error) => {
          console.error("Error generating PDF:", error);
        });
    }
  };

  const [idArray, setIdArray] = useState<number[]>([]);
  const { data: billsData } = useGetBillsWithUserIDQuery(userId || "");
  console.log(billsData);

  useEffect(() => {
    if (billsData) {
      // Handle the data when it is available
      const bills = billsData.data.purchase_history;
      console.log(bills);
      // Do something with favoriteTours
      const array = bills.map((item: Tour) => item.id);
      setIdArray(array);
    }
  }, [billsData]);
  console.log(idArray);
  if (idArray.includes(billId)) {
    return (
      <div className="container">
        <div>
          <div className="my-3">
            <button className="btn-continue text-light mr-3">
              <Link className="text-light" to={"/"}>
                Trở về trang chủ
              </Link>
            </button>

            <button className="btn-continue" onClick={handlePrintPDF}>
              Xem đơn PDF
            </button>
          </div>
          <div id="pdfBill">
            <div className="border p-5">
              {/* <p>Mã thanh toán: {transactionId}</p> */}
              <div className="d-flex justify-content-between">
                {/* <h2>Hóa đơn</h2> */}
                <div>{/* <h3>VCDTT</h3> */}</div>
              </div>
              <div className="d-flex justify-content-between">
                <div>
                  <h3>Đơn vị mua hàng</h3>
                  <p>
                    Họ và tên:{" "}
                    <span className="font-weight-bold">
                      {billData?.data.purchase_history.name}
                    </span>
                  </p>
                  <p>
                    Email:{" "}
                    <span className="font-weight-bold">
                      {billData?.data.purchase_history.email}
                    </span>
                  </p>
                  <p>
                    Số điện thoại:{" "}
                    <span className="font-weight-bold">
                      {billData?.data.purchase_history.phone_number}
                    </span>
                  </p>
                </div>
                <div>
                  <h3>Đơn vị bán hàng</h3>
                  <h3>VCDTT</h3>
                  <img
                    style={{ width: "150px" }}
                    src="../../../../assets/images/VCDTT_logo-removebg-preview.png"
                    alt=""
                  />
                  {billData?.data.purchase_history.purchase_method == 1 ? (
                    <div>
                      <p>
                        Phương thức thanh toán:{" "}
                        <span className="fw-bold">Chuyển khoản ngân hàng</span>{" "}
                      </p>
                    </div>
                  ) : (
                    <div>
                      <p>
                        Phương thức thanh toán:{" "}
                        <span className="fw-bold">VNPAY</span>{" "}
                      </p>
                      <p>
                        Mã số thanh toán VNPAY:{" "}
                        <span className="fw-bold">
                          {billData?.data.purchase_history.transaction_id}
                        </span>
                      </p>
                    </div>
                  )}
                </div>
              </div>
              <div className="mt-5">
                <p>
                  Tên tour:{" "}
                  <span className="font-weight-bold fs-4">
                    {billData?.data.purchase_history.tour_name}
                  </span>
                </p>
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
                        {new Intl.NumberFormat("vi-VN", {
                          style: "currency",
                          currency: "VND",
                        }).format(
                          billData?.data.purchase_history.tour_adult_price
                        )}
                      </td>
                      <td>
                        {new Intl.NumberFormat("vi-VN", {
                          style: "currency",
                          currency: "VND",
                        }).format(
                          billData?.data?.purchase_history?.tour_adult_price *
                            billData?.data?.purchase_history?.adult_count
                        )}
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Trẻ em</th>
                      <td>{billData?.data.purchase_history.child_count}</td>
                      <td>
                        {new Intl.NumberFormat("vi-VN", {
                          style: "currency",
                          currency: "VND",
                        }).format(
                          billData?.data.purchase_history.tour_child_price
                        )}
                      </td>
                      <td>
                        {new Intl.NumberFormat("vi-VN", {
                          style: "currency",
                          currency: "VND",
                        }).format(
                          billData?.data.purchase_history.tour_child_price *
                            billData?.data.purchase_history.child_count
                        )}
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Tổng</th>
                      <td className="text-end" colSpan={3}>
                        {new Intl.NumberFormat("vi-VN", {
                          style: "currency",
                          currency: "VND",
                        }).format(
                          billData?.data?.purchase_history?.tour_adult_price *
                            billData?.data?.purchase_history?.adult_count +
                            billData?.data.purchase_history.tour_child_price *
                              billData?.data.purchase_history.child_count
                        )}
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Coupon</th>
                      {billData?.data.purchase_history.coupon_percentage !=
                      null ? (
                        <td className="text-end" colSpan={3}>
                          - {billData?.data.purchase_history.coupon_percentage}%
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
                        className="text-end fs-3 fw-bold text-primary"
                        colSpan={3}
                      >
                        {new Intl.NumberFormat("vi-VN", {
                          style: "currency",
                          currency: "VND",
                        }).format(
                          billData?.data.purchase_history.coupon_percentage
                            ? (billData?.data?.purchase_history
                                ?.tour_adult_price *
                                billData?.data?.purchase_history?.adult_count +
                                billData?.data.purchase_history
                                  .tour_child_price *
                                  billData?.data.purchase_history.child_count) *
                                (1 -
                                  (billData?.data.purchase_history
                                    .coupon_percentage
                                    ? billData?.data.purchase_history
                                        .coupon_percentage
                                    : billData?.data.purchase_history
                                        .coupon_fixed) /
                                    100)
                            : billData?.data?.purchase_history
                                ?.tour_adult_price *
                                billData?.data?.purchase_history?.adult_count +
                                billData?.data.purchase_history
                                  .tour_child_price *
                                  billData?.data.purchase_history.child_count -
                                (billData?.data.purchase_history
                                  .coupon_percentage
                                  ? billData?.data.purchase_history
                                      .coupon_percentage
                                  : billData?.data.purchase_history
                                      .coupon_fixed)
                        )}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  } else {
    return (
      <NotFoundPage />
      // <div>
      //   <h1>Đơn hàng</h1>
      // </div>
    );
  }
};

export default BillPrint;
