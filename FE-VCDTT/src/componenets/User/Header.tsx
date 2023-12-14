import { Link, useLocation } from "react-router-dom";
// import "../../../assets/js/modal.js";

// import { Modal, Form, Input, Checkbox, Button } from "antd";
import { useState, useEffect } from "react";
// import Button from "react-bootstrap/Button";
import Modal from "react-bootstrap/Modal";
import { BsGoogle } from "react-icons/bs";
import {
  useGetLoginGoogleQuery,
  useLoginMutation,
  useRegisterMutation,
} from "../../api/auth.js";
import { useFormik } from "formik";
import "../User/css/Header.css";
import { loginSchema, registrationSchema } from "../../schemas/auth.js";
import { useGetCategoriesQuery } from "../../api/category.js";
import { Category } from "../../interfaces/Category.js";
import ForgotPasswordModal from "./Modal/ForgotPasswordModal.js";
import { useNavigate } from "react-router-dom";
//
import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
// import NavDropdown from "react-bootstrap/NavDropdown";
import { useGetLogoQuery } from "../../api/setting.js";
import { Setting } from "../../interfaces/Setting.js";
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";
import Dropdown from "react-bootstrap/Dropdown";
// import DropdownButton from "react-bootstrap/DropdownButton";

const MySwal = withReactContent(Swal);

