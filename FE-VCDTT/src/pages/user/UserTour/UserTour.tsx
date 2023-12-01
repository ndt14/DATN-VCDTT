import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import {
  useGetBillsWithUserIDQuery,
  useUpdateBillMutation,
} from "../../../api/bill";
import { useGetUserByIdQuery } from "../../../api/user";
import { Bill } from "../../../interfaces/Bill";
import { Button, Popconfirm } from "antd";
import ReactPaginate from "react-paginate";
import { IoPersonOutline } from "react-icons/io5";
import { FaRegHeart } from "react-icons/fa";
import { FaRegListAlt } from "react-icons/fa";
import Modal from "react-bootstrap/Modal";
import { ChangeEvent, MouseEvent } from "react";
// import { CheckboxChangeEvent } from "antd";

import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";

const MySwal = withReactContent(Swal);

const UserTour = () => {
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  const userId = user?.id;
  const { data: TourData } = useGetBillsWithUserIDQuery(userId || "");
  const { data: userData } = useGetUserByIdQuery(userId || "");
  const [updateBill] = useUpdateBillMutation();

  useEffect(() => {
    if (TourData) {
      console.log(TourData);
    }
  }, [TourData]);

  const [checked, setChecked] = useState(false);

  const userName = userData?.data?.user.name;

  const userEmail = userData?.data?.user.email;
  const TourList = TourData?.data?.purchase_history;
  console.log(TourList);

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

  // const [showModal, setShowModal] = useState({});

  // const handleButtonClick = (id: any) => {
  //   setShowModal((prevState) => ({
  //     ...prevState,
  //     [id]: true,
  //   }));
  // };

  // const handleCloseModal = (id: any) => {
  //   setShowModal((prevState) => ({
  //     ...prevState,
  //     [id]: false,
  //   }));
  // };

  const [show, setShow] = useState(false);
  const [showQR, setShowQR] = useState(false);
  const handleShowQR = () => setShowQR(true);
  const handleCloseQR = () => setShowQR(false);

  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);

  const openPolicy = (id: number) => {
    window.open(`/user/policy/${id}`, "_blank");
  };
  //
  // const cancelTour = async (id: number) => {
  //   const data:any = {
  //     purchase_status: 6,
  //     payment_status: 1,
  //     id: id,
  //   };

  //   await updateBill(data).then(() => {
  //     alert("Hủy tour thành công");
  //   });
  // };
  // interface PurchaseData {
  //   purchase_status: number;
  //   payment_status: number;
  //   comfirm_click: number;
  //   id: number;
  // }

  const confirmPayment = async (id: number) => {
    const data: Bill = {
      purchase_status: 2,
      payment_status: 2,
      comfirm_click: 2,
      id: id,
      data: undefined,
    };
    console.log(data);

    await updateBill(data).then(() => {
      MySwal.fire({
        text: "Chúng tôi đã nhận được xác nhận đã thanh toán của bạn. Admin sẽ xác nhận và cập nhật đơn hàng của bạn sớm nhất có thể",
        icon: "success",
        confirmButtonText: "Tôi đã hiểu",
      });
    });
  };

  const cancelTourRefund = async (id: number) => {
    const data: Bill = {
      purchase_status: 4,
      payment_status: 2,
      id: id,
      data: undefined,
    };

    await updateBill(data).then(() => {
      MySwal.fire({
        text: "Bạn đã yêu cầu hủy tour. Đang đợi admin xác nhận",
        icon: "success",
        confirmButtonText: "Đồng ý",
      });
    });
  };

  // const updateBillQR = () => {
  //   const data:Bill = {
  //     id: id,
  //     payment_status: 2,
  //     comfirm_click: 2,
  //     data: undefined,
  //   };
  //   updatePaymentStatus(data).then(() => {
  //     if (isLoggedIn && isLoggedIn == true) {
  //       alert(
  //         "Bạn xác nhận đã thanh toán. Hãy đợi chúng tôi xác nhận thanh toán đơn hàng của bạn"
  //       );
  //       navigate("/user/tours");
  //       window.location.reload();
  //     } else {
  //       alert(
  //         "Bạn xác nhận đã thanh toán. Hãy đợi chúng tôi xác nhận thanh toán đơn hàng của bạn. Hãy đăng ký/đăng nhập để trải nghiệm các dịch vụ ưu đãi cho người dùng"
  //       );
  //       navigate("/");
  //       window.location.reload();
  //     }
  //   });
  // };

  const handleCheckboxChange = (e: ChangeEvent<HTMLInputElement>) => {
    setChecked(e.target.checked);
  };

  const handleButtonDisabledClick = (e: MouseEvent<HTMLButtonElement>) => {
    e.stopPropagation(); // Prevent event propagation
  };

  const cancel = () => {};

  const titleElement = document.querySelector("title");
  if (titleElement) {
    titleElement.innerText = "Thông tin người dùng";
  }

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
              <h1 className="inner-title">Thông tin tài khoản</h1>
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

              <nav className="nav flex-column">
                <Link className="nav-link" to={"/user/profile"}>
                  <IoPersonOutline />
                  Thông tin cá nhân
                </Link>
                <Link
                  className="nav-link text-white"
                  style={{ backgroundColor: "#1677FF" }}
                  to={"/user/tours"}
                >
                  <FaRegListAlt /> Tour đã đặt
                </Link>
                <Link className="nav-link" to={"/user/favorite"}>
                  <FaRegHeart /> Tour yêu thích
                </Link>
                <Link className="nav-link" to={"/user/coupon"}>
                  <FaRegListAlt /> Mã Giảm giá
                </Link>
              </nav>

              {/* End left panel */}
            </div>
          </div>
          <div className="col-8">
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
                // const handleCancelTour = () => {
                //   if (id) {
                //     cancelTour(id);
                //   }
                // };
                const handleCancelTourRefund = () => {
                  if (id) {
                    cancelTourRefund(id);
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
                console.log(coupon_fixed);
                console.log(coupon_percentage);
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
                            Chuyển khoản ngân hàng
                          </span>
                        ) : (
                          <span className="fw-bold">VNPAY</span>
                        )}
                      </p>
                      <p>
                        Trạng thái thanh toán:{" "}
                        <span className="fw-bold">{paymentStatus}</span>
                      </p>
                      <p>
                        Trạng thái đơn hàng:{" "}
                        <span className="fw-bold">{billStatus}</span>
                      </p>
                      <p>
                        Trạng thái tour:{" "}
                        <span className="fw-bold">{tourStatus}</span>
                      </p>

                      <button
                        type="button"
                        data-toggle="modal"
                        data-target={`#bill-${id}`}
                        className="btn-continue"
                      >
                        Chi tiết
                      </button>

                      {payment_status == 1 &&
                      purchase_status == 2 &&
                      purchase_method == 1 &&
                      comfirm_click == 1 ? (
                        <span>
                          <button
                            className="btn btn-success ml-3 rounded-md"
                            style={{ height: "48px", borderRadius: "8px" }}
                            onClick={handleShowQR}
                          >
                            Xác nhận đã chuyển khoản
                          </button>
                          <Modal
                            show={showQR}
                            onHide={handleCloseQR}
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
                                    Ngân hàng MB BANK
                                    <br />
                                  </span>
                                  {/* Hiển thị ảnh QR code */}
                                  <img
                                    src="https://baohothuonghieu.com/wp-content/uploads/2021/10/1536893974-QR-CODE-LA-GI-sblaw.jpeg"
                                    alt="QR Code"
                                  />
                                </div>

                                <div className="text-center mt-3">
                                  <span className="fs-4 text-black fw-bold">
                                    Người thụ hưởng: Nguyễn Đức Thịnh <br />
                                    Số tài khoản : 0915220156
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
                                  className="btn btn-danger"
                                  onClick={handleCloseQR}
                                >
                                  Thoát
                                </button>
                                <button
                                  onClick={handleConfirmPayment}
                                  className="btn btn-success"
                                >
                                  Chuyển khoản thành công
                                </button>
                              </div>
                            </Modal.Footer>
                          </Modal>
                        </span>
                      ) : (
                        <div></div>
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
                                    Chuyển khoản ngân hàng
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
                                // <div>
                                //   <Popconfirm
                                //     title="Hủy tour chưa thanh toán"
                                //     description="Bạn có chắc muốn hủy tour?"
                                //     onConfirm={handleCancelTour}
                                //     onCancel={cancel}
                                //     okText="Đồng ý"
                                //     cancelText="Hủy bỏ"
                                //   >
                                //     {/* <button className="btn-continue">Hủy</button> */}
                                //     {checked ? (
                                //       <Button className="btn-continue">
                                //         Hủy tour
                                //       </Button>
                                //     ) : (
                                //       <div></div>
                                //     )}
                                //   </Popconfirm>
                                //   <Checkbox
                                //     checked={checked}
                                //     onChange={handleCheckboxChange}
                                //   >
                                //     Đọc kỹ{" "}
                                //     <a
                                //       className="text-primary"
                                //       onClick={openWindow}
                                //     >
                                //       chính sách
                                //     </a>{" "}
                                //     của chúng tôi nếu bạn muốn hủy tour.
                                //   </Checkbox>
                                // </div>
                                <p className="text-danger">
                                  Đơn hàng sẽ tự động hủy sau 48 tiếng nếu bạn
                                  không thanh toán
                                </p>
                              ) : (
                                <span>
                                  {purchase_status == 3 ? (
                                    <div>
                                      {tour_status == 1 ? (
                                        <div>
                                          <Popconfirm
                                            title="Hủy tour đã thanh toán"
                                            description="Bạn có chắc muốn hủy tour? Bạn sẽ không thể thay đổi khi ấn Đồng ý"
                                            onConfirm={handleCancelTourRefund}
                                            onCancel={cancel}
                                            okText="Đồng ý"
                                            cancelText="Hủy bỏ"
                                          >
                                            {checked ? (
                                              <Button
                                                className="btn-continue"
                                                onClick={
                                                  handleButtonDisabledClick
                                                }
                                              >
                                                Hủy tour
                                              </Button>
                                            ) : (
                                              <div></div>
                                            )}
                                          </Popconfirm>
                                          <div>
                                            <input
                                              className="mr-1"
                                              type="checkbox"
                                              checked={checked}
                                              onChange={handleCheckboxChange}
                                            />
                                            Đọc kỹ{" "}
                                            <a
                                              className="text-primary"
                                              onClick={handleOpenPolicy}
                                            >
                                              chính sách hoàn tiền
                                            </a>{" "}
                                            của chúng tôi nếu bạn muốn hủy tour.
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
            <Button onClick={handleShow}>Launch demo modal</Button>

            <Modal show={show} onHide={handleClose}>
              <Modal.Header closeButton>
                <Modal.Title>Form xác nhận hoàn tiền</Modal.Title>
              </Modal.Header>
              <Modal.Body>
                <form>
                  <div className="row">
                    <div className="col-sm-12">
                      <div className="form-group">
                        <label className="d-inline-flex">
                          Họ tên <div className=" ml-1 text-danger">*</div>
                        </label>
                        <input
                          type="text"
                          name="name"
                          className="input-border"
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
                          name="email"
                          className="input-border"
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
                          name="email"
                          className="input-border"
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
                          name="email"
                          className="input-border"
                        />
                      </div>
                    </div>
                  </div>
                </form>
              </Modal.Body>
              <Modal.Footer>
                <Button onClick={handleClose}>Close</Button>
                <Button onClick={handleClose}>Save Changes</Button>
              </Modal.Footer>
            </Modal>

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
        </div>
      </section>
    </div>
  );
};

export default UserTour;
