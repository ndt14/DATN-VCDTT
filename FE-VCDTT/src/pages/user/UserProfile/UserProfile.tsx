import React from "react";
import "./UserProfile.css";
import { Tabs } from "antd";
import { useState, useEffect } from "react";
import { useUpdateUserMutation, useGetUserByIdQuery, useUpdatePasswordMutation } from "../../../api/user";
import { User } from "../../../interfaces/User";
import { Link } from "react-router-dom";
import { log } from "console";

const UserProfile = () => {
  const user = JSON.parse(localStorage.getItem("user"));
  const userId = user?.id;
  const { data: userData } = useGetUserByIdQuery(userId || "");

  const userName = userData?.data?.user.name;

  const userEmail = userData?.data?.user.email;
  const phoneNumber = userData?.data?.user.phone_number;
  const userAddress = userData?.data?.user.address;

  const { TabPane } = Tabs;
  const [editUser] = useUpdateUserMutation();
  const [updatePassword] = useUpdatePasswordMutation();

  const [formValues, setFormValues] = useState({
    id: userId ? userId : "",
    name: userName,
    email: userEmail,
    address: userAddress,
    phone_number: phoneNumber,
  });
  useEffect(() => {
    if (userData) {
      const { name, email, phone_number, address } = userData.data.user;
      setFormValues({
        ...formValues,
        name: name || "",
        email: email || "",
        address: address || "",
        phone_number: phone_number || "",
      });
    }
  }, [userData]);
  const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setFormValues((prevValues) => ({
      ...prevValues,
      [name]: value,
    }));
  };
  const handleUpdate = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    console.log(formValues);
    editUser(formValues)
      .then((response) => {
        alert(response?.data?.message);
      })
      .catch((error) => {
        // Handle any errors here
        console.error(error);
      });
  };

  const [passwordFormValues, setPasswordFormValues] = useState({
    old_password: "",
    new_password: "",
    confirmNewPassword: "",
});
const handlePasswordInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
  const { name, value } = event.target;
  setPasswordFormValues((prevValues) => ({
      ...prevValues,
      [name]: value,
  }));
};
const handlePasswordChange = (e: React.FormEvent<HTMLFormElement>) => {
  e.preventDefault();
  
  // Kiểm tra xác nhận mật khẩu mới trùng khớp
  if (passwordFormValues.new_password !== passwordFormValues.confirmNewPassword) {
      alert("Mật khẩu mới và xác nhận mật khẩu mới không trùng khớp.");
      return;
  }
  
  const updatedPassword = {
      id: userId || "",
      old_password: passwordFormValues.old_password,
      new_password: passwordFormValues.new_password,
  };

  updatePassword(updatedPassword)
      .then((response) => {
          alert(response?.data?.message);
          console.log(response);
          
          // Xóa các trường mật khẩu sau khi thay đổi thành công
          setPasswordFormValues({
              old_password: "",
              new_password: "",
              confirmNewPassword: "",
          });
      })
      .catch((error) => {
          console.error(error);
      });
};

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
              <h1 className="inner-title">Tìm kiếm tour</h1>
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
                  Thông tin cá nhân
                </Link>
                <Link className="nav-link active" to={"/user/tours"}>
                  Tour đã đặt
                </Link>
                <Link className="nav-link" to={"/user/favorite"}>
                  Tour yêu thích
                </Link>
              </nav>

              {/* End left panel */}
            </div>
          </div>
          <div className="col-8">
            {/*  */}
            <Tabs
              defaultActiveKey="1"
              style={{ display: "flex", justifyContent: "space-between" }}
            >
              <TabPane tab="Thông tin của tôi" key="1" style={{ width: "50%" }}>
                <p>Họ và tên: {userName}</p>
                <p>Email: {userEmail}</p>
              </TabPane>
              <TabPane tab="Chỉnh sửa thông tin" key="2">
                <form onSubmit={handleUpdate}>
                  <div className="row">
                    <div className="col-sm-6">
                      <div className="form-group">
                        <label className="d-inline-flex">
                          Họ tên <div className=" ml-1 text-danger">*</div>
                        </label>
                        <input
                          type="text"
                          name="name"
                          className=""
                          value={formValues.name}
                          onChange={handleInputChange}
                        />
                      </div>
                    </div>
                    <div className="col-sm-6">
                      <div className="form-group">
                        <label className="d-inline-flex">
                          Email <div className=" ml-1 text-danger">*</div>
                        </label>
                        <input
                          type="text"
                          name="email"
                          className=""
                          value={formValues.email}
                          onChange={handleInputChange}
                        />
                      </div>
                    </div>
                    <div className="col-sm-6">
                      <div className="form-group">
                        <label className="d-inline-flex">
                          Số điện thoại{" "}
                          <div className=" ml-1 text-danger">*</div>
                        </label>
                        <input
                          type="text"
                          name="phone_number"
                          className=""
                          value={formValues.phone_number}
                          onChange={handleInputChange}
                        />
                      </div>
                    </div>
                    <div className="col-sm-12">
                      <div className="form-group">
                        <label className="d-inline-flex">
                          Địa chỉ <div className=" ml-1 text-danger">*</div>
                        </label>
                        <input
                          type="text"
                          name="address"
                          className=""
                          value={formValues.address}
                          onChange={handleInputChange}
                        />
                      </div>
                    </div>
                  </div>

                  <button type="submit" className="">
                    Chỉnh sửa
                  </button>
                </form>
              </TabPane>
              <TabPane tab="Thay đổi mật khẩu" key="3">
              <form onSubmit={handlePasswordChange}>
        <div className="form-group">
            <label className="d-inline-flex">
                Mật khẩu cũ <div className=" ml-1 text-danger">*</div>
            </label>
            <input
                type="password"
                name="old_password"
                value={passwordFormValues.oldPassword}
                onChange={handlePasswordInputChange}
            />
        </div>
        <div className="form-group">
            <label className="d-inline-flex">
                Mật khẩu mới <div className=" ml-1 text-danger">*</div>
            </label>
            <input
                type="password"
                name="new_password"
                value={passwordFormValues.newPassword}
                onChange={handlePasswordInputChange}
            />
        </div>
        <div className="form-group">
            <label className="d-inline-flex">
                Xác nhận mật khẩu mới <div className=" ml-1 text-danger">*</div>
            </label>
            <input
                type="password"
                name="confirmNewPassword"
                value={passwordFormValues.confirmNewPassword}
                onChange={handlePasswordInputChange}
            />
        </div>
        <button type="submit" className="btn-continue">Đổi mật khẩu</button>
    </form>
              </TabPane>
            </Tabs>
          </div>
        </div>
      </section>
    </div>
  );
};

export default UserProfile;
