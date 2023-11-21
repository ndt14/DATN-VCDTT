import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import { useNavigate, useParams } from 'react-router-dom';
import { useResetPasswordWithTokenMutation } from '../../../api/auth';

const ResetPasswordModal = () => {
  const [resetPasswordWithToken] = useResetPasswordWithTokenMutation();
  const { token } = useParams();
  const [show, setShow] = useState(true); // Show the modal initially
  const [password, setPassword] = useState('');
const navigate = useNavigate()
  const handleResetPasswordWithToken = async () => {
    try {
      const newPassword = password; // Get the new password from the state
      const response = await resetPasswordWithToken({ token, newPassword });
      if (response.data) {
        // Handle successful password reset
        console.log('Password reset successful:', response.data);
        // You can redirect the user to a success page or perform other actions
        // For example, you can close the modal and show a success message.
        alert("đổi mật khẩu thành công")
        setShow(false); // Close the modal
        navigate('/')
      } else {
        // Handle password reset request error
        console.error('Password reset request failed:');
        // You can display an error message to the user.
      }
    } catch (error) {
      // Handle network or other errors
      console.error('Password reset request failed:', error);
    }
  };

  return (
    <Modal show={show}>
      <Modal.Header closeButton>
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
      </Modal.Body>
      <Modal.Footer>
        <Button variant="secondary" onClick={() => setShow(false)}>
          Đóng
        </Button>
        <Button variant="primary" onClick={handleResetPasswordWithToken}>
          Đổi mật khẩu
        </Button>
      </Modal.Footer>
    </Modal>
  );
};

export default ResetPasswordModal;
