import React from 'react';
import Modal from 'react-bootstrap/Modal';

function CashPaymentModal(props) {
  const { formattedFinalPrice, /* các biến khác */ } = props.modalData;
  return (
    <Modal show={props.show} onHide={props.onHide}>
      <Modal.Header closeButton>
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
              Số tài khoản   : 0915220156
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
          <button className="btn btn-danger" >
            Thoát
          </button>
          <button className="btn btn-success" >
            Chuyển khoản thành công
          </button>
        </div>
      </Modal.Footer>
    </Modal>
  );
}

export default CashPaymentModal;
