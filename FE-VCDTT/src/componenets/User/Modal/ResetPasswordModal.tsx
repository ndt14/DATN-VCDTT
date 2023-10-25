import React, { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import { useParams } from 'react-router-dom';

const ResetPasswordModal = ({ match }:any) => {
  const { token } = useParams();
  const [show, setShow] = useState(true); // Show the modal initially
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');

  const handleResetPassword = () => {
    // Send a request to your backend API to reset the password
    // Use the 'token', 'password', and 'confirmPassword' states
  };

  const handleClose = () => {
    // Handle closing the modal
    setShow(false);
    // Optionally, you can redirect the user to another page or close the modal in your app's state management.
  };

  return (
    <Modal show={show} onHide={handleClose}>
      <Modal.Header closeButton>
        <Modal.Title>Đổi mật khẩu</Modal.Title>
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
            placeholder="Enter your new password"
          />
        </div>
        <div className="form-group">
          <label htmlFor="confirmPassword">Confirm Password</label>
          <input
            type="password"
            id="confirmPassword"
            name="confirmPassword"
            value={confirmPassword}
            onChange={(e) => setConfirmPassword(e.target.value)}
            className="form-control"
            placeholder="Confirm your new password"
          />
        </div>
      </Modal.Body>
      <Modal.Footer>
        <Button variant="secondary" onClick={handleClose}>
          Close
        </Button>
        <Button variant="primary" onClick={handleResetPassword}>
          Reset Password
        </Button>
      </Modal.Footer>
    </Modal>
  );
};

export default ResetPasswordModal;
