import React, { useRef } from "react";
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import {
  useGetBillsWithUserIDQuery,
  useUpdateBillMutation,
} from "../../../api/bill";
import { useGetUserByIdQuery } from "../../../api/user";
import { Bill } from "../../../interfaces/Bill";
import { Button, message, Popconfirm } from "antd";
import ReactPaginate from "react-paginate";
import { IoPersonOutline } from "react-icons/io5";
import { FaRegHeart } from "react-icons/fa";
import { FaRegListAlt } from "react-icons/fa";

const UserTour = () => {
  const user = JSON.parse(localStorage.getItem("user"));
  const userId = user?.id;
  const { data: TourData } = useGetBillsWithUserIDQuery(userId | "");
  const { data: userData } = useGetUserByIdQuery(userId || "");
  const [updateBill] = useUpdateBillMutation();

  useEffect(() => {
    if (TourData) {
      console.log(TourData);
    }
  }, [TourData]);

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
const pageCount = Math.ceil(TourData?.data?.purchase_history.length / itemsPerPage);
const currentData: Bill[] = (TourData?.data?.purchase_history.slice(
  currentPage * itemsPerPage,
  (currentPage + 1) * itemsPerPage
) || []) as Bill[];
//end phân trang

  const formatNumber = (number: number) => {
    return Math.floor(number).toString(); // or parseInt(number.toString(), 10).toString()
  };

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

  //
  const cancelTour = async (id: number) => {
    const data = {
      purchase_status: 7,
      id: id,
    };

    await updateBill(data).then(() => {
      alert("Hủy tour thành công");
    });
  };

  const cancelTourRefund = async (id: number) => {
    const data = {
      purchase_status: 6,
      id: id,
    };

    await updateBill(data).then(() => {
      alert("Bạn đã yêu cầu hủy tour. Đang đợi admin xác nhận");
    });
  };

  const confirm = (e: React.MouseEvent<HTMLElement>) => {
    console.log(e);
  };

  const cancel = (e: React.MouseEvent<HTMLElement>) => {};

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
                <IoPersonOutline />Thông tin cá nhân
                </Link>
                <Link
                  className="nav-link text-white"
                  style={{ backgroundColor: "#1677FF" }}
                  to={"/user/tours"}
                >
                 <FaRegListAlt />  Tour đã đặt
                </Link>
                <Link className="nav-link" to={"/user/favorite"}>
                <FaRegHeart />  Tour yêu thích
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
              }: Bill) => {
                const handleGoToPayment = () => {
                  if (id) {
                    goToPayment(id);
                  }
                };
                const handleCancelTour = () => {
                  if (id) {
                    cancelTour(id);
                  }
                };
                const handleCancelTourRefund = () => {
                  if (id) {
                    cancelTourRefund(id);
                  }
                };
                let tourStatus;
                if (purchase_status === 0) {
                  tourStatus = "Chờ thanh toán";
                } else if (purchase_status === 1) {
                  tourStatus = "Đang đợi Admin xác nhận";
                } else if (purchase_status === 2) {
                  tourStatus = "Admin đã xác nhận, chờ tới ngày đi tour";
                } else if (purchase_status === 3) {
                  tourStatus = "Còn 1 ngày tới ngày đi tour";
                } else if (purchase_status === 4) {
                  tourStatus = "Tour đang diễn ra";
                } else if (purchase_status === 5) {
                  tourStatus = "Tour đã kết thúc";
                } else if (purchase_status === 6) {
                  tourStatus = "Yêu cầu hủy tour, chờ admin xác nhận";
                } else if (purchase_status === 7) {
                  tourStatus = "Bạn đã hủy";
                } else if (purchase_status === 8) {
                  tourStatus = "Admin đã hủy tour";
                } else if (purchase_status === 9) {
                  tourStatus = "Tự động đơn đặt hủy do quá hạn thanh toán";
                } else if (purchase_status === 10) {
                  tourStatus = "Đã hoàn tiền";
                } else if (purchase_status === 11) {
                  tourStatus = "Đã Đánh giá tour";
                } else if (purchase_status === 12) {
                  tourStatus = "Bạn chuyển khoản thiếu tiền";
                } else if (purchase_status === 13) {
                  tourStatus = "Bạn chuyển khoản thừa tiền";
                }

                let paymentStatus;
                if (payment_status == 0) {
                  paymentStatus = "Chưa thanh toán";
                } else if (payment_status == 1) {
                  paymentStatus = "Đã thanh toán";
                }
                console.log(coupon_fixed);

                const finalPrice = coupon_fixed
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
                  <div className="p-3 my-3 shadow row" key={id}>
                    <div className="col-8">
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
                      <p>
                        Phương thức thanh toán:{" "}
                        {purchase_method == 0 ? (
                          <span className="fw-bold">
                            Chuyển khoản ngân hàng
                          </span>
                        ) : (
                          <span className="fw-bold">VNPAY</span>
                        )}
                      </p>
                      {/* <p>
                      Trạng thái thanh toán:{" "}
                      <span className="fw-bold">{paymentStatus}</span>
                    </p> */}
                      <p>
                        Trạng thái đơn hàng:{" "}
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
                                {purchase_method == 0 ? (
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
                              {coupon_fixed ? (
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
                              <p>
                                Trạng thái đơn hàng:{" "}
                                <span className="fw-bold text-danger">
                                  {tourStatus}
                                </span>
                              </p>
                              {payment_status == 0 && purchase_method == 1 ? (
                                <button
                                  className="btn-continue mr-2"
                                  onClick={handleGoToPayment}
                                >
                                  Thanh toán
                                </button>
                              ) : (
                                <div></div>
                              )}
                              {purchase_status == 0 ? (
                                <Popconfirm
                                  title="Hủy tour chưa thanh toán"
                                  description="Bạn có chắc muốn hủy tour?"
                                  onConfirm={handleCancelTour}
                                  onCancel={cancel}
                                  okText="Đồng ý"
                                  cancelText="Hủy bỏ"
                                >
                                  <button className="btn-continue">Hủy</button>
                                </Popconfirm>
                              ) : (
                                <span>
                                  {purchase_status == 1 ||
                                  purchase_status == 2 ? (
                                    <Popconfirm
                                      title="Hủy tour đã thanh toán"
                                      description="Bạn có chắc muốn hủy tour?"
                                      onConfirm={handleCancelTourRefund}
                                      onCancel={cancel}
                                      okText="Đồng ý"
                                      cancelText="Hủy bỏ"
                                    >
                                      <button className="btn-continue">
                                        Hủy tour
                                      </button>
                                    </Popconfirm>
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
                      <img
                        src="https://via.placeholder.com/640x480.png/000044?text=dolorem"
                        alt=""
                      />
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
        </div>
      </section>
    </div>
  );
};

export default UserTour;
