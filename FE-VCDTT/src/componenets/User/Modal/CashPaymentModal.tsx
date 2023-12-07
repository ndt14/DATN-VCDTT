import Modal from "react-bootstrap/Modal";
import { useUpdateBillMutation } from "../../../api/bill";
import {  useNavigate } from "react-router";
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";
import { useState } from "react";
import { Spin } from "antd";
import { useGetBankAccountNameQuery, useGetBankContentQuery, useGetBankImageQuery, useGetBankNameQuery, useGetBankNumberQuery } from "../../../api/setting";
import { Setting } from "../../../interfaces/Setting";

// import { MouseEventHandler } from "react";
const MySwal = withReactContent(Swal);
function CashPaymentModal(props: { modalData: { formattedFinalPrice: any; }; show: boolean | undefined; onHide: (() => void) | undefined; }) {
  const { formattedFinalPrice /* các biến khác */ } = props.modalData;
  const billId = JSON.parse(localStorage.getItem("billIdSuccess")||"");
  const isLoggedIn = JSON.parse(localStorage.getItem("isLoggedIn")||"");
  const [loading, setLoading] = useState(false);

  console.log(isLoggedIn);

  console.log(billId);
  const [updatePaymentStatus] = useUpdateBillMutation();
  const navigate = useNavigate();
  const updateBill = async () => {
    setLoading(true);
  
    const data: any = {
      id: billId,
      payment_status: 2,
      comfirm_click: 2,
    };
  
    try {
      await updatePaymentStatus(data);
  
      let message = "Bạn xác nhận đã thanh toán. Hãy đợi chúng tôi xác nhận thanh toán đơn hàng của bạn";
  
      if (isLoggedIn && isLoggedIn === true) {
       
      

        message = "Bạn xác nhận đã thanh toán. Hãy đợi chúng tôi xác nhận thanh toán đơn hàng của bạn";
      } else {
        
        message = "Bạn xác nhận đã thanh toán. Hãy đợi chúng tôi xác nhận thanh toán đơn hàng của bạn. Kiểm tra email của bạn để cập nhật đơn hàn";
      }
  
      MySwal.fire({
        text: message,
        icon: "success",
        showCancelButton: false,
        showConfirmButton: false,
       timer:6000
      });
  
      // Wait for 4000 milliseconds (4 seconds) before reloading
      await new Promise((resolve) => setTimeout(resolve, 6000));
  
      if (isLoggedIn && isLoggedIn === true) {
        navigate("/user/tours");
      

       
      } else {
        navigate("/");
        
      }
      // Reload the window
      window.location.reload();
    } catch (error) {
      console.error(error);
      // Handle errors if needed
    }
  };
  
//api 
const {data: bankName} = useGetBankNameQuery();
const {data: bankImage} = useGetBankImageQuery();
const {data: bankNumber} = useGetBankNumberQuery();
const {data: bankNameUse} = useGetBankAccountNameQuery();
const {data: bankContent} = useGetBankContentQuery();

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
            Vui lòng quét QR hoặc chuyển khoản cho thông tin dưới đây
          </div>
        </Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <div className="container">
          <div className="text-center">
            <span className="fs-4 text-black fw-bold">
              Ngân hàng: 
              {bankName?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                             <span key={id}>  {value}</span>
                                         )
                                         })} 
               <br />
            </span>
            {/* Hiển thị ảnh QR code */}

            {bankImage?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                            
                                             <img key={id}
                                             src={value}
                                             alt="QR Code"
                                           />
                                         )
                                         })} 
          
          </div>

          <div className="text-center mt-3">
            <span className="fs-4 text-black fw-bold">
              Người thụ hưởng: {bankNameUse?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                             <span key={id}>  {value}</span>
                                         )
                                         })}  <br />
              Số tài khoản :{bankNumber?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                             <span key={id}>  {value}</span>
                                         )
                                         })}  <br />
             Nội dung chuyển khoản :{bankContent?.data.keyvalue.map(({id,value}:Setting)=>{
                                            return(
                                             <span key={id}>  {value}</span>
                                         )
                                         })}                             
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
          <button className="btn btn-danger mr-2" onClick={props.onHide}>
            Thoát
          </button>
          <button onClick={updateBill} className="btn btn-success">
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
  );
}

export default CashPaymentModal;