const Header = () => {
  const [login] = useLoginMutation();
  const [register] = useRegisterMutation();
  const { data: dataCate } = useGetCategoriesQuery();
  const { data: dataLogo } = useGetLogoQuery();

  // console.log(dataCate?.data.categoriesParent)

  const [registerPassword] = useState("");
  const [confirmPassword] = useState("");

  // Thêm các trường thông tin cần thiết khác nếu cần

  // console.log(email);

  const [showSignIn, setShowSignIn] = useState(false);
  // const [showSignUp, setShowSignUp] = useState(false);

  const handleCloseSignIn = () => setShowSignIn(false);
  // const handleCloseSignUp = () => setShowSignUp(false);
  const handleShowSignIn = () => setShowSignIn(true);
  // const handleShowSignUp = () => setShowSignUp(true);
  const [showForgotPasswordModal, setShowForgotPasswordModal] = useState(false);

  const [isLoggedIn, setIsLoggedIn] = useState(() => {
    const storedStatus = localStorage.getItem("isLoggedIn");
    return storedStatus ? JSON.parse(storedStatus) : false;
  });
  useEffect(() => {
    localStorage.setItem("isLoggedIn", JSON.stringify(isLoggedIn));
  }, [isLoggedIn]);
  // Logic swap giữa 2 tab đăng nhập & đăng ký trong modal
  const [showSignInForm, setShowSignInForm] = useState(true);
  const [showSignUpForm, setShowSignUpForm] = useState(false);
  const [isButtonSignInClicked, setIsButtonSignInClicked] = useState(true);
  const [isButtonSignUpClicked, setIsButtonSignUpClicked] = useState(false);
  const buttonColor = isButtonSignInClicked ? "#30C5F7" : "gray";
  const buttonColor2 = isButtonSignUpClicked ? "#30C5F7" : "gray";

  const handleSwapToSignInForm = () => {
    setShowSignInForm(true);
    setShowSignUpForm(false);
    setIsButtonSignInClicked(true);
    setIsButtonSignUpClicked(false);
  };

  const handleSwapToSignUpForm = () => {
    setShowSignInForm(false);
    setShowSignUpForm(true);
    setIsButtonSignInClicked(false);
    setIsButtonSignUpClicked(true);
  };

  const handleShowForgotPasswordModal = () => {
    setShowSignIn(false);

    setShowForgotPasswordModal(true);
  };

  const navigate = useNavigate();

  // interface LoginResponse {
  //   data: {
  //     email: string;
  //     password: string;
  //     token: string;
  //     // Other properties if necessary...
  //   };
  // }

  let logoutTimer: ReturnType<typeof setTimeout>;
  function startLogoutTimer() {
    const logoutTime = 900000;
    clearTimeout(logoutTimer);
    logoutTimer = setTimeout(() => {
      timeOutSignOut();
    }, logoutTime);
  }

  function clearLogoutTimer() {
    clearTimeout(logoutTimer);
  }

  // const LogoutOnUnload = () => {
  //   useEffect(() => {
  //     const handleUnload = () => {
  //       handleSignOut();
  //     };
  //     window.addEventListener("beforeunload", handleUnload);
  //     return () => {
  //       window.removeEventListener("beforeunload", handleUnload);
  //     };
  //   }, []);
  //   return null;
  // };

  const handleSignIn = async () => {
    try {
      const response = await login({
        email: loginFormik.values.email,
        password: loginFormik.values.password,
      });

      // Checking if 'data' exists in the response
      if ("data" in response) {
        const responseData = response.data; // narrowing down the response to 'data' object

        if (responseData.user) {
          setIsLoggedIn(true);
          setShowSignIn(false);
          localStorage.setItem("user", JSON.stringify(responseData.user));
          localStorage.setItem("token", responseData.token);
          localStorage.removeItem("tempUser");
          await MySwal.fire({
            text: "Đăng nhập thành công.",
            icon: "success",
            // confirmButtonText: "OK",
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
          });

          startLogoutTimer();
          navigate("/");
        } else {
          MySwal.fire({
            text: "Đăng nhập thất bại.",
            icon: "warning",
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
          });
        }
      } else {
        // Handling the case where 'data' doesn't exist in the response
        console.error("Error in API response:", response.error);
        MySwal.fire({
          text: "Đăng nhập thất bại",
          icon: "warning",
          showCancelButton: false,
          showConfirmButton: false,
          timer: 2000,
          // confirmButtonText: "OK",
        });
      }
    } catch (error) {
      MySwal.fire({
        text: "Đăng nhập thất bại. Đã xảy ra lỗi kết nối.",
        icon: "warning",
        showCancelButton: false,
        showConfirmButton: false,
        timer: 2000,
        // confirmButtonText: "OK",
      });
    }
  };

  const handleSignOut = () => {
    clearLogoutTimer();
    MySwal.fire({
      text: "Đăng xuất thành công",
      icon: "success",
      showCancelButton: false,
      showConfirmButton: false,
      timer: 2000,
      // confirmButtonText: "OK",
    });
    setIsLoggedIn(false);
    localStorage.removeItem("user");
    localStorage.removeItem("billIdSuccess");
    localStorage.removeItem("token");
    navigate("/");
  };

  const timeOutSignOut = () => {
    clearLogoutTimer();
    MySwal.fire({
      text: "Hết thời hạn đăng nhập. Vui lòng đăng nhập lại",
      icon: "warning",
      showCancelButton: false,
      showConfirmButton: false,
      timer: 2000,
      // confirmButtonText: "OK",
    });
    setIsLoggedIn(false);
    localStorage.removeItem("user");
    localStorage.removeItem("billIdSuccess");
    localStorage.removeItem("token");
    navigate("/");
  };
  const handleRegister = async () => {
    // event.preventDefault();
    const variables = {
      email: registrationFormik.values.email,
      password: registrationFormik.values.password,
      name: registrationFormik.values.name,
      phone_number: registrationFormik.values.phone_number,
      c_password: registrationFormik.values.c_password,
    };

    if (registerPassword !== confirmPassword) {
      MySwal.fire({
        text: "Mật khẩu và xác nhận mật khẩu không khớp!",
        icon: "warning",

        // confirmButtonText: "OK",
      });
      return;
    }

    try {
      const response = await register(variables);

      // Type guard to differentiate between success and error responses
      if ("data" in response) {
        const userData = response.data.user;

        if (userData) {
          setIsLoggedIn(true);
          setShowSignIn(false);
          localStorage.setItem("user", JSON.stringify(userData));
          MySwal.fire({
            text: "Đăng ký thành công",
            icon: "success",
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
            // confirmButtonText: "OK",
          });
        } else {
          MySwal.fire({
            text: "Đăng ký thất bại, Email đã tồn tại",
            icon: "warning",
            // showCancelButton: false,
            // showConfirmButton: false,
            // timer: 2000
            // confirmButtonText: "OK",
          });
        }
      } else {
        // Handle error response
        console.error("Error in API response:");
      }
    } catch (error) {
      // Handle any errors here
      console.error(error);
    }
  };

  //validate
  const loginFormik = useFormik({
    initialValues: {
      email: "",
      password: "",
    },
    validationSchema: loginSchema,
    onSubmit: handleSignIn, // Your handleSignIn function
  });
  const registrationFormik = useFormik({
    initialValues: {
      name: "",
      email: "",
      password: "",
      phone_number: "",
      c_password: "",
    },
    validationSchema: registrationSchema,
    onSubmit: handleRegister, // Your handleRegister function
  });

  const preParseUserData = localStorage.getItem("user");
  let userData: { id: string; name: string; is_admin: number } | null = null;
  if (typeof preParseUserData === "string") {
    userData = JSON.parse(preParseUserData);
  }
  // console.log(userData);

  const userName = userData?.name;
  // console.log(userName);

  const is_admin = userData?.is_admin;

  const openWindow = () => {
    window.open("https://admin.vcdtt.online", "_blank");
  };
  const openWindow2 = () => {
    window.open("https://vcdtt.online/privacy_policy", "_blank");
  };
  //google login

  const { data: dataGoogle } = useGetLoginGoogleQuery();
  // console.log(dataGoogle);

  const [, setLoading] = useState(true);
  const [, setError] = useState(null);
  const [, setData] = useState<any>({});

  // Sau khi nhận được dữ liệu từ API Google
  const handleGoogleLoginSuccess = (googleUserData: {
    user: any;
    token: string;
  }) => {
    // Lưu thông tin người dùng và token vào localStorage
    localStorage.setItem("user", JSON.stringify(googleUserData.user));
    localStorage.setItem("token", googleUserData.token);

    // Đánh dấu người dùng đã đăng nhập thành công
    setIsLoggedIn(true);
    MySwal.fire({
      text: "Vào hệ thống thành công",
      icon: "success",
      showCancelButton: false,
      showConfirmButton: false,
      timer: 2000,
      // confirmButtonText: "OK",
    });
    // Chuyển hướng đến trang người dùng
    navigate("/"); // Đổi thành URL của trang người dùng của bạn
  };

  // ...

  // Trong useEffect sau khi fetch dữ liệu từ API Google

  const location = useLocation();

  // ... Các phần khác của component

  useEffect(() => {
    if (location && location.search) {
      fetch(
        `http://be-vcdtt.datn-vcdtt.test/api/auth/google/callback${location.search}`,
        { headers: new Headers({ accept: "application/json" }) }
      )
        .then((response) => {
          if (response.ok) {
            return response.json();
          }
          throw new Error("Something went wrong!");
        })
        .then((fetchedData) => {
          setData(fetchedData);
          setLoading(false);

          // Gọi hàm xử lý đăng nhập thành công với Google
          handleGoogleLoginSuccess(fetchedData);
        })
        .catch((fetchError) => {
          setError(fetchError);
          setLoading(false);
          console.error(fetchError);
        });
    }
  }, [location]);
  // console.log("data", data);

  //end google

  return (
    <>
      <header id="masthead" className="site-header header-primary">
        {/* <!-- header html start --> */}
        <div className="top-header"></div>
        <div className="bottom-header d-none d-md-block">
          <div className="container d-flex justify-content-between align-items-center">
            <div className="site-identity">
              <h1 className="site-title">
                <Link to="">
                  {dataLogo?.data.keyvalue.map(({ value }: Setting) => {
                    return (
                      <>
                        <img className="white-logo" src={value} alt="logo" />
                        <img className="black-logo" src={value} alt="logo" />
                      </>
                    );
                  })}
                </Link>
              </h1>
            </div>
            <div className="main-navigation d-none d-md-block">
              <nav id="navigation" className="navigation">
                <ul>
                  <li className="menu-item-has-children none">
                    <Link to={"/"}>Trang chủ</Link>
                  </li>
                  <li className="menu-item-has-children">
                    <a href="#">Danh mục</a>
                    <ul>
                      {dataCate?.data.categoriesParent.map(
                        ({ id, name }: Category) => {
                          return (
                            <li key={id}>
                              <a
                                href={`/search?tours%5BrefinementList%5D%5Bparent_category%5D%5B0%5D=${name}`}
                              >
                                {name}
                              </a>
                              {/* <a href="destination.html"></a> */}
                            </li>
                          );
                        }
                      )}
                    </ul>
                  </li>
                  <li className="menu-item-has-children none">
                    <Link to="blogs">Bài viết</Link>
                    {/* <ul>
                      <li>
                        <Link to="blogs/1">Bài viết 1</Link>
                      </li>
                      <li>
                        <Link to="blogs/2">Bài viết 2</Link>
                      </li>
                      <li>
                        <Link to="blogs/3">Bài viết 3</Link>
                      </li>
                    </ul> */}
                  </li>
                  <li className="menu-item-has-children none">
                    <Link to="contact">Liên hệ</Link>
                  </li>
                </ul>
              </nav>
            </div>
            <div className="header-btn">
              {isLoggedIn ? (
                <div>
                  {/* Hiển thị tên tài khoản sau khi đăng nhập thành công */}
                  <div className="user-profile">
                    <div className="main-navigation ">
                      <nav id="navigation" className="navigation">
                        <ul>
                          <li className="menu-item-has-children">
                            <Link to="/">{userName}</Link>
                            <ul>
                              <li>
                                <Link to="user/profile">Thông tin cá nhân</Link>
                              </li>
                              <li>
                                <Link to="user/tours">Tour đã mua</Link>
                              </li>
                              <li>
                                <Link to="user/favorite">Tour yêu thích</Link>
                              </li>
                              <li>
                                <Link to="user/coupon">Kho mã giảm giá</Link>
                              </li>
                              {is_admin == 1 || is_admin == 3 ? (
                                <li>
                                  <Link onClick={openWindow} to={""}>
                                    Đăng nhập admin
                                  </Link>
                                </li>
                              ) : null}

                              <li>
                                <a onClick={handleSignOut} href="#">
                                  Đăng xuất
                                </a>
                              </li>
                            </ul>
                          </li>
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
              ) : (
                <div className="">
                  <button
                    className="rounded button-primary"
                    onClick={handleShowSignIn}
                  >
                    ĐĂNG NHẬP/ĐĂNG KÝ
                  </button>

                  <Modal show={showSignIn} onHide={handleCloseSignIn}>
                    <Modal.Header closeButton></Modal.Header>
                    <Modal.Body>
                      <div className="d-flex mb-3">
                        <button
                          onClick={handleSwapToSignInForm}
                          className="w-100 border-0 p-3 border-right-1 text-white rounded-start"
                          style={{ backgroundColor: buttonColor }}
                        >
                          ĐĂNG NHẬP
                        </button>
                        <button
                          onClick={handleSwapToSignUpForm}
                          className="w-100 border-0 p-3 text-white rounded-end"
                          style={{ backgroundColor: buttonColor2 }}
                        >
                          ĐĂNG KÝ
                        </button>
                      </div>
                      {showSignInForm && (
                        <div>
                          <form onSubmit={loginFormik.handleSubmit}>
                            <div className="form-group">
                              <label htmlFor="" className="fw-bold">
                                Tài khoản <span className="text-danger">*</span>
                              </label>

                              <input
                                className="w-100 my-2 input-border"
                                type="email"
                                placeholder="Email"
                                name="email"
                                value={loginFormik.values.email}
                                onChange={loginFormik.handleChange}
                                onBlur={loginFormik.handleBlur}
                              />
                            </div>
                            {loginFormik.touched.email &&
                              loginFormik.errors.email && (
                                <div className="text-danger">
                                  {loginFormik.errors.email}
                                </div>
                              )}
                            <div className="form-group">
                              <label htmlFor="" className="fw-bold">
                                Mật khẩu <span className="text-danger">*</span>
                              </label>

                              <input
                                className="w-100 my-2 input-border"
                                type="password"
                                placeholder="Password"
                                name="password"
                                value={loginFormik.values.password}
                                onChange={loginFormik.handleChange}
                                onBlur={loginFormik.handleBlur}
                              />
                            </div>
                            {loginFormik.touched.password &&
                              loginFormik.errors.password && (
                                <div className="text-danger">
                                  {loginFormik.errors.password}
                                </div>
                              )}
                            <button
                              type="submit"
                              className="w-100 button-primary text-white py-3 my-3 border-0 rounded"
                            >
                              ĐĂNG NHẬP
                            </button>
                          </form>
                          <div className="d-flex justify-content-between">
                            <button
                              className="border-0 bg-white text-info"
                              onClick={handleSwapToSignUpForm}
                            >
                              Chưa có tài khoản? Đăng ký
                            </button>
                            <button
                              className="border-0 bg-white text-info"
                              onClick={handleShowForgotPasswordModal}
                            >
                              Quên mật khẩu
                            </button>
                          </div>
                          <h4 className="text-center my-3 fw-bold">
                            HOẶC ĐĂNG NHẬP VỚI
                          </h4>
                          <a className="App-link" href={dataGoogle?.url}>
                            <button className="p-2 w-100 border-0 my-2 bg-danger text-white rounded py-3">
                              <BsGoogle />

                              <span className="mx-2">Đăng nhập với Google</span>
                            </button>
                          </a>
                        </div>
                      )}
                      {showSignUpForm && (
                        <div>
                          <form onSubmit={registrationFormik.handleSubmit}>
                            <div className="form-group">
                              <label htmlFor="" className="fw-bold">
                                Tên tài khoản{" "}
                                <span className="text-danger">*</span>
                              </label>

                              <input
                                className="w-100 input-border"
                                type="text"
                                placeholder="Tên tài khoản"
                                name="name"
                                value={registrationFormik.values.name}
                                onChange={registrationFormik.handleChange}
                                onBlur={registrationFormik.handleBlur}
                              />
                            </div>
                            {registrationFormik.touched.name &&
                              registrationFormik.errors.name && (
                                <div className="text-danger">
                                  {registrationFormik.errors.name}
                                </div>
                              )}
                            <div className="form-group">
                              <label htmlFor="" className="fw-bold">
                                Email <span className="text-danger">*</span>
                              </label>
                              <input
                                className="w-100 input-border"
                                type="text"
                                placeholder="Email"
                                name="email"
                                value={registrationFormik.values.email}
                                onChange={registrationFormik.handleChange}
                                onBlur={registrationFormik.handleBlur}
                              />
                            </div>
                            {registrationFormik.touched.email &&
                              registrationFormik.errors.email && (
                                <div className="text-danger">
                                  {registrationFormik.errors.email}
                                </div>
                              )}
                            <div className="form-group">
                              <label htmlFor="" className="fw-bold">
                                Số điện thoại{" "}
                                <span className="text-danger">*</span>
                              </label>

                              <input
                                className="w-100 input-border"
                                type="text"
                                min={0}
                                placeholder="Số điện thoại"
                                name="phone_number"
                                value={registrationFormik.values.phone_number}
                                onChange={registrationFormik.handleChange}
                                onBlur={registrationFormik.handleBlur}
                              />
                            </div>
                            {registrationFormik.touched.phone_number &&
                              registrationFormik.errors.phone_number && (
                                <div className="text-danger">
                                  {registrationFormik.errors.phone_number}
                                </div>
                              )}
                            <div className="form-group">
                              <label htmlFor="" className="fw-bold">
                                Mật khẩu <span className="text-danger">*</span>
                              </label>
                              <input
                                className="w-100 input-border"
                                type="password"
                                placeholder="Nhập mật khẩu"
                                name="password"
                                value={registrationFormik.values.password}
                                onChange={registrationFormik.handleChange}
                                onBlur={registrationFormik.handleBlur}
                              />
                            </div>
                            {registrationFormik.touched.password &&
                              registrationFormik.errors.password && (
                                <div className="text-danger">
                                  {registrationFormik.errors.password}
                                </div>
                              )}
                            <div className="form-group">
                              <label htmlFor="" className="fw-bold">
                                Nhập lại mật khẩu{" "}
                                <span className="text-danger">*</span>
                              </label>

                              <input
                                className="w-100 input-border"
                                type="password"
                                placeholder="Nhập lại mật khẩu"
                                name="c_password"
                                value={registrationFormik.values.c_password}
                                onChange={registrationFormik.handleChange}
                                onBlur={registrationFormik.handleBlur}
                              />
                            </div>
                            {registrationFormik.touched.c_password &&
                              registrationFormik.errors.c_password && (
                                <div className="text-danger">
                                  {registrationFormik.errors.c_password}
                                </div>
                              )}
                            {/* <input type="checkbox" /> */}
                            <span className="ml-2 text-muted">
                              Bạn bấm vào đăng ký tức là bạn đã đồng ý với{" "}
                              <Link to={""} onClick={openWindow2}>
                                Chính sách & quyền riêng tư
                              </Link>{" "}
                              của trang
                            </span>
                            <button
                              type="submit"
                              className="w-100 button-primary text-white py-3 my-3 border-0 rounded"
                            >
                              ĐĂNG KÝ
                            </button>
                          </form>
                          <div className="d-flex justify-content-between">
                            <button
                              className="border-0 bg-white text-info"
                              onClick={handleSwapToSignInForm}
                            >
                              Đã có tài khoản? Đăng nhập
                            </button>
                          </div>
                          <h4 className="text-center my-3 fw-bold">
                            HOẶC ĐĂNG KÝ VỚI
                          </h4>
                          <a className="App-link" href={dataGoogle?.url}>
                            <button className="p-2 w-100 border-0 my-2 bg-danger text-white rounded py-3">
                              <BsGoogle />

                              <span className="mx-2">Đăng ký với Google</span>
                            </button>
                          </a>
                        </div>
                      )}
                    </Modal.Body>
                  </Modal>
                  {showForgotPasswordModal && (
                    <ForgotPasswordModal
                      show={showForgotPasswordModal}
                      onClose={() => setShowForgotPasswordModal(false)}
                    />
                  )}
                </div>
              )}
              <div></div>
            </div>
          </div>
        </div>
        <div className="d-block d-md-none bg-white" style={{ zIndex: "99" }}>
          <Navbar expand="lg" className="bg-body-tertiary">
            <Container>
              <Navbar.Brand href="/">
                {dataLogo?.data.keyvalue.map(({ value }: Setting) => {
                  return (
                    <>
                      <img
                        className="white-logo"
                        src={value}
                        alt="logo"
                        style={{ width: "120px" }}
                      />
                    </>
                  );
                })}
              </Navbar.Brand>
              <Navbar.Toggle aria-controls="basic-navbar-nav" />

              <Navbar.Collapse
                id="basic-navbar-nav "
                style={{ textAlign: "right" }}
                className=""
              >
                <Nav
                  className="me-auto shadow bg-secondary"
                  style={{ float: "right", width: "50%" }}
                >
                  {isLoggedIn ? (
                    <Dropdown>
                      <Dropdown.Toggle
                        className="w-100 text-end bg-white text-primary border-0 fs-3 fw-bold rounded-0"
                        variant="secondary"
                        id="dropdown-basic"
                      >
                        {userName}
                      </Dropdown.Toggle>

                      <Dropdown.Menu
                        className="text-end border-0 rounded-0"
                        style={{ background: "#DEE2E6" }}
                      >
                        <Dropdown.Item>
                          <Link to={"/user/profile"}>Thông tin cá nhân</Link>
                        </Dropdown.Item>
                        <Dropdown.Item>
                          <Link to={"/user/tours"}>Tour đã mua</Link>
                        </Dropdown.Item>
                        <Dropdown.Item>
                          <Link to={"/user/favorite"}>Tour yêu thích</Link>
                        </Dropdown.Item>
                        <Dropdown.Item>
                          <Link to={"/user/coupon"}> Kho mã giảm giá</Link>
                        </Dropdown.Item>
                        <Dropdown.Item onClick={handleSignOut}>
                          Đăng xuất
                        </Dropdown.Item>
                      </Dropdown.Menu>
                    </Dropdown>
                  ) : (
                    <button
                      className="border-0 bg-sec button-primary"
                      onClick={handleShowSignIn}
                    >
                      Đăng nhập/Đăng ký
                    </button>
                  )}
                  <hr />
                  <button className="bg-white border-0 py-2 text-end pr-3 fs-4">
                    <Link to={`/`}>Trang chủ</Link>
                  </button>
                  <button className="bg-white border-0 py-2 text-end pr-3 fs-4">
                    <Link to={`/blogs`}>Bài viết</Link>
                  </button>
                  <button className="bg-white border-0 py-2 text-end pr-3 fs-4">
                    <Link to={`/contact`}>Liên hệ</Link>
                  </button>
                  <hr />
                  <Dropdown>
                    <Dropdown.Toggle
                      className="w-100 text-end bg-white text-primary border-0 rounded-0"
                      variant="secondary"
                      id="dropdown-basic"
                    >
                      Danh mục
                    </Dropdown.Toggle>

                    <Dropdown.Menu
                      className="shadow text-end text-end border-0 rounded-0"
                      style={{ background: "#DEE2E6" }}
                    >
                      {dataCate?.data.categoriesParent.map(
                        ({ id, name }: Category) => {
                          return (
                            <Dropdown.Item key={id}>
                              <a
                                href={`/search?tours%5BrefinementList%5D%5Bparent_category%5D%5B0%5D=${name}`}
                              >
                                {name}
                              </a>
                              {/* <a href="destination.html"></a> */}
                            </Dropdown.Item>
                          );
                        }
                      )}
                    </Dropdown.Menu>
                  </Dropdown>
                </Nav>
              </Navbar.Collapse>
            </Container>
          </Navbar>
        </div>
      </header>
      {/* <a id="backTotop" href="#" className="to-top-icon">
        <i className="fas fa-chevron-up"></i>
      </a> */}
    </>
  );
};

export default Header;
