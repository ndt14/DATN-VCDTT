import React from "react";
import Modal from "react-bootstrap/Modal";
import { useUpdateBillMutation } from "../../../api/bill";
import { Navigate, useNavigate } from "react-router";

function CashPaymentModal(props) {
  const { formattedFinalPrice, id /* các biến khác */ } = props.modalData;
  const billId = JSON.parse(localStorage.getItem("billIdSuccess"));
  const isLoggedIn = JSON.parse(localStorage.getItem("isLoggedIn"));
  console.log(isLoggedIn);

  console.log(billId);
  const [updatePaymentStatus] = useUpdateBillMutation();
  const navigate = useNavigate();
  const updateBill = () => {
    const data = {
      id: billId,
      payment_status: 1,
    };
    updatePaymentStatus(data).then(() => {
      if (isLoggedIn && isLoggedIn == true) {
        alert(
          "Bạn xác nhận đã thanh toán. Hãy đợi chúng tôi xác nhận thanh toán đơn hàng của bạn"
        );
        navigate("/user/tours");
        window.location.reload();
      } else {
        alert(
          "Bạn xác nhận đã thanh toán. Hãy đợi chúng tôi xác nhận thanh toán đơn hàng của bạn. Hãy đăng ký/đăng nhập để trải nghiệm các dịch vụ ưu đãi cho người dùng"
        );
        navigate("/");
        window.location.reload();
      }
    });
  };

  return (
    <Modal
      show={props.show}
      onHide={props.onHide}
      backdrop="static"
      keyboard={false}
    >
      <Modal.Header>
        <Modal.Title>
          <div className="text-center">
            Vui lòng quét qr hoặc chuyển khoản cho thông tin dưới đây
          </div>
        </Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <div className="container">
          <div className="text-center">
            <span className="fs-4 text-black fw-bold">
              Ngân hàng MB BANK <br />
            </span>
            {/* Hiển thị ảnh QR code */}
            <img src="/path-to-your-qr-code-image.png" alt="QR Code" />
          </div>

          <div className="text-center mt-3">
            <span className="fs-4 text-black fw-bold">
              Người thụ hưởng: Nguyễn Đức Thịnh <br />
              Số tài khoản : 0915220156
            </span>
          </div>
          <div className="text-center mt-3">
            <span className="fs-4 text-danger fw-bold">
              Số tiền bạn phải chuyển là: {formattedFinalPrice}
            </span>
          </div>
        </div>
      </Modal.Body>
      <Modal.Footer>
        <div className="text-center">
          {/* Thêm nút "Chuyển khoản thành công" */}
          <button className="btn btn-danger" onClick={props.onHide}>
            Thoát
          </button>
          <button onClick={updateBill} className="btn btn-success">
            Chuyển khoản thành công
          </button>
        </div>
      </Modal.Footer>
    </Modal>
  );
}

export default CashPaymentModal;
