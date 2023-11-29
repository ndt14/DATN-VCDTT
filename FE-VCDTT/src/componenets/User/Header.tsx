import { Link } from "react-router-dom";
import "../../../assets/js/modal.js";
// import { Modal, Form, Input, Checkbox, Button } from "antd";
import { useState, useEffect } from "react";
// import Button from "react-bootstrap/Button";
import Modal from "react-bootstrap/Modal";
import { BsGoogle, BsFacebook } from "react-icons/bs";
import { useLoginMutation, useRegisterMutation } from "../../api/auth.js";
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
import NavDropdown from "react-bootstrap/NavDropdown";
import { useGetLogoQuery } from "../../api/setting.js";
import { Setting } from "../../interfaces/Setting.js";

const Header = () => {
  const [login] = useLoginMutation();
  const [register] = useRegisterMutation();
  const { data: dataCate } = useGetCategoriesQuery();
  const {data: dataLogo} = useGetLogoQuery();

  
  // console.log(dataCate?.data.categoriesParent)

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [registerEmail, setRegisterEmail] = useState("");
  const [registerPassword, setRegisterPassword] = useState("");
  const [registerPhone, setRegisterPhone] = useState("");
  const [registerName, setRegisterName] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");

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
  const handleSignIn = async () => {
    // event.preventDefault();
    try {
      const { data } = await login({
        email: loginFormik.values.email, // Access email value from Formik
        password: loginFormik.values.password, // Access password value from Formik
      });
      console.log(data);

      if (data && data.user) {
        // Login successful
        setIsLoggedIn(true);
        setShowSignIn(false);
        localStorage.setItem("user", JSON.stringify(data.user));
        localStorage.setItem("accessToken", data.token);
        localStorage.removeItem("tempUser");
        alert("Đăng nhập thành công!");
        navigate("/");
      } else {
        // Invalid credentials or other login error
        alert("Đăng nhập thất bại. Vui lòng kiểm tra tài khoản và mật khẩu.");
      }
    } catch (error) {
      console.error("Lỗi đăng nhập: ", error);
      alert("Đăng nhập thất bại. Đã xảy ra lỗi kết nối.");
    }
  };

  const handleSignOut = () => {
    alert("Đăng xuất thành công");
    setIsLoggedIn(false);
    localStorage.removeItem("user");
    localStorage.removeItem("accessToken");
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
      alert("Mật khẩu và xác nhận mật khẩu không khớp!");
      return;
    }
    // console.log(variables);
    register(variables)
      .then((response) => {
        // Handle the response here
        if (response && response?.data.user) {
          setIsLoggedIn(true);
          setShowSignIn(false);

          const userName = response?.data.user;
          localStorage.setItem("user", JSON.stringify(userName));
          // localStorage.setItem("accessToken", response.token);
          alert("đăng ký thành công");
          // console.log(userName);
        } else {
          alert("đăng ký thất bại");
        }
      })
      .catch((error) => {
        // Handle any errors here
        console.error(error);
      });
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

  const userData = JSON.parse(localStorage.getItem("user"));
  console.log(userData);

  const userName = userData?.name;
  const is_admin = userData?.is_admin;

  const openWindow = () => {
    window.open("http://be-vcdtt.datn-vcdtt.test/", "_blank");
  };

  return (
    <>
      <header id="masthead" className="site-header header-primary">
        {/* <!-- header html start --> */}
        <div className="top-header"></div>
        <div className="bottom-header d-none d-lg-block d-sm-none">
          <div className="container d-flex justify-content-between align-items-center">
            <div className="site-identity">
              <h1 className="site-title">
             
                <Link to="">
                  {dataLogo?.data.keyvalue.map(({value}:Setting)=>{
                    return(
                      <>
                      <img
                    className="white-logo"
                    src={value}
                    alt="logo"
                  />
                    <img
                    className="black-logo"
                    src={value}
                    alt="logo"
                  />
                      </>
                    )
                  })}
                 
                
                </Link>
              </h1>
            </div>
            <div className="main-navigation d-none d-lg-block">
              <nav id="navigation" className="navigation">
                <ul>
                  <li className="menu-item-has-children">
                    <Link to={"/"}>Trang chủ</Link>
                  </li>
                  <li className="menu-item-has-children">
                    <a href="#">Danh mục</a>
                    <ul>
                      {dataCate?.data.categoriesParent.map(
                        ({ id, name }: Category) => {
                          return (
                            <li key={id}>
                              <Link
                                to={`/search?tours%5BrefinementList%5D%5Bparent_category%5D%5B0%5D=${name}`}
                              >
                                {name}
                              </Link>
                              {/* <a href="destination.html"></a> */}
                            </li>
                          );
                        }
                      )}
                    </ul>
                  </li>
                  <li className="menu-item-has-children">
                    <Link to="blogs">Bài viết</Link>
                    <ul>
                      <li>
                        <Link to="blogs/1">Bài viết 1</Link>
                      </li>
                      <li>
                        <Link to="blogs/2">Bài viết 2</Link>
                      </li>
                      <li>
                        <Link to="blogs/3">Bài viết 3</Link>
                      </li>
                    </ul>
                  </li>
                  <li className="menu-item-has-children">
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
                    <div className="main-navigation d-none d-lg-block">
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
                              {is_admin == 1 || is_admin == 3 ? (
                                <li>
                                  <Link onClick={openWindow}>
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
                            <button className="border-0 bg-white text-info">
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
                          <button className="p-2 w-100 border-0 my-2 bg-danger text-white rounded py-3">
                            <BsGoogle />
                            <span className="mx-2">Đăng nhập với Google</span>
                          </button>
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
                            <input type="checkbox" />
                            <span className="ml-2">
                              Tôi đồng ý với{" "}
                              <Link to={"/privacy_policy"}>Chính sách</Link> của
                              trang
                            </span>
                            <button
                              type="submit"
                              className="w-100 button-primary text-white py-3 my-3 border-0 rounded"
                            >
                              ĐĂNG KÝ
                            </button>
                          </form>
                          <div className="d-flex justify-content-between">
                            <button className="border-0 bg-white text-info">
                              Đã có tài khoản? Đăng nhập
                            </button>
                          </div>
                          <h4 className="text-center my-3 fw-bold">
                            HOẶC ĐĂNG KÝ VỚI
                          </h4>
                          <button className="p-2 w-100 border-0 my-2 bg-danger text-white rounded py-3">
                            <BsGoogle />
                            <span className="mx-2">Đăng ký với Google</span>
                          </button>
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
        <div className=" d-block d-sm-none bg-white" style={{ zIndex: "99" }}>
          <Navbar expand="lg" className="bg-body-tertiary">
            <Container>
              <Navbar.Brand href="/">
                <img
                  className="white-logo"
                  src="../../../assets/images/VCDTT_logo-removebg-preview.png"
                  alt="logo"
                  style={{ width: "120px" }}
                />
              </Navbar.Brand>
              <Navbar.Toggle aria-controls="basic-navbar-nav" />
              <Navbar.Collapse id="basic-navbar-nav">
                <Nav className="me-auto">
                  {isLoggedIn ? (
                    <NavDropdown title={userName} id="basic-nav-dropdown">
                      <NavDropdown.Item href="#action/3.1">
                        Thông tin cá nhân
                      </NavDropdown.Item>
                      <NavDropdown.Item href="#action/3.2">
                        Tour đã mua
                      </NavDropdown.Item>
                      <NavDropdown.Item href="#action/3.3">
                        Tour yêu thích
                      </NavDropdown.Item>
                      <NavDropdown.Divider />
                      <NavDropdown.Item href="#action/3.4">
                        Đăng xuất
                      </NavDropdown.Item>
                    </NavDropdown>
                  ) : (
                    <button className=" border-0" onClick={handleShowSignIn}>
                      Đăng nhập/Đăng ký
                    </button>
                  )}

                  <Nav.Link className="text-primary" href="">
                    Trang chủ
                  </Nav.Link>
                  <Nav.Link className="text-primary" href="#link">
                    Danh mục
                  </Nav.Link>
                  <Nav.Link className="text-primary" href="#link">
                    Bài viết
                  </Nav.Link>
                  <Nav.Link className="text-primary" href="/contact">
                    Liên hệ
                  </Nav.Link>
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
