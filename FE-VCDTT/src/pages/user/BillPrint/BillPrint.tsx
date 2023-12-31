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
import CryptoJS from "crypto-js";
import Loader from "../../../componenets/User/Loader";

const BillPrint = () => {
  const { id } = useParams<{ id: string }>();
  // const secretKey = "i47Mm0anr583zFb0SdXHCjX19rETnZ85kBkOQlRpH78";
  const encryptId = (id: number) => {
    const key = "i47Mm0anr583zFb0SdXHCjX19rETnZ85kBkOQlRpH78";
    const iv = CryptoJS.lib.WordArray.random(16); // Generate a random IV

    // Convert the ID to ciphertext using AES encryption
    const ciphertext = CryptoJS.AES.encrypt(
      id.toString(),
      CryptoJS.enc.Base64.parse(key),
      {
        iv: iv,
      }
    ).toString();

    // Create an object to store the IV and ciphertext
    const encrypted = {
      iv: CryptoJS.enc.Base64.stringify(iv),
      value: ciphertext,
    };

    // Convert the encrypted object to a JSON string and base64 encode it
    const encodedEncrypted = btoa(JSON.stringify(encrypted));

    return encodedEncrypted;
  };
  const encryptIdUrl = encryptId(15);
  console.log(encryptIdUrl);

  const decryptIdUrl = (id: string) => {
    const key = "i47Mm0anr583zFb0SdXHCjX19rETnZ85kBkOQlRpH78";
    const decodedEncrypted = atob(id);
    const parsedEncrypted = JSON.parse(decodedEncrypted);
    // console.log("Laravel encryption result", parsedEncrypted);
    // IV is base64 encoded in Laravel, expected as WordArray in cryptojs
    const iv = CryptoJS.enc.Base64.parse(parsedEncrypted.iv);
    // Value (cipher text) is also base64 encoded in Laravel, same in cryptojs
    const value = parsedEncrypted.value;
    // Key is base64 encoded in Laravel, WordArray expected in cryptojs
    const parsedKey = CryptoJS.enc.Base64.parse(key);
    const decrypted = CryptoJS.AES.decrypt(value, parsedKey, {
      iv: iv,
    });
    const decryptedText = decrypted.toString(CryptoJS.enc.Utf8);
    console.log(decryptedText);
    return decryptedText;
  };
  const decryptedId = decryptIdUrl(id || "");
  console.log(id);
  console.log(decryptedId);

  // const decryptId = (encryptedId: string) => {
  //   const decryptedBytes = CryptoJS.AES.decrypt(encryptedId, secretKey);
  //   // const decrypted = CryptoJS.AES.decrypt(value, key, {
  //   //   iv: iv,
  //   // });
  //   const decryptedId = decryptedBytes.toString(CryptoJS.enc.Utf8);
  //   // const decryptedId = CryptoJS.AES.decrypt(
  //   //   { ciphertext: encrypted },
  //   //   CryptoJS.enc.Utf8.parse(secretKey),
  //   //   { iv: iv, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7 }
  //   // );
  //   return parseInt(decryptedId, 10);
  // };

  if (typeof id === "undefined") {
    // Xử lý khi giá trị id không tồn tại
    return null; // Hoặc thực hiện xử lý khác tùy theo yêu cầu của bạn
  }

  let billId: number = 0;
  if (id === undefined) {
    // Handle the case when id is undefined
    // For example, you can set a default value or show an error message
  } else {
    billId = Number(decryptedId);
  }
  // console.log(billId);

  // eslint-disable-next-line react-hooks/rules-of-hooks
  const { data: billData } = useGetBillByIdQuery(decryptedId || "");
  // console.log(billData?.data.purchase_history);
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  const userId = user?.id;

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
    const [idArray, setIdArray] = useState<number[]>([]);
    const { data: billsData } = useGetBillsWithUserIDQuery(userId || "");
    console.log(billsData);

    useEffect(() => {
      if (billsData) {
        const bills = billsData.data.purchase_history;
        console.log(bills);
        const array = bills.map((item: Tour) => item.id);
        setIdArray(array);
      }
    }, [billsData]);
    console.log(idArray);
    const isBillIdIncluded = idArray.includes(billId);
    console.log(isBillIdIncluded);
  };

  if (decryptedId) {
    return (
      <>
        <Loader />
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
                    <p>
                      Mã đơn hàng:{" "}
                      <span className="font-weight-bold">{decryptedId}</span>
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
                          <span className="fw-bold">
                            Chuyển khoản trực tiếp
                          </span>{" "}
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
                                  billData?.data?.purchase_history
                                    ?.adult_count +
                                  billData?.data.purchase_history
                                    .tour_child_price *
                                    billData?.data.purchase_history
                                      .child_count) *
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
                                  billData?.data?.purchase_history
                                    ?.adult_count +
                                  billData?.data.purchase_history
                                    .tour_child_price *
                                    billData?.data.purchase_history
                                      .child_count -
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
      </>
    );
  } else {
    return <NotFoundPage />;
  }
};

export default BillPrint;
