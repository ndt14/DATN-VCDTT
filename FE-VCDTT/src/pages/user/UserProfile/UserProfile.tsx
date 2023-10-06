import React from "react";
import "./UserProfile.css";

const UserProfile = () => {
  return (
    <section className="container" style={{ marginBottom: "200px" }}>
      <div style={{ height: "200px" }}></div>
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
                <h3>Vũ Hồng Thái</h3>
                <p>hongthai96961996@gmail.com</p>
              </div>
            </div>
            <hr />
            {/* Left panel */}
            <nav>
              <ul className="nav row" id="myTab" role="tablist">
                <li className="nav-item" role="presentation">
                  <button
                    className="nav-link border-0 btn w-100"
                    data-bs-toggle="tab"
                    data-bs-target="#user-info"
                    type="button"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                  >
                    Chỉnh sửa
                  </button>
                </li>
                <li className="nav-item" role="presentation">
                  <button
                    className="nav-link border-0 btn w-100"
                    id="-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#tour-ordered"
                    type="button"
                    role="tab"
                    aria-controls="contact"
                    aria-selected="false"
                  >
                    Tour đã đặt
                  </button>
                </li>

                <li className="nav-item" role="presentation">
                  <button
                    className="nav-link border-0 btn w-100"
                    data-bs-toggle="tab"
                    data-bs-target="#tour-favorite"
                    type="button"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                  >
                    Tour yêu thích
                  </button>
                </li>
              </ul>
            </nav>
            {/* End left panel */}
          </div>
        </div>
        <div className="col-8">
          {/*  */}
          <div className="tab-content">
            <div className="tab-pane border fade show active" id="user-info">
              <ul className="nav nav-tabs" id="myTab" role="tablist">
                <li className="nav-item" role="presentation">
                  <button
                    className="nav-link active"
                    id="home-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#home"
                    type="button"
                    role="tab"
                    aria-controls="home"
                    aria-selected="true"
                  >
                    Thông tin cá nhân
                  </button>
                </li>
                <li className="nav-item" role="presentation">
                  <button
                    className="nav-link"
                    id="profile-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#profile"
                    type="button"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                  >
                    Chỉnh sửa thông tin
                  </button>
                </li>
                <li className="nav-item" role="presentation">
                  <button
                    className="nav-link"
                    id="contact-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#contact"
                    type="button"
                    role="tab"
                    aria-controls="contact"
                    aria-selected="false"
                  >
                    Chỉnh sửa mật khẩu
                  </button>
                </li>
              </ul>
              <div className="tab-content p-3">
                <div className="tab-content" id="myTabContent">
                  <div
                    className="tab-pane fade show active p-3"
                    id="home"
                    role="tabpanel"
                    aria-labelledby="home-tab"
                  >
                    <form action="">
                      <label className="my-2" htmlFor="">
                        Họ và tên:
                      </label>
                      <br />
                      <input
                        type="text"
                        className="bg-secondary text-white"
                        disabled
                        value={"Vũ Hồng Thái"}
                      />{" "}
                      <br />
                      <label className="my-2" htmlFor="">
                        Số điện thoại:
                      </label>
                      <br />
                      <input type="text" disabled value={"0904604796"} /> <br />
                      <label className="my-2" htmlFor="">
                        Địa chỉ:
                      </label>
                      <br />
                      <input
                        type="text"
                        disabled
                        value={"Linh Đàm, Hà Nội"}
                      />{" "}
                      <br />
                      <label className="my-2" htmlFor="">
                        Ngày sinh:
                      </label>
                      <br />
                      <input type="text" disabled value={"09/06/1996"} /> <br />
                      <label className="my-2" htmlFor="">
                        Giới tính:
                      </label>
                      <br />
                      <input type="text" disabled value={"Nam"} /> <br />
                    </form>
                  </div>
                  <div
                    className="tab-pane fade p-3"
                    id="profile"
                    role="tabpanel"
                    aria-labelledby="profile-tab"
                  >
                    <form action="">
                      <label className="my-2" htmlFor="">
                        Họ và tên:
                      </label>
                      <br />
                      <input type="text" value={"Vũ Hồng Thái"} /> <br />
                      <label className="my-2" htmlFor="">
                        Số điện thoại:
                      </label>
                      <br />
                      <input type="text" value={"0904604796"} /> <br />
                      <label className="my-2" htmlFor="">
                        Địa chỉ:
                      </label>
                      <br />
                      <input type="text" value={"Linh Đàm, Hà Nội"} /> <br />
                      <label className="my-2" htmlFor="">
                        Ngày sinh:
                      </label>
                      <br />
                      <input type="text" value={"09/06/1996"} /> <br />
                      <label className="my-2" htmlFor="">
                        Giới tính:
                      </label>
                      <br />
                      <input type="text" value={"Nam"} /> <br />
                      <button type="submit">Lưu thông tin</button>
                    </form>
                  </div>
                  <div
                    className="tab-pane fade p-3"
                    id="contact"
                    role="tabpanel"
                    aria-labelledby="contact-tab"
                  >
                    <label className="my-2" htmlFor="">
                      Mật khẩu cũ
                    </label>
                    <br />
                    <input type="password" value={"12345678"} /> <br />
                    <label className="my-2" htmlFor="">
                      Mật khẩu mới
                    </label>
                    <br />
                    <input type="password" value={"12345678"} /> <br />
                    <label className="my-2" htmlFor="">
                      Xác nhận mật khẩu mới
                    </label>
                    <br />
                    <input type="password" value={"12345678"} /> <br />
                    <button type="submit">Đổi mật khẩu</button>
                  </div>
                </div>
              </div>
            </div>
            <div className="tab-pane border fade p-3" id="tour-ordered">
              <h3>Tour đã đặt</h3>
            </div>
            <div className="tab-pane border fade p-3" id="tour-favorite">
              <h3>Tour yêu thích</h3>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default UserProfile;
