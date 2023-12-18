import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import { useNavigate, useParams } from 'react-router-dom';
import { useResetPasswordWithTokenMutation } from '../../../api/auth';
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";


const MySwal = withReactContent(Swal);

const ResetPasswordModal = () => {
  const [resetPasswordWithToken] = useResetPasswordWithTokenMutation();
  const { token } = useParams();
  const [show, setShow] = useState(true);
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const navigate = useNavigate();

  const handleResetPasswordWithToken = async () => {
    try {
      if (!password || password.length < 8 || password !== confirmPassword) {
        // Kiểm tra mật khẩu có rỗng, ít hơn 8 kí tự hoặc không trùng khớp không
        MySwal.fire({
          text: password !== confirmPassword ? "Mật khẩu xác nhận không khớp" : "Mật khẩu phải có ít nhất 8 kí tự",
          icon: "error",
        });
        return;
      }

      const newPassword = password;
      const response = await resetPasswordWithToken({ token, newPassword });
      if (response) {
        MySwal.fire({
          text: "Đổi mật khẩu thành công",
          icon: "success",
        });
        setShow(false);
        navigate('/');
      } else {
        console.error('Yêu cầu đổi mật khẩu thất bại:');
      }
    } catch (error) {
      console.error('Yêu cầu đổi mật khẩu thất bại:', error);
    }
  };

  return (
    <Modal show={show}>
      <Modal.Header >
        <Modal.Title>Đổi mật khẩu mới</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <div className="form-group">
          <label htmlFor="password">Nhập mật khẩu mới</label>
          <input
            type="password"
            id="password"
            name="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            className="form-control"
            placeholder="Nhập mật khẩu mới"
          />
        </div>
        <div className="form-group mt-2">
          <label htmlFor="confirmPassword">Xác nhận mật khẩu mới</label>
          <input
            type="password"
            id="confirmPassword"
            name="confirmPassword"
            value={confirmPassword}
            onChange={(e) => setConfirmPassword(e.target.value)}
            className="form-control"
            placeholder="Xác nhận mật khẩu mới"
          />
        </div>
      </Modal.Body>
      <Modal.Footer>
        {/* <Button variant="secondary" onClick={() => setShow(false)}>
          Đóng
        </Button> */}
        <Button variant="primary" onClick={handleResetPasswordWithToken}>
          Đổi mật khẩu
        </Button>
      </Modal.Footer>
    </Modal>
  );
};

export default ResetPasswordModal;



