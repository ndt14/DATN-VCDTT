import React, { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import { useResetPasswordMutation } from '../../../api/auth';

type Props = {
  show: boolean;
  onClose: () => void;
};

const ForgotPasswordModal = ({ show, onClose }: Props) => {
    const [email, setEmail] = useState('');
    const [resetPassword, { isLoading: resetPasswordLoading }] = useResetPasswordMutation();

    const handleResetPassword = async () => {
        try {
            const response = await resetPassword({ email });
            if (response.data) {
                // Handle successful password reset request
                console.log('Password reset request successful:', response.data);
                alert("Nhập email thành công.Vui lòng kiểu tra email của bạn")
            } else {
                // Handle password reset request error
                console.error('Password reset request failed:', response.error);
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
          Close
        </Button>
        <Button variant="primary" onClick={handleResetPassword} disabled={resetPasswordLoading}>
          Submit
        </Button>
      </Modal.Footer>
    </Modal>
  );
};

export default ForgotPasswordModal;
