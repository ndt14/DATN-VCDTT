import React from "react";
import "./UserProfile.css";
import { Tabs } from "antd";
import { useState, useEffect } from "react";
import {
  useUpdateUserMutation,
  useGetUserByIdQuery,
  useUpdatePasswordMutation,
} from "../../../api/user";
import { User } from "../../../interfaces/User";
import { Link } from "react-router-dom";

import { DatePicker, Rate } from "antd";
import dayjs, { Dayjs } from "dayjs";
import moment, { Moment } from "moment";
import { message } from "antd";
import { Skeleton } from "antd";

import "moment/locale/vi";
dayjs.locale("vi");
moment.locale("vi");

const UserProfile = () => {
  const user = JSON.parse(localStorage.getItem("user"));
  const userId = user?.id;
  const { data: userData, isLoading } = useGetUserByIdQuery(userId || "");
  //
  const [loading, setLoading] = useState(true);
  const [data, setData] = useState(null);

  // const userName = userData?.data?.user.name;
  // const userDateOfBirth = userData?.data?.user.date_of_birth;
  // const userEmail = userData?.data?.user.email;
  // const phoneNumber = userData?.data?.user.phone_number;
  // const userAddress = userData?.data?.user.address;
  // const userGender = userData?.data?.user.gender;
  const {
    name: userName,
    email: userEmail,
    phone_number: phoneNumber,
    address: userAddress,
    gender: userGender,
    date_of_birth: userDateOfBirth,
  } = userData?.data?.user ?? {};
  // const parts = userDateOfBirth.split("-");
  // const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
  const { TabPane } = Tabs;
  const [editUser] = useUpdateUserMutation();
  const [updatePassword] = useUpdatePasswordMutation();

  const [formValues, setFormValues] = useState({
    id: userId,
    name: "",
    email: "",
    address: "",
    phone_number: "",
    date_of_birth: "",
    gender: "",
  });

  useEffect(() => {
    if (userData) {
      const { name, email, phone_number, address, date_of_birth, gender } =
        userData.data.user;
      setFormValues({
        ...formValues,
        name: name || "",
        email: email || "",
        address: address || "",
        phone_number: phone_number || "",
        date_of_birth: date_of_birth || "",
        gender: gender || "",
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
        message.success("Cập nhật thông tin thành công");
      })
      .catch((error) => {
        // Handle any errors here
        console.error(error);
      });
  };
  const handleDateChange = (date: moment.Moment | null) => {
    const newDateOfBirth = date ? date.format("YYYY-MM-DD") : null;
    setFormValues((prevValues) => ({
      ...prevValues,
      date_of_birth: newDateOfBirth,
    }));
  };

  const [passwordFormValues, setPasswordFormValues] = useState({
    old_password: "",
    new_password: "",
    confirmNewPassword: "",
  });
  const handlePasswordInputChange = (
    event: React.ChangeEvent<HTMLInputElement>
  ) => {
    const { name, value } = event.target;
    setPasswordFormValues((prevValues) => ({
      ...prevValues,
      [name]: value,
    }));
  };
  const handlePasswordChange = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();

    // Kiểm tra xác nhận mật khẩu mới trùng khớp
    if (
      passwordFormValues.new_password !== passwordFormValues.confirmNewPassword
    ) {
      message.warning(
        "Mật khẩu mới và xác nhận mật khẩu mới không trùng khớp."
      );
      return;
    }

    const updatedPassword = {
      id: userId || "",
      old_password: passwordFormValues.old_password,
      new_password: passwordFormValues.new_password,
    };

    updatePassword(updatedPassword)
      .then((response) => {
        if (response.data.status == 200) {
          message.success("Đổi mật khẩu thành công");
        } else if (response.data.status == 404) {
          message.warning("Sai mật khẩu");
        }

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
  let gender;
  if (userGender == 1) {
    gender = "Nam";
  } else if (userGender == 2) {
    gender = "Nữ";
  } else if (userGender == 3) {
    gender = "Khác";
  }
  //
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
              {isLoading ? (
                <Skeleton active />
              ) : (
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
              )}
              {/* <div className="d-flex p-3">
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
              </div> */}
              <hr />
              {/* Left panel */}
              {isLoading ? (
                <Skeleton active />
              ) : (
                <nav className="nav flex-column">
                  <Link
                    className="nav-link text-white"
                    style={{ backgroundColor: "#1677FF" }}
                    to={"/user/profile"}
                  >
                    Thông tin cá nhân
                  </Link>
                  <Link className="nav-link active" to={"/user/tours"}>
                    Tour đã đặt
                  </Link>
                  <Link className="nav-link" to={"/user/favorite"}>
                    Tour yêu thích
                  </Link>
                </nav>
              )}

              {/* End left panel */}
            </div>
          </div>

          <div className="col-8">
            {/*  */}
            {isLoading ? (
              <Skeleton active />
            ) : (
              <Tabs
                defaultActiveKey="1"
                style={{ display: "flex", justifyContent: "space-between" }}
              >
                <TabPane
                  tab="Thông tin của tôi"
                  key="1"
                  style={{ width: "50%" }}
                >
                  <p>
                    Họ và tên: <span className="fw-bold">{userName}</span>
                  </p>
                  <p>
                    Email: <span className="fw-bold">{userEmail}</span>
                  </p>
                  <p>
                    Địa chỉ: <span className="fw-bold">{userAddress}</span>
                  </p>
                  <p>
                    Số điện thoại:{" "}
                    <span className="fw-bold">{phoneNumber}</span>
                  </p>
                  <p>
                    Ngày tháng năm sinh:{" "}
                    {/* <span className="fw-bold">{formattedDate}</span> */}
                  </p>
                  <p>
                    Giới tính: <span className="fw-bold">{gender}</span>
                  </p>
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
                            className="input-border"
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
                            className="input-border"
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
                            className="input-border"
                            value={formValues.phone_number}
                            onChange={handleInputChange}
                          />
                        </div>
                      </div>
                      <div className="col-sm-6">
                        <div className="form-group">
                          <label className="d-inline-flex block">
                            Ngày sinh <div className=" ml-1 text-danger">*</div>
                          </label>{" "}
                          <br />
                          <DatePicker
                            className="input-border"
                            name="date_of_birth"
                            value={
                              formValues.date_of_birth
                                ? dayjs(formValues.date_of_birth)
                                : null
                            }
                            onChange={handleDateChange}
                          />
                        </div>
                      </div>
                      <div className="col-sm-6">
                        <div className="form-group">
                          <label className="d-inline-flex">
                            Giới tính <div className=" ml-1 text-danger">*</div>
                          </label>
                          {/* <input
                        type="text"
                        name="phone_number"
                        className=""
                        value={formValues.phone_number}
                        onChange={handleInputChange}
                      /> */}
                          <select
                            name="gender"
                            id=""
                            className="input-border"
                            value={formValues.gender}
                            onChange={handleInputChange}
                          >
                            <option value="1">Nam</option>
                            <option value="2">Nữ</option>
                            <option value="3">Khác</option>
                          </select>
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
                            className="input-border"
                            value={formValues.address}
                            onChange={handleInputChange}
                          />
                        </div>
                      </div>
                    </div>

                    <button type="submit" className="btn-continue">
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
                        Xác nhận mật khẩu mới{" "}
                        <div className=" ml-1 text-danger">*</div>
                      </label>
                      <input
                        type="password"
                        name="confirmNewPassword"
                        value={passwordFormValues.confirmNewPassword}
                        onChange={handlePasswordInputChange}
                      />
                    </div>
                    <button type="submit" className="btn-continue">
                      Đổi mật khẩu
                    </button>
                  </form>
                </TabPane>
              </Tabs>
            )}
          </div>
        </div>
      </section>
    </div>
  );
};

export default UserProfile;
