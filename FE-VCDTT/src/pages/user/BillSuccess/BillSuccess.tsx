import { Link } from "react-router-dom";
import { useGetBillByIdQuery, useUpdateBillMutation } from "../../../api/bill";
import { useState, useEffect } from "react";
import { Bill } from "../../../interfaces/Bill";
import PDFDocument from "../../../componenets/User/Pdf/PDFDocument";


const BillSuccess = () => {
  const url = new URL(window.location.href);
  const searchParams = new URLSearchParams(url.search);
  const transactionStatus = searchParams.get("vnp_TransactionStatus");
  const transactionId = searchParams.get("vnp_TransactionNo");
  console.log(transactionId);
  const billId = JSON.parse(localStorage.getItem("billIdSuccess") ||"");
  const userData = JSON.parse(localStorage.getItem("user") || "");
  const loginStatus = JSON.parse(localStorage.getItem("isLoggedIn") || "");
  const tempUserData = JSON.parse(localStorage.getItem("tempUser") || "");
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
            purchase_status: 2,
            comfirm_click: 2,
            data: undefined
          };
          await updateBill(updatedBillData);
        } else {
          const updatedBillData: Bill = {
            id: billId,
            transaction_id: transactionId !== null ? +transactionId : undefined,
            payment_status: 1,
            data: undefined
          };
          await updateBill(updatedBillData);
        }
      } catch (error) {
        console.error("Error updating bill:", error);
      }
    };

    updateBillAfterLoad();
  }, []);

  const [isPrinting, setIsPrinting] = useState(false);

  const handlePrintPDF = () => {
    setIsPrinting(true);

    // // Wait for the next render cycle to ensure the HTML is updated
    // setTimeout(async () => {
    //   try {
    //     const pdfElement = document.getElementById('your-element-id'); // Replace 'your-element-id' with the ID of the element containing the content you want to convert to PDF
    //     const canvas = await html2canvas(pdfElement);
    //     const pdf = new jsPDF();
    //     pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, pdf.internal.pageSize.getWidth(), pdf.internal.pageSize.getHeight());
    //     pdf.save('payment_receipt.pdf');
    //   } catch (error) {
    //     console.error('Error generating PDF:', error);
    //   } finally {
    //     setIsPrinting(true);
    //   }
    // });
  };
  const apiData = {
    paymentStatus: "Thanh toán thành công",
    userName: userName,
    userEmail: userEmail,
    phoneNumber: phoneNumber,
    transactionId: transactionId,
    imageSrc: "../../../../assets/images/VCDTT_logo-removebg-preview.png",
    tourName: billData?.data.purchase_history.tour_name,
    adultCount: billData?.data.purchase_history.adult_count,
    tourAdultPrice: billData?.data.purchase_history.tour_adult_price,
    totalAdultPrice: totalAdultPrice,
    childCount: billData?.data.purchase_history.child_count,
    tourChildPrice: billData?.data.purchase_history.tour_child_price,
    totalChildPrice: totalChildPrice,
    totalPrice: totalPrice,
    couponPercentage: billData?.data.purchase_history.coupon_percentage,
    couponFixed: billData?.data.purchase_history.coupon_fixed,
    formattedFinalPrice: formattedFinalPrice,
    titles: "Thông tin mua hàng",
    fullName: "Ho và tên:",
    email: "Email:",
    phone: "Số điện thoại:",
  };

  const backgroundImageUrl = "../../../../assets/images/inner-banner.jpg";

  const containerStyle = {
    background: `url(${backgroundImageUrl})`,
    backgroundSize: "cover",
  };

  return (
    <div>
      <section className="inner-banner-wrap">
        <div className="inner-baner-container" style={containerStyle}>
          <div className="container">
            <div className="inner-banner-content">
              <h1 className="inner-title">Tình trạng thanh toán</h1>
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
                    <p>
                      Họ và tên:{" "}
                      <span className="font-weight-bold">{userName}</span>
                    </p>
                    <p>
                      Email:{" "}
                      <span className="font-weight-bold">{userEmail}</span>
                    </p>
                    <p>
                      Số điện thoại:{" "}
                      <span className="font-weight-bold">{phoneNumber}</span>
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
                    <p>Mã số thanh toán: {transactionId}</p>
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
                          }).format(totalAdultPrice)}
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
                          }).format(totalChildPrice)}
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Tổng</th>
                        <td className="text-end" colSpan={3}>
                          {new Intl.NumberFormat("vi-VN", {
                            style: "currency",
                            currency: "VND",
                          }).format(totalPrice)}
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
            <div className="">
              <button className="btn-continue text-light mr-3">
                <Link className="text-light" to={"/"}>
                  Trở về trang chủ
                </Link>
              </button>

              <button className="btn-continue" onClick={handlePrintPDF}>
                In đơn hàng của bạn
              </button>
            </div>

            {isPrinting && (
              <div id="your-element-id">
                <PDFDocument data={apiData} />
              </div>
            )}
            {/* <button onClick={handleSubmit}>Cập nhật</button> */}
          </div>
        ) : (
          <div>
            <div className="mt-10"></div>
            <h2 className="text-danger">Thanh toán thất bại</h2>
            <button className="btn-continue text-light mr-3">
              <Link className="text-light" to={"/"}>
                Trở về trang chủ
              </Link>
            </button>
          </div>
        )}
      </div>
    </div>
  );
};

export default BillSuccess;
