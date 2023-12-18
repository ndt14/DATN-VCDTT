import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import {
  useGetBillsWithUserIDQuery,
  useUpdateBillMutation,
} from "../../../api/bill";
import { useGetUserByIdQuery } from "../../../api/user";
import { Bill } from "../../../interfaces/Bill";
import { Button, Skeleton, Spin } from "antd";
import ReactPaginate from "react-paginate";
import { IoPersonOutline } from "react-icons/io5";
import { FaRegHeart } from "react-icons/fa";
import { FaRegListAlt } from "react-icons/fa";
import Modal from "react-bootstrap/Modal";
import { ChangeEvent } from "react";
// import { CheckboxChangeEvent } from "antd";
import {
  useGetBankAccountNameQuery,
  useGetBankContentQuery,
  useGetBankImageQuery,
  useGetBankNameQuery,
  useGetBankNumberQuery,
} from "../../../api/setting";
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";
import SecondaryBanner from "../../../componenets/User/SecondaryBanner";
import { Setting } from "../../../interfaces/Setting";
// import { spawn } from "child_process";
import CryptoJS from "crypto-js";

const MySwal = withReactContent(Swal);

const UserTour = () => {
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  const userId = user?.id;
  const { data: TourData, isLoading } = useGetBillsWithUserIDQuery(
    userId || ""
  );
  const { data: userData } = useGetUserByIdQuery(userId || "");
  const [updateBill] = useUpdateBillMutation();

  // Xử lý form hủy tour
  interface FormValues {
    name: string;
    phone_number: string;
    id?: number;
    bank_number?: number;
    cancel_reason?: string;
    data: undefined;
    purchase_status: number;
  }

  const [formValues, setFormValues] = useState<FormValues>({
    id: 0,
    name: "",
    phone_number: "",
    bank_number: 0,
    cancel_reason: "",
    purchase_status: 3,
    data: undefined,
  });

  const [hasFormChanged, setHasFormChanged] = useState(false);

  const [selectedForm, setSelectedForm] = useState<number>(); //id form hủy tour cho đơn hàng
  const [selectedDetailModal, setSelectedDetailModal] = useState<
    number | null | undefined
  >(null);
  const [showQR, setShowQR] = useState<number>(0);

  // const modalCancelOpen = (id: number) => {
  //   setSelectedForm(id);
  //   setSelectedDetailModal(0);
  // };

  const handleModalCancelClose = () => {
    setSelectedForm(0);
  };

  const modalOpenDetail = (id: number) => {
    setSelectedDetailModal(id);
  };

  const handleModalCloseDetail = () => {
    setSelectedDetailModal(0);
  };

  const handleModalCloseQR = () => {
    setShowQR(0);
  };

  useEffect(() => {
    if (userData) {
      const { name, phone_number } = userData.data.user;
      setFormValues({
        ...formValues,
        name: name || "",
        phone_number: phone_number || "",
      });
    }
  }, [userData]);

  const handleInputChange = (
    event: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>
  ) => {
    const { name, value } = event.target;
    setFormValues((prevValues) => ({
      ...prevValues,
      [name]: value,
    }));
  };

  const submit = async (id: number) => {
    // console.log(id);
    await setFormValues((prevFormValues) => ({
      ...prevFormValues,
      id: id,
      purchase_status: 4,
    }));
    setHasFormChanged(true);
  };

  useEffect(() => {
    if (hasFormChanged) {
      updateBill(formValues)
        .then(() => {
          return MySwal.fire({
            title: "Bạn chắc chắn gửi?",
            text: "Bạn sẽ không thể quay lại nếu gửi đi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Tiếp tục gửi!",
            cancelButtonText: "Quay lại",
          });
        })
        .then(async (result) => {
          if (result.isConfirmed) {
            await MySwal.fire({
              title: "Gửi thành công vui lòng đợi admin xác nhận!",
              icon: "success",
              // timer: 6000,
            });

            setHasFormChanged(false);
            window.location.reload();
          }
        })
        .catch((error) => {
          console.error(error);
        });
    }
  }, [hasFormChanged, formValues]);

  const [checked, setChecked] = useState(false);

  const userName = userData?.data?.user.name;

  const userEmail = userData?.data?.user.email;
  // const TourList = TourData?.data?.purchase_history;
  // console.log(TourList);

  //phân trang
  const [currentPage, setCurrentPage] = useState<number>(0);
  const handlePageChange = (selectedPage: { selected: number }) => {
    setCurrentPage(selectedPage.selected);
  };
  const itemsPerPage = 4;
  const pageCount = Math.ceil(
    TourData?.data?.purchase_history.length / itemsPerPage
  );
  const currentData: Bill[] = (TourData?.data?.purchase_history.slice(
    currentPage * itemsPerPage,
    (currentPage + 1) * itemsPerPage
  ) || []) as Bill[];
  //end phân trang

  const goToPayment = (id: number) => {
    const VnpayURL = `http://be-vcdtt.datn-vcdtt.test/api/vnpay-payment/${id}`;
    window.location.href = VnpayURL;
  };

  const openPolicy = (id: number) => {
    window.open(`/user/policy/${id}`, "_blank");
  };

  const [loading, setLoading] = useState(false);

  const confirmPayment = async (id: number) => {
    setLoading(true);
    const data: Bill = {
      purchase_status: 2,
      payment_status: 2,
      comfirm_click: 2,
      id: id,
      data: undefined,
    };

    console.log(data);

    try {
      await updateBill(data);

      MySwal.fire({
        text: "Chúng tôi đã nhận được xác nhận đã thanh toán của bạn. Admin sẽ xác nhận và cập nhật đơn hàng của bạn sớm nhất có thể",
        icon: "success",
        showCancelButton: false,
        showConfirmButton: false,
        timer: 4000,
      });

      // Wait for 4000 milliseconds (4 seconds) before reloading
      await new Promise((resolve) => setTimeout(resolve, 4000));

      // Reload the window
      window.location.reload();
    } catch (error) {
      console.error(error);
      // Handle errors if needed
    }
  };

  // const cancelTourRefund = async (id: number) => {
  //   const data: Bill = {
  //     purchase_status: 4,
  //     payment_status: 2,
  //     id: id,
  //     data: undefined,
  //   };

  //   await updateBill(data).then(() => {
  //     MySwal.fire({
  //       text: "Bạn đã yêu cầu hủy tour. Đang đợi admin xác nhận",
  //       icon: "success",
  //       confirmButtonText: "Đồng ý",
  //     });
  //   });
  // };

  const handleCheckboxChange = (e: ChangeEvent<HTMLInputElement>) => {
    setChecked(e.target.checked);
  };

  const titleElement = document.querySelector("title");
  if (titleElement) {
    titleElement.innerText = "Thông tin người dùng";
  }
  const dataTitle = "Tour đã đặt";
  //api  setting
  const { data: bankName } = useGetBankNameQuery();
  const { data: bankImage } = useGetBankImageQuery();
  const { data: bankNumber } = useGetBankNumberQuery();
  const { data: bankNameUse } = useGetBankAccountNameQuery();
  const { data: bankContent } = useGetBankContentQuery();
  return (
    <div>
      <SecondaryBanner>{dataTitle}</SecondaryBanner>

      <section className="container" style={{ marginBottom: "200px" }}>
        <div className="row">
          {isLoading ? (
            <Skeleton active />
          ) : (
            <div className="col-md-4">
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

                <nav className="nav flex-column">
                  <Link className="nav-link text-black" to={"/user/profile"}>
                    <IoPersonOutline />
                    Thông tin cá nhân
                  </Link>
                  <Link
                    className="nav-link text-white "
                    style={{ backgroundColor: "#1677FF" }}
                    to={"/user/tours"}
                  >
                    <FaRegListAlt /> Tour đã đặt
                  </Link>

                  <Link className="nav-link text-black" to={"/user/favorite"}>
                    <FaRegHeart /> Tour yêu thích
                  </Link>
                  <Link className="nav-link text-black" to={"/user/coupon"}>
                    <FaRegListAlt /> Mã Giảm giá
                  </Link>
                </nav>

                {/* End left panel */}
              </div>
            </div>
          )}
          {isLoading ? (
            <Skeleton active />
          ) : (
            <div className="col-md-8">
              {/*  */}

              <h3>Danh sách tour</h3>

              {currentData?.map(
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
                  purchase_method,
                  purchase_status,
                  phone_number,
                  tour_status,
                  tour_image,
                  comfirm_click,
                }: Bill) => {
                  const handleGoToPayment = () => {
                    if (id) {
                      goToPayment(id);
                    }
                  };
                  const handleConfirmPayment = () => {
                    if (id) {
                      confirmPayment(id);
                    }
                  };
                  const handleOpenPolicy = () => {
                    if (id) {
                      openPolicy(id);
                    }
                  };
                  const handleSubmit = () => {
                    if (id) {
                      submit(id);
                    }
                  };
                  const handleModalOpenDetail = () => {
                    if (id) {
                      modalOpenDetail(id);
                    }
                  };
                  const modalCancelOpen = (id: number) => {
                    setSelectedForm(id);
                    setSelectedDetailModal(0);
                  };

                  const modalOpenQR = (id: number) => {
                    setShowQR(id);
                  };
                  let billStatus;
                  if (purchase_status === 1) {
                    billStatus = "Tự động hủy do quá hạn";
                  } else if (purchase_status === 2) {
                    billStatus = "Chưa phê duyệt thanh toán";
                  } else if (purchase_status === 3) {
                    billStatus = "Đã phê duyệt thanh toán";
                  } else if (purchase_status === 4) {
                    billStatus = "Chưa phê duyệt hủy tour";
                  } else if (purchase_status === 5) {
                    billStatus = "Đã phê duyệt hủy tour, chưa hoàn tiền";
                  } else if (purchase_status === 6) {
                    billStatus = "Đã hủy thành công";
                  } else if (purchase_status === 7) {
                    billStatus = "Chuyển khoản thiếu";
                  } else if (purchase_status === 8) {
                    billStatus = "Chuyển khoản thừa";
                  }

                  let paymentStatus;
                  if (payment_status == 1) {
                    paymentStatus = "Chưa thanh toán";
                  } else if (payment_status == 2) {
                    paymentStatus = "Đã thanh toán";
                  }

                  let tourStatus;
                  if (tour_status == 1) {
                    tourStatus = "Chưa tới ngày đi";
                  } else if (tour_status == 2) {
                    tourStatus = "Đang diễn ra";
                  } else if (tour_status == 3) {
                    tourStatus = "Tour đã kết thúc";
                  } else if (tour_status == 4) {
                    tourStatus = "Còn 1 ngày trước ngày đi tour";
                  }
                  // console.log(coupon_fixed);

                  const finalPrice = coupon_fixed
                    ? (adult_count ?? 0) * (tour_adult_price ?? 0) +
                      (child_count ?? 0) * (tour_child_price ?? 0) -
                      coupon_fixed
                    : ((adult_count ?? 0) * (tour_adult_price ?? 0) +
                        (child_count ?? 0) * (tour_child_price ?? 0)) *
                      (1 - (coupon_percentage ?? 0) / 100);
                  const formattedFinalPrice = new Intl.NumberFormat("vi-VN", {
                    style: "currency",
                    currency: "VND",
                  }).format(finalPrice);

                  const encryptId = (id: number | undefined): string => {
                    const key = "i47Mm0anr583zFb0SdXHCjX19rETnZ85kBkOQlRpH78";
                    const iv = CryptoJS.lib.WordArray.random(16); // Generate a random IV
                    let ciphertext;
                    // Convert the ID to ciphertext using AES encryption
                    if (id !== undefined) {
                      ciphertext = CryptoJS.AES.encrypt(
                        id.toString(),
                        CryptoJS.enc.Base64.parse(key),
                        {
                          iv: iv,
                        }
                      ).toString();
                    }

                    // Create an object to store the IV and ciphertext
                    const encrypted = {
                      iv: CryptoJS.enc.Base64.stringify(iv),
                      value: ciphertext,
                    };

                    // Convert the encrypted object to a JSON string and base64 encode it
                    const encodedEncrypted = btoa(JSON.stringify(encrypted));

                    return encodedEncrypted;
                  };

                  const encryptedOrderId = encryptId(id);

                  return (
                    <div className="p-3 my-3 shadow row" key={id}>
                      <div className="col-8">
                        <p>
                          Mã đơn: <span className="fw-bold">{id}</span>
                        </p>
                        <div>
                          {purchase_method == 2 ? (
                            <p>
                              Mã giao dịch VNPAY:{" "}
                              <span className="fw-bold">{transaction_id}</span>
                            </p>
                          ) : (
                            <span></span>
                          )}
                        </div>
                        <p>
                          Tên tour: <span className="fw-bold">{tour_name}</span>
                        </p>
                        <p>
                          Giá:{" "}
                          <span className="fw-bold">{formattedFinalPrice}</span>
                        </p>
                        <p>
                          Phương thức thanh toán:{" "}
                          {purchase_method == 1 ? (
                            <span className="fw-bold">
                              Chuyển khoản trực tiếp
                            </span>
                          ) : (
                            <span className="fw-bold">VNPAY</span>
                          )}
                        </p>
                        <p>
                          Trạng thái đơn hàng:{" "}
                          <span className="fw-bold">{billStatus}</span>
                        </p>
                        <p>
                          Trạng thái thanh toán:{" "}
                          <span className="fw-bold">{paymentStatus}</span>
                        </p>

                        <p>
                          Trạng thái tour:{" "}
                          <span className="fw-bold">{tourStatus}</span>
                        </p>

                        {/* <button
                        type="button"
                        data-toggle="modal"
                        data-target={`#bill-${id}`}
                        className="btn-continue"
                      >
                        Chi tiết
                      </button> */}
                        <Button
                          onClick={handleModalOpenDetail}
                          className="bg-primary text-white button"
                          // onHide={handleModalCancelClose}
                        >
                          Chi tiết
                        </Button>
                        {/*  */}
                        {purchase_status == 3 ? (
                          <Button className="ml-2">
                            <Link
                              to={`/user/view-bill/${encodeURIComponent(
                                encryptedOrderId
                              )}`}
                            >
                              Xem hóa đơn
                            </Link>
                          </Button>
                        ) : (
                          <span></span>
                        )}
                        <Modal
                          show={selectedDetailModal == id}
                          onHide={handleModalCloseDetail}
                          size="lg"
                        >
                          <Modal.Header closeButton>
                            <h3
                              className="modal-title text-primary"
                              id="exampleModalLabel"
                            >
                              Chi tiết đơn hàng số <span>{id}</span>
                            </h3>
                          </Modal.Header>
                          <Modal.Body>
                            <div className="modal-body">
                              <h3>Thông tin khách hàng</h3>
                              <p>
                                Họ và tên:{" "}
                                <span className="fw-bold">{name}</span>
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
                              <div>
                                {purchase_method == 1 ? (
                                  <div>
                                    <p>
                                      Mã số thanh toán VNPAY:{" "}
                                      <span className="fw-bold">
                                        {transaction_id ? (
                                          <span>{transaction_id}</span>
                                        ) : (
                                          <span>Chưa có</span>
                                        )}
                                      </span>
                                    </p>
                                  </div>
                                ) : (
                                  <div></div>
                                )}
                              </div>

                              <p>
                                Tên tour:{" "}
                                <span className="fw-bold">{tour_name}</span>
                              </p>
                              <p>
                                Phương thức thanh toán:{" "}
                                {purchase_method == 1 ? (
                                  <span className="fw-bold">
                                    Chuyển khoản trực tiếp
                                  </span>
                                ) : (
                                  <span className="fw-bold">VNPAY</span>
                                )}
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
                              {coupon_fixed != 0 && coupon_fixed != null ? (
                                <div>
                                  <p>
                                    Coupon:{" "}
                                    <span className="fw-bold">
                                      Giảm {coupon_fixed}đ
                                    </span>
                                  </p>
                                </div>
                              ) : (
                                <div>
                                  {coupon_percentage != null ? (
                                    <p>
                                      Coupon:{" "}
                                      <span className="fw-bold">
                                        Giảm {coupon_percentage}%
                                      </span>
                                    </p>
                                  ) : (
                                    <p>
                                      Coupon:{" "}
                                      <span className="fw-bold">Không có</span>
                                    </p>
                                  )}
                                </div>
                              )}

                              <p>
                                Giá tour:{" "}
                                <span className="fw-bold">
                                  {formattedFinalPrice}
                                </span>
                              </p>
                              <div className="d-flex justify-content-between">
                                <p>
                                  Ngày bắt đầu tour:{" "}
                                  <span className="fw-bold">
                                    {tour_start_time}
                                  </span>
                                </p>
                                <p>
                                  Ngày kết thúc tour:{" "}
                                  <span className="fw-bold">
                                    {tour_end_time}
                                  </span>
                                </p>
                              </div>
                              <p>
                                Trạng thái đơn hàng:{" "}
                                <span className="fw-bold text-danger">
                                  {billStatus}
                                </span>
                              </p>
                              <p>
                                Trạng thái thanh toán:{" "}
                                <span className="fw-bold text-danger">
                                  {paymentStatus}
                                </span>
                              </p>
                              <p>
                                Trạng thái tour:{" "}
                                <span className="fw-bold text-danger">
                                  {tourStatus}
                                </span>
                              </p>

                              {purchase_method == 2 &&
                              payment_status == 1 &&
                              tour_status == 1 ? (
                                <button
                                  className="btn-continue mr-2"
                                  onClick={handleGoToPayment}
                                >
                                  Thanh toán VNPAY
                                </button>
                              ) : (
                                <div>
                                  {purchase_status == 6 ? (
                                    <div></div>
                                  ) : (
                                    <div></div>
                                  )}
                                </div>
                              )}
                              {payment_status == 1 && tour_status == 1 ? (
                                <p className="text-danger">
                                  Đơn hàng sẽ tự động hủy sau 24 tiếng nếu bạn
                                  không thanh toán
                                </p>
                              ) : (
                                <span>
                                  {purchase_status == 3 ? (
                                    <div>
                                      {tour_status == 1 ? (
                                        <div>
                                          <div>
                                            <input
                                              className="mr-1"
                                              type="checkbox"
                                              checked={checked}
                                              onChange={handleCheckboxChange}
                                            />
                                            Đọc lại{" "}
                                            <Link
                                              to={""}
                                              className="text-primary"
                                              onClick={handleOpenPolicy}
                                            >
                                              Chính sách & Điều khoản
                                            </Link>{" "}
                                            mà bạn đã đồng ý trước đó với chúng
                                            tôi nếu bạn muốn hủy tour và hoàn
                                            tiền.
                                          </div>
                                          {checked && id ? (
                                            <Button
                                              className="btn-continue"
                                              onClick={() =>
                                                modalCancelOpen(id)
                                              }
                                            >
                                              Hủy tour
                                            </Button>
                                          ) : (
                                            <div></div>
                                          )}
                                        </div>
                                      ) : (
                                        <div></div>
                                      )}
                                    </div>
                                  ) : (
                                    <div></div>
                                  )}
                                </span>
                              )}
                            </div>
                          </Modal.Body>
                          <Modal.Footer>
                            <Button onClick={handleModalCloseDetail}>
                              Đóng
                            </Button>
                            {/* <Button onClick={handleModalCloseDetail}>
                            Save Changes
                          </Button> */}
                          </Modal.Footer>
                        </Modal>

                        {payment_status == 1 &&
                        purchase_status == 2 &&
                        purchase_method == 1 &&
                        comfirm_click == 1 ? (
                          <span>
                            {id ? (
                              <Button
                                className=" btn-success ml-3 rounded-md"
                                // onClick={handleModalOpenQR(id)}
                                onClick={() => modalOpenQR(id)}
                              >
                                Xác nhận đã chuyển khoản
                              </Button>
                            ) : (
                              <span></span>
                            )}

                            {/* Modal chuyển khoản QR */}
                            <Modal
                              show={showQR == id}
                              onHide={handleModalCloseQR}
                              backdrop="static"
                              keyboard={false}
                            >
                              <Modal.Header>
                                <Modal.Title>
                                  <div className="text-center">
                                    Vui lòng quét qr hoặc chuyển khoản cho thông
                                    tin dưới đây
                                  </div>
                                </Modal.Title>
                              </Modal.Header>
                              <Modal.Body>
                                <div className="container">
                                  <div className="text-center">
                                    <span className="fs-4 text-black fw-bold">
                                      Ngân hàng:
                                      {bankName?.data.keyvalue.map(
                                        ({ id, value }: Setting) => {
                                          return <span key={id}> {value}</span>;
                                        }
                                      )}
                                      <br />
                                    </span>
                                    {/* Hiển thị ảnh QR code */}

                                    {bankImage?.data.keyvalue.map(
                                      ({ id, value }: Setting) => {
                                        return (
                                          <img
                                            key={id}
                                            src={value}
                                            alt="QR Code"
                                          />
                                        );
                                      }
                                    )}
                                  </div>

                                  <div className="text-center mt-3">
                                    <span className="fs-4 text-black fw-bold">
                                      Người thụ hưởng:{" "}
                                      {bankNameUse?.data.keyvalue.map(
                                        ({ id, value }: Setting) => {
                                          return <span key={id}> {value}</span>;
                                        }
                                      )}{" "}
                                      <br />
                                      Số tài khoản :
                                      {bankNumber?.data.keyvalue.map(
                                        ({ id, value }: Setting) => {
                                          return <span key={id}> {value}</span>;
                                        }
                                      )}{" "}
                                      <br />
                                      Nội dung chuyển khoản :
                                      {bankContent?.data.keyvalue.map(
                                        ({ id, value }: Setting) => {
                                          return <span key={id}> {value}</span>;
                                        }
                                      )}
                                    </span>
                                  </div>
                                  <div className="text-center mt-3">
                                    <span className="fs-4 text-danger fw-bold">
                                      Số tiền bạn phải chuyển là:{" "}
                                      {formattedFinalPrice}
                                    </span>
                                  </div>
                                </div>
                              </Modal.Body>
                              <Modal.Footer>
                                <div className="text-center">
                                  {/* Thêm nút "Chuyển khoản thành công" */}
                                  <button
                                    className="btn btn-danger mr-2"
                                    onClick={handleModalCloseQR}
                                  >
                                    Thoát
                                  </button>
                                  <button
                                    onClick={handleConfirmPayment}
                                    className="btn btn-success"
                                  >
                                    Chuyển khoản thành công
                                    {loading == true ? (
                                      <Spin className="ml-2" />
                                    ) : (
                                      <span></span>
                                    )}
                                  </button>
                                </div>
                              </Modal.Footer>
                            </Modal>
                          </span>
                        ) : (
                          <span></span>
                        )}

                        {/* Modal chi tiết đơn hàng */}
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
                                <h3
                                  className="modal-title text-primary"
                                  id="exampleModalLabel"
                                >
                                  Chi tiết đơn hàng số <span>{id}</span>
                                </h3>
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
                                  Họ và tên:{" "}
                                  <span className="fw-bold">{name}</span>
                                </p>
                                <p>
                                  Số điện thoại:{" "}
                                  <span className="fw-bold">
                                    {phone_number}
                                  </span>
                                </p>
                                <p>
                                  Email:{" "}
                                  <span className="fw-bold">{email}</span>
                                </p>
                                <hr className="mb-3" />
                                <h3>Thông tin tour</h3>
                                <div>
                                  {purchase_method == 1 ? (
                                    <div>
                                      <p>
                                        Mã số thanh toán VNPAY:{" "}
                                        <span className="fw-bold">
                                          {transaction_id ? (
                                            <span>{transaction_id}</span>
                                          ) : (
                                            <span>Chưa có</span>
                                          )}
                                        </span>
                                      </p>
                                    </div>
                                  ) : (
                                    <div></div>
                                  )}
                                </div>

                                <p>
                                  Tên tour:{" "}
                                  <span className="fw-bold">{tour_name}</span>
                                </p>
                                <p>
                                  Phương thức thanh toán:{" "}
                                  {purchase_method == 1 ? (
                                    <span className="fw-bold">
                                      Chuyển khoản trực tiếp
                                    </span>
                                  ) : (
                                    <span className="fw-bold">VNPAY</span>
                                  )}
                                </p>
                                <div className="d-flex justify-content-between mb-3">
                                  <div>
                                    Số lượng trẻ em:{" "}
                                    <span className="fw-bold">
                                      {child_count}
                                    </span>
                                  </div>
                                  <div>
                                    Số lượng người lớn:{" "}
                                    <span className="fw-bold">
                                      {adult_count}
                                    </span>
                                  </div>
                                </div>
                                {coupon_fixed != 0 && coupon_fixed != null ? (
                                  <div>
                                    <p>
                                      Coupon:{" "}
                                      <span className="fw-bold">
                                        Giảm {coupon_fixed}đ
                                      </span>
                                    </p>
                                  </div>
                                ) : (
                                  <div>
                                    {coupon_percentage != null ? (
                                      <p>
                                        Coupon:{" "}
                                        <span className="fw-bold">
                                          Giảm {coupon_percentage}%
                                        </span>
                                      </p>
                                    ) : (
                                      <p>
                                        Coupon:{" "}
                                        <span className="fw-bold">
                                          Không có
                                        </span>
                                      </p>
                                    )}
                                  </div>
                                )}

                                <p>
                                  Giá tour:{" "}
                                  <span className="fw-bold">
                                    {formattedFinalPrice}
                                  </span>
                                </p>

                                <p>Ngày bắt đầu tour: {tour_start_time}</p>
                                <p>Ngày kết thúc tour: {tour_end_time}</p>
                                <p>
                                  Trạng thái đơn hàng:{" "}
                                  <span className="fw-bold text-danger">
                                    {billStatus}
                                  </span>
                                </p>
                                <p>
                                  Trạng thái thanh toán:{" "}
                                  <span className="fw-bold text-danger">
                                    {paymentStatus}
                                  </span>
                                </p>
                                <p>
                                  Trạng thái tour:{" "}
                                  <span className="fw-bold text-danger">
                                    {tourStatus}
                                  </span>
                                </p>

                                {purchase_method == 2 &&
                                payment_status == 1 &&
                                tour_status == 1 ? (
                                  <button
                                    className="btn-continue mr-2"
                                    onClick={handleGoToPayment}
                                  >
                                    Thanh toán VNPAY
                                  </button>
                                ) : (
                                  <div>
                                    {purchase_status == 6 ? (
                                      <div></div>
                                    ) : (
                                      <div></div>
                                    )}
                                  </div>
                                )}
                                {payment_status == 1 && tour_status == 1 ? (
                                  <p className="text-danger">
                                    Đơn hàng sẽ tự động hủy sau 24 tiếng nếu bạn
                                    không thanh toán
                                  </p>
                                ) : (
                                  <span>
                                    {purchase_status == 3 ? (
                                      <div>
                                        {tour_status == 1 ? (
                                          <div>
                                            {checked && id ? (
                                              <Button
                                                className="btn-continue"
                                                onClick={() =>
                                                  modalCancelOpen(id)
                                                }
                                              >
                                                Hủy tour
                                              </Button>
                                            ) : (
                                              <div></div>
                                            )}

                                            <div>
                                              <input
                                                className="mr-1"
                                                type="checkbox"
                                                checked={checked}
                                                onChange={handleCheckboxChange}
                                              />
                                              Đọc lại{" "}
                                              <Link
                                                to={""}
                                                className="text-primary"
                                                onClick={handleOpenPolicy}
                                              >
                                                Chính sách & Điều khoản
                                              </Link>{" "}
                                              mà bạn đã đồng ý trước đó với
                                              chúng tôi nếu bạn muốn hủy tour và
                                              hoàn tiền.
                                            </div>
                                          </div>
                                        ) : (
                                          <div></div>
                                        )}
                                      </div>
                                    ) : (
                                      <div></div>
                                    )}
                                  </span>
                                )}
                              </div>
                            </div>
                          </div>
                        </div>

                        {/* Modal xác nhận hủy tour */}
                        {/* {selectedForm && ( */}
                        <Modal
                          show={selectedForm == id}
                          onHide={handleModalCancelClose}
                        >
                          <Modal.Header closeButton>
                            <Modal.Title>Form xác nhận hoàn tiền</Modal.Title>
                          </Modal.Header>
                          <Modal.Body>
                            <form>
                              <div className="row">
                                <div className="col-sm-12">
                                  <div className="form-group">
                                    <label className="d-inline-flex">
                                      Họ tên{" "}
                                      <div className=" ml-1 text-danger">*</div>
                                    </label>
                                    <input
                                      type="text"
                                      name="name"
                                      className="input-border"
                                      onChange={handleInputChange}
                                      value={formValues.name}
                                    />
                                  </div>
                                </div>
                                <div className="col-sm-12">
                                  <div className="form-group">
                                    <label className="d-inline-flex">
                                      Số điện thoại{" "}
                                      <div className=" ml-1 text-danger">*</div>
                                    </label>
                                    <input
                                      type="text"
                                      name="phone_number"
                                      className="input-border"
                                      onChange={handleInputChange}
                                      value={formValues.phone_number}
                                    />
                                  </div>
                                </div>
                                <div className="col-sm-12">
                                  <div className="form-group">
                                    <label className="d-inline-flex">
                                      Số tài khoản{" "}
                                      <div className=" ml-1 text-danger">*</div>
                                    </label>
                                    <input
                                      type="text"
                                      name="bank_number"
                                      className="input-border"
                                      placeholder="Số tài khoản - Tên ngân hàng"
                                      onChange={handleInputChange}
                                    />
                                  </div>
                                </div>
                                <div className="col-sm-12">
                                  <div className="form-group">
                                    <label className="d-inline-flex">
                                      Lý do muốn hủy tour{" "}
                                      <div className=" ml-1 text-danger">*</div>
                                    </label>
                                    <input
                                      type="text"
                                      name="cancel_reason"
                                      className="input-border"
                                      onChange={handleInputChange}
                                    />
                                  </div>
                                </div>
                                <div className="col-sm-12 d-none">
                                  <div className="form-group">
                                    <label className="d-inline-flex">
                                      {" "}
                                      <div className=" ml-1 text-danger">*</div>
                                    </label>
                                    <input
                                      type="disbled"
                                      name="id"
                                      className="input-border"
                                      value={formValues.id}
                                      onChange={handleInputChange}
                                    />
                                  </div>
                                </div>
                              </div>
                            </form>
                          </Modal.Body>
                          <Modal.Footer>
                            <Button onClick={handleSubmit}>Gửi</Button>
                            {/* <Button onClick={handleModalCancelClose}>
                              Save Changes
                            </Button> */}
                          </Modal.Footer>
                        </Modal>
                        {/* )} */}

                        <div
                          className="modal fade"
                          id={`bill-cancel-${id}`}
                          role="dialog"
                          aria-labelledby="exampleModalLabel"
                          aria-hidden="true"
                        ></div>

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
                      <div className="col-4">
                        <img src={tour_image} alt="" />
                      </div>
                    </div>
                  );
                }
              )}

              <ReactPaginate
                previousLabel={"<-"}
                nextLabel={"->"}
                breakLabel={"..."}
                pageCount={pageCount}
                onPageChange={handlePageChange}
                containerClassName={"pagination"}
                activeClassName={"active"}
              />
            </div>
          )}
        </div>
      </section>
    </div>
  );
};

export default UserTour;
