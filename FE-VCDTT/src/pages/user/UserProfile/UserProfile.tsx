import React from "react";
import "./UserProfile.css";
import { Tabs } from "antd";
import { useState, useEffect } from "react";
import {
  useUpdateUserMutation,
  useGetUserByIdQuery,
  useUpdatePasswordMutation,
} from "../../../api/user";
import { Link } from "react-router-dom";
import { useFormik } from "formik";
import * as Yup from "yup";

import { DatePicker } from "antd";
import dayjs, { Dayjs } from "dayjs";
import moment from "moment";
import { Skeleton } from "antd";
import { IoPersonOutline } from "react-icons/io5";
import { FaRegHeart } from "react-icons/fa";
import { FaRegListAlt } from "react-icons/fa";
import "moment/locale/vi";
import { User } from "../../../interfaces/User";
import SecondaryBanner from "../../../componenets/User/SecondaryBanner";
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";
dayjs.locale("vi");
moment.locale("vi");

const MySwal = withReactContent(Swal);

const UserProfile = () => {
  const user = JSON.parse(localStorage.getItem("user") || "{}");
  const userId = user?.id;
  const userPassword = user?.password;
  console.log(userPassword);

  const { data: userData, isLoading } = useGetUserByIdQuery(userId || "");

  const {
    name: userName,
    email: userEmail,
    phone_number: phoneNumber,
    address: userAddress,
    gender: userGender,
    date_of_birth: userDateOfBirth,
  } = userData?.data?.user ?? {};
  const parts = userDateOfBirth ? userDateOfBirth.split("-") : [];
  const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
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
  });

  interface FormValues {
    id: number;
    name: string;
    email: string;
    phone_number: string;
    date_of_birth: string;
    gender: number;
    address: string;
  }

  const phoneRegExp = /^0\d{9}$/;
  const formik = useFormik<FormValues>({
    initialValues: {
      id: userId,
      name: userName || "",
      email: userEmail ? userEmail : "",
      phone_number: phoneNumber ? phoneNumber : "",
      gender: userGender ? userGender : "",
      address: userAddress ? userAddress : "",
      date_of_birth: userDateOfBirth ? userDateOfBirth : "",
    },
    validationSchema: Yup.object({
      name: Yup.string()
        .required("Nhập tên")
        .min(5, "Tên phải chứa ít nhất 5 ký tự")
        .max(20, "Tên không được vượt quá 20 ký tự"),
      email: Yup.string()
        .email("Sai định dạng email")
        .required("Email không được để trống"),
      phone_number: Yup.string()
        .required("Nhập số điện thoại")
        .matches(phoneRegExp, "Sai định dạng số điện thoại"),
      gender: Yup.string().required("Chọn giới tính"),
      date_of_birth: Yup.string().required("Nhập ngày sinh"),
    }),
    onSubmit: (values) => {
      console.log(values);
    },
    validateOnMount: true,
  });
  // console.log(formik.values);

  useEffect(() => {
    if (userData && userData.data.user.name) {
      formik.setValues((prevValues) => ({
        ...prevValues,
        name: userData.data.user.name,
        phone_number: userData.data.user.phone_number,
        address: userData.data.user.address,
        email: userData.data.user.email,
        gender: userData.data.user.gender,
        date_of_birth: userData.data.user.date_of_birth || "",
      }));
      setFormValues({
        ...formValues,
        date_of_birth: userData.data.user.date_of_birth || "",
      });
    }
  }, [userData]);
  const isSubmitDisabled = Object.keys(formik.errors).length > 0;

  const handleUpdate = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    console.log(formik.values);
    const variables = {
      id: userId,
      name: formik.values.name,
      phone_number: formik.values.phone_number,
      address: formik.values.address,
      email: formik.values.email,
      gender: formik.values.gender,
      date_of_birth: formValues.date_of_birth,
    };
    console.log(variables);
    editUser(variables)
      .then(() => {
        MySwal.fire({
          text: "Sửa thông tin thành công",
          icon: "success",
          // confirmButtonText: "OK",
          showCancelButton: false,
          showConfirmButton: false,
          timer: 2000,
        });
      })
      .catch((error) => {
        // Handle any errors here
        console.error(error);
      });
  };

  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  const handleDateChange = (date: Dayjs | null, _dateString: string) => {
    const newDateOfBirth = date ? date.format("YYYY-MM-DD") : "";
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
  console.log(passwordFormValues);

  const handlePasswordInputChange = (
    event: React.ChangeEvent<HTMLInputElement>
  ) => {
    const { name, value } = event.target;
    setPasswordFormValues((prevValues) => ({
      ...prevValues,
      [name]: value,
    }));
  };

  interface FetchBaseQueryError {
    // Define the properties of the FetchBaseQueryError object
  }

  interface SerializedError {
    // Define the properties of the SerializedError object
  }

  type UpdatePasswordResult =
    | { data: User }
    | { error: FetchBaseQueryError | SerializedError };
  const handlePasswordChange = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();

    // Kiểm tra xác nhận mật khẩu mới trùng khớp
    if (
      passwordFormValues.new_password !== passwordFormValues.confirmNewPassword
    ) {
      MySwal.fire({
        text: "Mật khẩu mới và xác nhận mật khẩu mới không trùng khớp.",
        icon: "warning",
        // confirmButtonText: "OK",
        showCancelButton: false,
        showConfirmButton: false,
        timer: 2000,
      });

      return;
    }

    const updatedPassword = {
      id: userId || "",
      old_password: passwordFormValues.old_password,
      new_password: passwordFormValues.new_password,
      data: undefined,
    };

    updatePassword(updatedPassword)
      .then((response: UpdatePasswordResult) => {
        if ("data" in response) {
          if (response.data.status == 200) {
            MySwal.fire({
              text: "Đổi mật khẩu thành công",
              icon: "success",
              // confirmButtonText: "OK",
              showCancelButton: false,
              showConfirmButton: false,
              timer: 2000,
            });
          } else if (response.data?.status == 404) {
            MySwal.fire({
              text: "Sai mật khẩu",
              icon: "warning",
              // confirmButtonText: "OK",
              showCancelButton: false,
              showConfirmButton: false,
              timer: 2000,
            });
          }
        }

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
  } else {
    gender = "Chưa xác định";
  }
  //
  const titleElement = document.querySelector("title");
  if (titleElement) {
    titleElement.innerText = "Thông tin người dùng";
  }
  const dataTitle = "Thông tin tài khoản";

  // const decryptPassword = (password: string) => {
  //   const key = "i47Mm0anr583zFb0SdXHCjX19rETnZ85kBkOQlRpH78";
  //   const decodedEncrypted = atob(password);
  //   const parsedEncrypted = JSON.parse(decodedEncrypted);
  //   // console.log("Laravel encryption result", parsedEncrypted);
  //   // IV is base64 encoded in Laravel, expected as WordArray in cryptojs
  //   const iv = CryptoJS.enc.Base64.parse(parsedEncrypted.iv);
  //   // Value (cipher text) is also base64 encoded in Laravel, same in cryptojs
  //   const value = parsedEncrypted.value;
  //   // Key is base64 encoded in Laravel, WordArray expected in cryptojs
  //   const parsedKey = CryptoJS.enc.Base64.parse(key);
  //   const decrypted = CryptoJS.AES.decrypt(value, parsedKey, {
  //     iv: iv,
  //   });
  //   const decryptedText = decrypted.toString(CryptoJS.enc.Utf8);
  //   console.log(decryptedText);
  //   return decryptedText;
  // };
  // const decryptedPassword = decryptPassword(userPassword || "");
  // console.log(decryptedPassword);

  return (
    <div>
      <SecondaryBanner>{dataTitle}</SecondaryBanner>

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
                    <IoPersonOutline /> Thông tin cá nhân
                  </Link>
                  <Link
                    className="nav-link active text-black"
                    to={"/user/tours"}
                  >
                    <FaRegListAlt /> Tour đã đặt
                  </Link>
                  <Link className="nav-link text-black" to={"/user/favorite"}>
                    <FaRegHeart /> Tour yêu thích
                  </Link>
                  <Link className="nav-link text-black" to={"/user/coupon"}>
                    <FaRegListAlt /> Mã Giảm giá
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
                    Địa chỉ:{" "}
                    {userAddress ? (
                      <span className="fw-bold">{userAddress}</span>
                    ) : (
                      <span className="fw-bold">Chưa có</span>
                    )}
                  </p>
                  <p>
                    Số điện thoại:{" "}
                    {phoneNumber ? (
                      <span className="fw-bold">{phoneNumber}</span>
                    ) : (
                      <span className="fw-bold">Chưa có</span>
                    )}
                  </p>
                  <p>
                    Ngày tháng năm sinh:{" "}
                    {userDateOfBirth ? (
                      <span className="fw-bold">{formattedDate}</span>
                    ) : (
                      <span className="fw-bold">Chưa có</span>
                    )}
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
                            value={formik.values.name}
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                          />
                          {formik.touched.name && formik.errors.name && (
                            <p className="text-danger mt-2">
                              {formik.errors.name}
                            </p>
                          )}
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
                            value={formik.values.email}
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                          />
                          {formik.touched.email && formik.errors.email && (
                            <p className="mt-2 text-danger">
                              {formik.errors.email}
                            </p>
                          )}
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
                            value={formik.values.phone_number}
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                          />
                          {formik.touched.phone_number &&
                            formik.errors.phone_number && (
                              <p className="mt-2 text-danger">
                                {formik.errors.phone_number}
                              </p>
                            )}
                        </div>
                      </div>

                      <div className="col-sm-3">
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
                            value={formik.values.gender}
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                          >
                            <option value="">--Chọn giới tính--</option>
                            <option value="1">Nam</option>
                            <option value="2">Nữ</option>
                            <option value="3">Khác</option>
                          </select>
                          {formik.touched.gender && formik.errors.gender && (
                            <p className="text-danger mt-2">
                              {formik.errors.gender}
                            </p>
                          )}
                        </div>
                      </div>
                      <div className="col-sm-3">
                        <div className="form-group">
                          <label className="d-inline-flex block">
                            Ngày sinh
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
                            // onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                          />
                          {/* {formik.touched.date_of_birth &&
                            formik.errors.date_of_birth && (
                              <p className="text-danger">
                                {formik.errors.phone_number}
                              </p>
                            )} */}
                        </div>
                      </div>

                      <div className="col-sm-12">
                        <div className="form-group">
                          <label className="d-inline-flex">Địa chỉ</label>
                          <input
                            type="text"
                            name="address"
                            className="input-border"
                            value={formik.values.address}
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                          />
                        </div>
                      </div>
                    </div>
                    {isSubmitDisabled ? (
                      <button type="submit" disabled className="btn-continue">
                        Chỉnh sửa
                      </button>
                    ) : (
                      <button type="submit" className="btn-continue">
                        Chỉnh sửa
                      </button>
                    )}
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
                        className="input-border"
                        // value={passwordFormValues?.oldPassword}
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
                        className="input-border"
                        // value={passwordFormValues?.newPassword}
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
                        className="input-border"
                        onChange={handlePasswordInputChange}
                      />
                    </div>
                    <button
                      type="submit"
                      disabled={
                        passwordFormValues.confirmNewPassword == "" &&
                        passwordFormValues.new_password == "" &&
                        passwordFormValues.old_password == ""
                      }
                      className="btn-continue"
                    >
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
