import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import { useResetPasswordMutation } from '../../../api/auth';
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";
import { useGetUsersQuery } from '../../../api/user';
import { User } from '../../../interfaces/User';


const MySwal = withReactContent(Swal);

type Props = {
  show: boolean;
  onClose: () => void;
};

const ForgotPasswordModal = ({ show, onClose }: Props) => {
    const [email, setEmail] = useState('');
    const [resetPassword, { isLoading: resetPasswordLoading }] = useResetPasswordMutation();
    //kiểm tra email có tồn tại 
    const {data:dataUser} = useGetUsersQuery();

    
    const handleResetPassword = async () => {
      try {
          if (!email) {
              MySwal.fire({
                  text: "Vui lòng nhập địa chỉ email của bạn",
                  icon: "error",
              });
              return;
          }

          // Kiểm tra xem email có tồn tại trong danh sách không
          const isEmailExists = dataUser?.data.users.some((user: User) => user.email === email);

          if (!isEmailExists) {
              MySwal.fire({
                  text: "Email không tồn tại trong hệ thống",
                  icon: "error",
              });
              return;
          }

          const response = await resetPassword({ email });
          if (response) {
              MySwal.fire({
                  text: "Nhập email thành công. Vui lòng kiểm tra email của bạn",
                  icon: "success",
              });
              // Handle successful password reset request
          } else {
              // Handle password reset request error
              console.error('Password reset request failed:');
          }
      } catch (error) {
          // Handle network or other errors
          console.error('Password reset request failed:', error);
      }
  };
  

  return (
    <Modal show={show} onHide={onClose}>
      <Modal.Header closeButton>
        <Modal.Title>Lấy lại mật khẩu</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <div className="form-group">
          <label htmlFor="email">Email đã đăng ký tài khoản</label>
          <input
            type="email"
            id="email"
            name="email"
            value={email}
            className="form-control"
            onChange={(e) => setEmail(e.target.value)}
            placeholder="Vui lòng nhập email"
            
          />
        </div>
      </Modal.Body>
      <Modal.Footer>
        <Button variant="secondary" onClick={onClose}>
          Đóng
        </Button>
        <Button variant="primary" onClick={handleResetPassword} disabled={resetPasswordLoading}>
          Gửi
        </Button>
      </Modal.Footer>
    </Modal>
  );
};

export default ForgotPasswordModal;
